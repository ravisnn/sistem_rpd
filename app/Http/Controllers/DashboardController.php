<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RencanaKegiatan;
use App\Models\Realisasi;
use App\Models\Akun;
use App\Models\Uraian;

class DashboardController extends Controller
{
    public function index()
    {
        $tahun = request('tahun', date('Y'));
        $totalRencana = RencanaKegiatan::whereYear('created_at', $tahun)->count();
        $totalRealisasi = Realisasi::whereYear('created_at', $tahun)->count();
        $totalAkun = Akun::count();
        $totalUraian = Uraian::count();
        $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
        $rencanaPerBulan = [];
        $realisasiPerBulan = [];
        foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'okt', 'nov', 'des'] as $i => $m) {
            $rencanaPerBulan[] = RencanaKegiatan::whereYear('created_at', $tahun)->sum($m);
            $realisasiPerBulan[] = Realisasi::whereYear('created_at', $tahun)->sum($m);
        }
        $akuns = Akun::orderBy('kode')->get();
        $chartLabels = $bulan;
        $chartDatasets = [];
        // Ringkasan per Output, Unit Kerja, dan Jenis Belanja
        $summaryOutput = [];
        $summaryUnitKerja = [];
        $dataRencana = RencanaKegiatan::whereYear('created_at', $tahun)->get();
        $dataRealisasi = Realisasi::whereYear('created_at', $tahun)->get();
        $unitKerjaList = RencanaKegiatan::select('unit_kerja')->distinct()->pluck('unit_kerja');
        $bulanLabels = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'okt', 'nov', 'des'];
        // Output aggregated by (output + kegiatan)
        foreach ($dataRencana as $item) {
            $output = $item->output;
            $kegiatan = $item->kegiatan ?? '';
            $key = $kegiatan . '|' . $output;
            if (!isset($summaryOutput[$key])) $summaryOutput[$key] = [
                'output' => $output,
                'kegiatan' => $kegiatan,
                'total_pagu' => 0,
                'total_realisasi' => 0,
                'total_rpd' => 0
            ];
            $summaryOutput[$key]['total_pagu'] += (int)$item->target;
            foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'okt', 'nov', 'des'] as $m) {
                $summaryOutput[$key]['total_rpd'] += (int)$item->$m;
            }
        }
        foreach ($dataRealisasi as $item) {
            $output = $item->output;
            $kegiatan = $item->kegiatan ?? '';
            $key = $kegiatan . '|' . $output;
            $sum = 0;
            foreach ($bulanLabels as $m) $sum += (int)$item->$m;
            if (!isset($summaryOutput[$key])) {
                $summaryOutput[$key] = [
                    'output' => $output,
                    'kegiatan' => $kegiatan,
                    'total_pagu' => 0,
                    'total_realisasi' => 0,
                    'total_rpd' => 0
                ];
            }
            $summaryOutput[$key]['total_realisasi'] += $sum;
        }
        // Sort summaryOutput ascending by kegiatan and output
        $summaryOutput = collect($summaryOutput)->sortBy([['kegiatan', 'asc'], ['output', 'asc']])->values()->all();
        // Statistik dari summaryOutput
        $totalPagu = array_sum(array_column($summaryOutput, 'total_pagu'));
        $totalRealisasiNominal = array_sum(array_column($summaryOutput, 'total_realisasi'));
        $totalSelisih = $totalPagu - $totalRealisasiNominal;
        // Unit Kerja
        foreach ($unitKerjaList as $uk) {
            $totalPaguUK = $dataRencana->where('unit_kerja', $uk)->sum('target');
            $totalRpd = 0;
            $totalRealisasi = 0;
            foreach ($bulanLabels as $m) {
                $totalRpd += $dataRencana->where('unit_kerja', $uk)->sum($m);
                $totalRealisasi += $dataRealisasi->where('unit_kerja', $uk)->sum($m);
            }
            $summaryUnitKerja[$uk] = [
                'total_pagu' => $totalPaguUK,
                'total_rpd' => $totalRpd,
                'total_realisasi' => $totalRealisasi,
                'deviasi' => $totalRpd - $totalRealisasi
            ];
        }
        // summaryJenisBelanja tetap
        $summaryJenisBelanja = [];
        foreach ($dataRencana as $item) {
            $jenis = $item->jenis_belanja;
            if (!isset($summaryJenisBelanja[$jenis])) $summaryJenisBelanja[$jenis] = ['total' => 0];
            $summaryJenisBelanja[$jenis]['total'] += (int)$item->target;
        }
        foreach ($dataRealisasi as $item) {
            $jenis = $item->jenis_belanja;
            if (!isset($summaryJenisBelanja[$jenis])) $summaryJenisBelanja[$jenis] = ['total' => 0];
            $sum = 0;
            foreach ($bulanLabels as $m) $sum += (int)$item->$m;
            $summaryJenisBelanja[$jenis]['total'] += $sum;
        }
        // Ringkasan Total per Jenis Belanja per Bulan (Semua Halaman) - realisasi
        $jenisBelanjaList = RencanaKegiatan::select('jenis_belanja')->distinct()->pluck('jenis_belanja');
        $bulanLabels = ['jan' => 'Jan', 'feb' => 'Feb', 'mar' => 'Maret', 'apr' => 'April', 'mei' => 'Mei', 'jun' => 'Juni', 'jul' => 'Juli', 'agt' => 'Agustus', 'sep' => 'September', 'okt' => 'Oktober', 'nov' => 'November', 'des' => 'Desember'];
        $summaryJenisBelanjaBulan = [];
        foreach ($jenisBelanjaList as $jb) {
            $summaryJenisBelanjaBulan[$jb] = [];
            foreach ($bulanLabels as $m => $label) {
                $summaryJenisBelanjaBulan[$jb][$m] = $dataRealisasi->where('jenis_belanja', $jb)->sum($m);
            }
        }
        // Ringkasan Total per Jenis Belanja per Bulan (Rencana)
        $summaryJenisBelanjaBulanRencana = [];
        foreach ($jenisBelanjaList as $jb) {
            $summaryJenisBelanjaBulanRencana[$jb] = [];
            foreach ($bulanLabels as $m => $label) {
                $summaryJenisBelanjaBulanRencana[$jb][$m] = $dataRencana->where('jenis_belanja', $jb)->sum($m);
            }
        }
        return view('dashboard.index', compact(
            'totalRencana',
            'totalRealisasi',
            'totalAkun',
            'totalUraian',
            'totalPagu',
            'totalRealisasiNominal',
            'totalSelisih',
            'bulan',
            'rencanaPerBulan',
            'realisasiPerBulan',
            'tahun',
            'chartLabels',
            'chartDatasets',
            'summaryOutput',
            'summaryUnitKerja',
            'summaryJenisBelanja',
            'summaryJenisBelanjaBulan',
            'summaryJenisBelanjaBulanRencana',
            'bulanLabels'
        ));
    }
}
