<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RencanaKegiatan;
use Illuminate\Support\Facades\DB;

class KertasKerjaController extends Controller
{
    public function index()
    {
        $tahunAktif = request('tahun', date('Y'));
        $kegiatanFilter = request('kegiatan');
        $outputFilter = request('output');
        // Ambil daftar tahun yang tersedia dari data RencanaKegiatan
        $tahunList = RencanaKegiatan::select(DB::raw('YEAR(created_at) as tahun'))->distinct()->orderBy('tahun','desc')->pluck('tahun')->toArray();
        if (!in_array($tahunAktif, $tahunList)) {
            $tahunList[] = $tahunAktif;
            sort($tahunList);
        }
    // Pagination removed
        // Hitung total target per akun
        $targetPerAkun = [];
        $allRencana = RencanaKegiatan::with(['akun'])
            ->whereYear('created_at', $tahunAktif)
            ->when($outputFilter, fn($q) => $q->where('output', $outputFilter))
            ->when($kegiatanFilter, fn($q) => $q->where('kegiatan', $kegiatanFilter))
            ->get();
        foreach ($allRencana as $item) {
            $akun = $item->akun->kode ?? '';
            if (!isset($targetPerAkun[$akun])) $targetPerAkun[$akun] = 0;
            $targetPerAkun[$akun] += $item->target;
        }
        // Ambil data RencanaKegiatan dan mapping ke struktur yang dibutuhkan view
        $allData = RencanaKegiatan::with(['akun', 'uraian'])
            ->whereYear('created_at', $tahunAktif)
            ->when($outputFilter, fn($q) => $q->where('output', $outputFilter))
            ->when($kegiatanFilter, fn($q) => $q->where('kegiatan', $kegiatanFilter))
            ->get();
        // Hitung total target per kombinasi output, kegiatan, dan akun
        $totalPaguOutputKegiatanAkun = [];
        foreach ($allData as $item) {
            $akunKode = $item->akun->kode ?? '-';
            $output = $item->output ?? '-';
            $kegiatan = $item->kegiatan ?? '-';
            $key = $output . '|' . $kegiatan . '|' . $akunKode;
            if (!isset($totalPaguOutputKegiatanAkun[$key])) $totalPaguOutputKegiatanAkun[$key] = 0;
            $totalPaguOutputKegiatanAkun[$key] += $item->target;
        }
        // Hitung total rpd per output-kegiatan-akun
        $totalRpdPerOutputKegiatanAkun = [];
        foreach ($allData as $item) {
            $akunKode = $item->akun->kode ?? '-';
            $output = $item->output ?? '-';
            $kegiatan = $item->kegiatan ?? '-';
            $key = $output . '|' . $kegiatan . '|' . $akunKode;
            if (!isset($totalRpdPerOutputKegiatanAkun[$key])) {
                $totalRpdPerOutputKegiatanAkun[$key] = [
                    'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0,
                    'jul' => 0, 'agt' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0
                ];
            }
            foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m) {
                $totalRpdPerOutputKegiatanAkun[$key][$m] += $item->$m;
            }
        }

        // Hitung total realisasi per output-kegiatan-akun per bulan
        $totalRealisasiPerOutputKegiatanAkun = [];
        $perRowRealisasi = [];
        $allRealisasi = \App\Models\Realisasi::with(['akun'])
            ->whereYear('created_at', $tahunAktif)
            ->when($outputFilter, fn($q) => $q->where('output', $outputFilter))
            ->when($kegiatanFilter, fn($q) => $q->where('kegiatan', $kegiatanFilter))
            ->get();
        foreach ($allRealisasi as $item) {
            $akunKode = $item->akun->kode ?? '-';
            $output = $item->output ?? '-';
            $kegiatan = $item->kegiatan ?? '-';
            $key = $output . '|' . $kegiatan . '|' . $akunKode;
            if (!isset($totalRealisasiPerOutputKegiatanAkun[$key])) {
                $totalRealisasiPerOutputKegiatanAkun[$key] = [
                    'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0,
                    'jul' => 0, 'agt' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0
                ];
            }
            foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m) {
                $totalRealisasiPerOutputKegiatanAkun[$key][$m] += $item->$m;
            }

            $rowKey = $output . '|' . $kegiatan . '|' . $akunKode . '|' . ($item->komponen ?? '') . '|' . ($item->uraian_id ?? '');
            if (!isset($perRowRealisasi[$rowKey])) {
                $perRowRealisasi[$rowKey] = [
                    'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0,
                    'jul' => 0, 'agt' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0
                ];
            }
            foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m) {
                $perRowRealisasi[$rowKey][$m] += $item->$m;
            }
        }

        $mappedData = [];
        foreach ($allData as $item) {
            $akunKode = $item->akun->kode ?? '-';
            $output = $item->output ?? '-';
            $kegiatan = $item->kegiatan ?? '-';
            $key = $output . '|' . $kegiatan . '|' . $akunKode;
            $rowKey = $output . '|' . $kegiatan . '|' . $akunKode . '|' . ($item->komponen ?? '') . '|' . ($item->uraian_id ?? '');
            $rowRpd = [
                'jan' => $item->jan ?? 0, 'feb' => $item->feb ?? 0, 'mar' => $item->mar ?? 0, 'apr' => $item->apr ?? 0,
                'mei' => $item->mei ?? 0, 'jun' => $item->jun ?? 0, 'jul' => $item->jul ?? 0, 'agt' => $item->agt ?? 0,
                'sep' => $item->sep ?? 0, 'okt' => $item->okt ?? 0, 'nov' => $item->nov ?? 0, 'des' => $item->des ?? 0,
            ];
            $realisasiRow = $perRowRealisasi[$rowKey] ?? [
                'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0,
                'jul' => 0, 'agt' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0,
            ];

            $mappedData[] = [
                'kegiatan' => $kegiatan,
                'output' => $output,
                'komponen' => $item->komponen,
                'jenis_belanja' => $item->jenis_belanja ?? '-',
                'unit_kerja' => $item->unit_kerja ?? '-',
                'akun_kode' => $akunKode,
                'pagu' => $item->target ?? 0,
                'total_pagu_output_akun' => $totalPaguOutputKegiatanAkun[$key] ?? ($item->target ?? 0),
                'rpd' => $rowRpd,
                'realisasi' => $realisasiRow,
                'total_rpd' => array_sum($rowRpd),
                'total_realisasi' => array_sum($realisasiRow),
            ];
        }
        // Hitung total RPD per bulan per output dan akun
        $totalRpdBulan = [];
        foreach ($mappedData as $row) {
            $output = $row['output'];
            $akun = $row['akun_kode'];
            foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m) {
                if (!isset($totalRpdBulan[$output][$akun][$m])) $totalRpdBulan[$output][$akun][$m] = 0;
                $totalRpdBulan[$output][$akun][$m] += $row['rpd'][$m] ?? 0;
            }
        }
        // Pagination removed, send all data
        $data = $mappedData;
    // Kirim semua data ke view untuk kebutuhan total pagu per output dan akun tanpa pagination
        $data_all = $mappedData;
        return view('kertas_kerja.index', compact('tahunList', 'tahunAktif', 'targetPerAkun', 'data', 'totalRpdBulan', 'data_all', 'kegiatanFilter', 'outputFilter'));
    }
}
