<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RencanaKegiatan;

class MonitoringRpdController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        $data = \App\Models\RencanaKegiatan::whereYear('created_at', $tahun)->get();
        $dataRealisasi = \App\Models\Realisasi::whereYear('created_at', $tahun)->get();
        $unitKerjaList = \App\Models\RencanaKegiatan::select('unit_kerja')->distinct()->pluck('unit_kerja');
        $bulanLabels = ['jan' => 'Jan', 'feb' => 'Feb', 'mar' => 'Mar', 'apr' => 'Apr', 'mei' => 'Mei', 'jun' => 'Jun', 'jul' => 'Jul', 'agt' => 'Agt', 'sep' => 'Sep', 'okt' => 'Okt', 'nov' => 'Nov', 'des' => 'Des'];
        $rekap = [];
        $totalPaguPerUnitKerja = [];
        foreach ($unitKerjaList as $uk) {
            $rekap[$uk] = [];
            $totalPaguPerUnitKerja[$uk] = $data->where('unit_kerja', $uk)->sum('target');
            foreach ($bulanLabels as $m => $label) {
                // Gabungkan semua data per unit kerja, lalu jumlahkan nilai rpd per bulan
                $rpd = $data->where('unit_kerja', $uk)->sum($m);
                $realisasi = $dataRealisasi->where('unit_kerja', $uk)->sum($m);
                $deviasi = $rpd - $realisasi;
                $rekap[$uk][$m] = [
                    'rpd' => $rpd,
                    'realisasi' => $realisasi,
                    'deviasi' => $deviasi
                ];
            }
        }
        return view('monitoring_rpd.index', compact('rekap', 'tahun', 'unitKerjaList', 'bulanLabels', 'totalPaguPerUnitKerja'));
    }
}
