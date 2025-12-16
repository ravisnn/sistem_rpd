<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RencanaKegiatan;
use App\Models\Realisasi;
use App\Models\IkpaTarget;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        $data = RencanaKegiatan::whereYear('created_at', $tahun)->get();
        $jenisBelanjaList = RencanaKegiatan::select('jenis_belanja')->distinct()->pluck('jenis_belanja');
        // $data = Realisasi::whereYear('created_at', $tahun)->get();
        // $jenisBelanjaList = Realisasi::select('jenis_belanja')->distinct()->pluck('jenis_belanja');
        $bulanLabels = ['jan' => 'Jan', 'feb' => 'Feb', 'mar' => 'Mar', 'apr' => 'Apr', 'mei' => 'Mei', 'jun' => 'Jun', 'jul' => 'Jul', 'agt' => 'Agt', 'sep' => 'Sep', 'okt' => 'Okt', 'nov' => 'Nov', 'des' => 'Des'];
        $rekap = [];
        foreach ($jenisBelanjaList as $jb) {
            $rekap[$jb] = [];
            foreach ($bulanLabels as $m => $label) {
                $rekap[$jb][$m] = $data->where('jenis_belanja', $jb)->sum($m);
            }
        }
        // Ambil target dari database
        $targets = [];
        foreach (['51', '52', '53'] as $jenis) {
            for ($tw = 1; $tw <= 4; $tw++) {
                $target = IkpaTarget::where('jenis_belanja', $jenis)->where('triwulan', $tw)->where('tahun', $tahun)->first();
                $targets[$jenis][$tw] = $target ? $target->target : ($tw == 1 ? 15 : ($tw == 2 ? 50 : ($tw == 3 ? 70 : 90)));
            }
        }
        return view('laporan.index', compact('rekap', 'tahun', 'jenisBelanjaList', 'bulanLabels', 'targets'));
    }

    public function updateTarget(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        $jenis = $request->get('jenis_belanja');
        $triwulan = $request->get('triwulan');
        $target = $request->get('target');
        if (in_array($jenis, ['51', '52', '53']) && in_array($triwulan, [1, 2, 3, 4])) {
            IkpaTarget::updateOrCreate([
                'jenis_belanja' => $jenis,
                'triwulan' => $triwulan,
                'tahun' => $tahun
            ], [
                'target' => $target
            ]);
        }
        return redirect()->back()->with('success', 'Target berhasil diubah');
    }
}
