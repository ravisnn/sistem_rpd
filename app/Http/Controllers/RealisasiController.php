<?php

namespace App\Http\Controllers;

use App\Models\Realisasi;
use App\Models\Akun;
use App\Models\Uraian;
use Illuminate\Http\Request;

class RealisasiController extends Controller
{
    public function index()
    {
        $tahun = request('tahun', date('Y'));
        $kegiatanFilter = request('kegiatan', '');
        $outputFilter = request('output', '');
        $perPage = 5;
        $rencanaAll = \App\Models\RencanaKegiatan::with(['akun','uraian'])->whereYear('created_at', $tahun)->get();
        if ($kegiatanFilter || $outputFilter) {
            $rencanaFiltered = $rencanaAll;
            if ($kegiatanFilter) {
                $rencanaFiltered = $rencanaFiltered->where('kegiatan', (string)$kegiatanFilter);
            }
            if ($outputFilter) {
                $rencanaFiltered = $rencanaFiltered->where('output', (string)$outputFilter);
            }
            // Tambahkan filter akun_id jika akun dipilih
            $akunFilter = request('akun_id', '');
            if ($akunFilter) {
                $rencanaFiltered = $rencanaFiltered->where('akun_id', (string)$akunFilter);
            }
            $rencanaSortedFiltered = $rencanaFiltered->sortBy(function($item) {
                $kegiatan = strtolower($item->kegiatan ?? '');
                $output = strtolower($item->output ?? '');
                $akunKode = strtolower($item->akun ? $item->akun->kode : '');
                $akunKodePadded = str_pad($akunKode, 3, '0', STR_PAD_RIGHT);
                $uraianKode = strtolower($item->uraian ? $item->uraian->kode : '');
                $uraianNama = strtolower($item->uraian ? $item->uraian->nama : '');
                $uraiansText = strtolower(trim($item->uraians ?? ''));
                return $kegiatan.'|'.$output.'|'.$akunKodePadded.'|'.$uraianKode.'|'.$uraianNama.'|'.$uraiansText;
            })->values();

            $filteredCount = $rencanaSortedFiltered->count();
            if ($filteredCount > 5) {
                $rencanaPage = request('rencana_page', 1);
                $perPage = 5;
                $lastPage = max(1, ceil($filteredCount / $perPage));
                if ($rencanaPage > $lastPage) {
                    $rencanaItems = collect([]);
                } else {
                    $rencanaItems = $rencanaSortedFiltered->forPage($rencanaPage, $perPage)->values();
                }
                $rencana = new \Illuminate\Pagination\LengthAwarePaginator(
                    $rencanaItems,
                    $filteredCount,
                    $perPage,
                    $rencanaPage,
                    [
                        'path' => request()->url(),
                        'pageName' => 'rencana_page',
                    ]
                );
                // Preserve filters on pagination links
                $rencana->appends(request()->except('rencana_page'));
            } else {
                $rencana = $rencanaSortedFiltered;
            }
        } else {
            $rencanaPage = request('rencana_page', 1);
            $rencanaSorted = $rencanaAll->sortBy(function($item) {
                $kegiatan = strtolower($item->kegiatan ?? '');
                $output = strtolower($item->output ?? '');
                $akunKode = strtolower($item->akun ? $item->akun->kode : '');
                $akunKodePadded = str_pad($akunKode, 3, '0', STR_PAD_RIGHT);
                $uraianKode = strtolower($item->uraian ? $item->uraian->kode : '');
                $uraianNama = strtolower($item->uraian ? $item->uraian->nama : '');
                $uraiansText = strtolower(trim($item->uraians ?? ''));
                return $kegiatan.'|'.$output.'|'.$akunKodePadded.'|'.$uraianKode.'|'.$uraianNama.'|'.$uraiansText;
            })->values();
            $rencanaTotal = $rencanaSorted->count();
            $lastPage = max(1, ceil($rencanaTotal / $perPage));
            // Jika user akses halaman di luar range, tampilkan data kosong (tidak redirect)
            if ($rencanaPage > $lastPage) {
                $rencanaItems = collect([]);
            } else {
                $rencanaItems = $rencanaSorted->forPage($rencanaPage, $perPage)->values();
            }
            $rencana = new \Illuminate\Pagination\LengthAwarePaginator(
                $rencanaItems,
                $rencanaTotal,
                $perPage,
                $rencanaPage,
                [
                    'path' => request()->url(),
                    'pageName' => 'rencana_page',
                ]
            );
            // Preserve current query parameters when rendering links
            $rencana->appends(request()->except('rencana_page'));
        }
        // Tetap ambil semua rencana kegiatan (tanpa paginate) untuk ringkasan summary
        $rencanaAll = \App\Models\RencanaKegiatan::with(['akun','uraian'])->whereYear('created_at', $tahun)->get();
        // Ambil semua realisasi, index by output-akun_id-uraian_id agar tidak duplikat antar output
        $realisasi = \App\Models\Realisasi::select(['id_realisasi','output','akun_id','uraian_id','uraians','jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'])
            ->whereYear('created_at', $tahun)
            ->get()
            ->keyBy(function($item) { return $item->output.'-'.$item->akun_id.'-'.$item->uraian_id.'-'.trim($item->uraians ?? ''); });

        // Output list (distinct output from rencana)
        if ($kegiatanFilter === '3365') {
            $outputList = collect(['DCF.001','SCF.002']);
        } elseif ($kegiatanFilter) {
            $outputList = $rencanaAll->where('kegiatan', (string)$kegiatanFilter)->pluck('output')->unique();
        } else {
            $outputList = $rencanaAll->pluck('output')->unique();
        }

        // Provide empty arrays for summaryData, summaryPages, summaryPage, outputRealisasiSummary, akuns, uraians to prevent undefined errors in view
        // Ringkasan total per kegiatan, output, akun
        $summaryKegiatan = request('summary_kegiatan', '');
        $summaryOutput = request('summary_output', '');
        $summaryAkunId = request('summary_akun_id', '');
        $summary = [];
        foreach($rencanaAll as $item) {
            if ($summaryKegiatan && $item->kegiatan !== $summaryKegiatan) continue;
            if ($summaryOutput && $item->output !== $summaryOutput) continue;
            if ($summaryAkunId && (string)$item->akun_id !== (string)$summaryAkunId) continue;
            $key = $item->kegiatan.'|'.$item->output.'|'.$item->akun->kode.'|'.$item->akun->nama;
            if (!isset($summary[$key])) {
                $summary[$key] = [
                    'kegiatan' => $item->kegiatan,
                    'output' => $item->output,
                    'akun' => $item->akun->kode.' - '.$item->akun->nama,
                    'total_pagu' => 0,
                    'total_rpd' => 0,
                    'total_realisasi' => 0
                ];
            }
            $summary[$key]['total_pagu'] += $item->target;
            $rpd = 0;
            foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m) $rpd += (int)$item->$m;
            $summary[$key]['total_rpd'] += $rpd;
            $realKey = $item->output.'-'.$item->akun_id.'-'.$item->uraian_id.'-'.trim($item->uraians ?? '');
            $real = $realisasi[$realKey] ?? null;
            $realTotal = 0;
            foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m) $realTotal += $real ? (int)$real->$m : 0;
            $summary[$key]['total_realisasi'] += $realTotal;
        }
        $sortedSummary = collect($summary)->sortBy([['kegiatan','asc'],['output','asc'],['akun','asc']])->values();
        $summaryPage = request('summary_page', 1);
        $summaryPerPage = 3;
        $summaryTotal = $sortedSummary->count();
        $summaryPages = ceil($summaryTotal / $summaryPerPage);
        // Jika user akses summary_page di luar range, redirect ke halaman 1
        if ($summaryPage > $summaryPages && $summaryPages > 0) {
            $params = request()->except('summary_page');
            $params['summary_page'] = 1;
            // Route name 'realisasi.index' may not be defined in all installations.
            // Redirect to current URL with adjusted query string instead.
            $url = url()->current() . '?' . http_build_query($params) . '#summary';
            return redirect()->to($url);
        }
        if ($summaryPages == 0) {
            $summaryData = collect([]);
        } else {
            $summaryData = $sortedSummary->slice(($summaryPage-1)*$summaryPerPage, $summaryPerPage);
        }

        // Filter akun dinamis berdasarkan parent (kegiatan & output)
        if ($kegiatanFilter) {
            if ($outputFilter) {
                $akunIds = $rencanaAll->where('kegiatan', $kegiatanFilter)
                    ->where('output', $outputFilter)
                    ->pluck('akun_id')->unique();
            } else {
                $akunIds = $rencanaAll->where('kegiatan', $kegiatanFilter)
                    ->pluck('akun_id')->unique();
            }
            // Dropdown akun berisi semua akun yang relevan dengan parent (bukan hanya akun yang dipilih)
            $akuns = Akun::whereIn('id_akun', $akunIds)->orderBy('kode')->get();
        } else {
            $akuns = collect([]);
        }
        $uraians = \App\Models\Uraian::whereIn('id_uraian', \App\Models\RencanaKegiatan::pluck('uraian_id')->unique())->orderBy('kode')->get();

        $selectedKegiatan = $kegiatanFilter;
        $selectedOutput = $outputFilter;
        $summaryOutput = request('summary_output', '');
        $selectedSummaryKegiatan = request('summary_kegiatan', '');
        $selectedSummaryOutput = $summaryOutput;
        // Summary Akuns: filter akun by output for summary filter dropdown
        if ($summaryOutput) {
            $summaryAkunIds = $rencanaAll->where('output', (string)$summaryOutput)->pluck('akun_id')->unique();
            $summaryAkuns = Akun::whereIn('id_akun', $summaryAkunIds)->get();
        } else {
            $summaryAkuns = Akun::all();
        }
        return view('realisasi.index', compact(
            'rencana','rencanaAll','realisasi','tahun','outputList','summaryData','summaryPages','summaryPage','akuns','uraians','summaryOutput',
            'selectedKegiatan','selectedOutput','selectedSummaryKegiatan','selectedSummaryOutput','summaryAkuns'
        ));
    }
    public function store(Request $request) {
        $rencana = \App\Models\RencanaKegiatan::findOrFail($request->rencana_kegiatan_id);

        $uraiansText = $request->uraians ?? $rencana->uraians ?? null;
        // Normalize empty string to null so DB unique index allows multiple NULLs
        $uraiansText = is_string($uraiansText) ? trim($uraiansText) : $uraiansText;
        // Treat empty string or single dash '-' as NULL (display will still show '-')
        if ($uraiansText === '' || $uraiansText === '-') $uraiansText = null;

        $data = [
            'kegiatan'     => $rencana->kegiatan,
            'uraians'      => $uraiansText,
            'komponen'     => $rencana->komponen,
            'jenis_belanja'=> $rencana->jenis_belanja,
            'unit_kerja'   => $rencana->unit_kerja,
            'output'       => $rencana->output,
            'akun_id'      => $rencana->akun_id,
            'uraian_id'    => $rencana->uraian_id,
            'target'       => $request->target ?? $rencana->target,
        ];

        foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m) {
            $data[$m] = $request->$m ?? 0;
        }

        // Scope duplicate detection to the selected year (use created_at year as canonical)
        $tahun = $request->input('tahun', date('Y'));
        // Cari apakah sudah ada record dengan kombinasi output-akun-uraian-uraians pada tahun yang sama
        $existingQuery = Realisasi::where('output', $rencana->output)
            ->where('akun_id', $rencana->akun_id)
            ->where('uraian_id', $rencana->uraian_id)
            ->whereYear('created_at', $tahun);
        if ($uraiansText === null) {
            $existingQuery = $existingQuery->whereNull('uraians');
        } else {
            $existingQuery = $existingQuery->where('uraians', $uraiansText);
        }
        $existing = $existingQuery->first();

        if ($existing) {
            // Jika sudah ada, lakukan update (menghindari duplicate key error)
            $existing->update($data);
            return response()->json(['success' => true, 'updated' => true, 'id' => $existing->id_realisasi]);
        }

        // Jika belum ada, coba buat. Jika terjadi race condition dan insert gagal
        // karena unique key, tangkap dan lakukan update pada record yang ada.
        try {
            $new = Realisasi::create($data);
            return response()->json(['success' => true, 'created' => true, 'id' => $new->id_realisasi]);
        } catch (\Illuminate\Database\QueryException $e) {
            // 1062 = duplicate entry
            $errorCode = $e->errorInfo[1] ?? null;
            if ($errorCode == 1062) {
                $existingQuery = Realisasi::where('output', $rencana->output)
                    ->where('akun_id', $rencana->akun_id)
                    ->where('uraian_id', $rencana->uraian_id)
                    ->whereYear('created_at', $tahun);
                if ($uraiansText === null) {
                    $existingQuery = $existingQuery->whereNull('uraians');
                } else {
                    $existingQuery = $existingQuery->where('uraians', $uraiansText);
                }
                $existing = $existingQuery->first();
                if ($existing) {
                    $existing->update($data);
                    return response()->json(['success' => true, 'updated' => true, 'id' => $existing->id_realisasi]);
                }
            }
            // Jika bukan duplicate key or unable to recover, rethrow for logging/error handling
            throw $e;
        }
    }

    public function update(Request $request, $id) {
        $item = \App\Models\Realisasi::findOrFail($id);
        $rencana = \App\Models\RencanaKegiatan::findOrFail($request->rencana_kegiatan_id);
        $data = [
            'kegiatan' => $rencana->kegiatan,
            'uraians' => $request->uraians ?? $rencana->uraians ?? null,
            'komponen' => $rencana->komponen,
            'jenis_belanja' => $rencana->jenis_belanja,
            'unit_kerja' => $rencana->unit_kerja,
            'output' => $rencana->output,
            'akun_id' => $rencana->akun_id,
            'uraian_id' => $rencana->uraian_id,
            'target'=> $request->target ?? $rencana->target,
        ];
        foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m) {
            $data[$m] = $request->$m ?? 0;
        }
        $item->update($data);
        return response()->json(['success'=>true]);
    }
    public function destroy($id) {
        Realisasi::destroy($id);
        return response()->json(['success'=>true]);
    }
}
