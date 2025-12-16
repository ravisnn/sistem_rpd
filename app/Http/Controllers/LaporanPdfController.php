<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RencanaKegiatan;
// use App\Models\Realisasi;
use App\Models\IkpaTarget;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class LaporanPdfController extends Controller
{
    public function preview(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        $triwulan = $request->get('triwulan', 1);
        $romawi = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV'];
        $triwulanRomawi = $romawi[$triwulan];
        // $jenisBelanjaList = Realisasi::select('jenis_belanja')->distinct()->pluck('jenis_belanja');
        // $data = Realisasi::whereYear('created_at', $tahun)->get();
        $jenisBelanjaList = RencanaKegiatan::select('jenis_belanja')->distinct()->pluck('jenis_belanja');
        $data = RencanaKegiatan::whereYear('created_at', $tahun)->get();
        $bulanLabels = ['jan' => 'Jan', 'feb' => 'Feb', 'mar' => 'Mar', 'apr' => 'Apr', 'mei' => 'Mei', 'jun' => 'Jun', 'jul' => 'Jul', 'agt' => 'Agt', 'sep' => 'Sep', 'okt' => 'Okt', 'nov' => 'Nov', 'des' => 'Des'];
        $rekap = [];
        foreach ($jenisBelanjaList as $jb) {
            $rekap[$jb] = [];
            foreach ($bulanLabels as $m => $label) {
                $rekap[$jb][$m] = $data->where('jenis_belanja', $jb)->sum($m);
            }
        }
        $orderJenis = ['51', '52', '53'];
        // Ambil target dari database jika diperlukan di pdf
        $targets = [];
        foreach (['51', '52', '53'] as $jenis) {
            for ($tw = 1; $tw <= 4; $tw++) {
                $target = IkpaTarget::where('jenis_belanja', $jenis)->where('triwulan', $tw)->where('tahun', $tahun)->first();
                $targets[$jenis][$tw] = $target ? $target->target : ($tw == 1 ? 15 : ($tw == 2 ? 50 : ($tw == 3 ? 70 : 90)));
            }
        }
        $pdf = PDF::loadView('laporan.pdf', compact('rekap', 'tahun', 'bulanLabels', 'orderJenis', 'triwulan', 'targets'));
        $filename = 'LAPORAN_RPD'. '_TAHUN_' . $tahun . '.pdf';
        return $pdf->stream($filename);
    }
}
