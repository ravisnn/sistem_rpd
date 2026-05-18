<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RencanaKegiatan;
use App\Models\Akun;
use App\Models\Uraian;
use App\Models\Kegiatan;
use App\Models\Output;
use Illuminate\Support\Facades\DB;

class RencanaKegiatanController extends Controller
{
    // Tampilkan halaman utama
    public function index()
    {
    $tahun = request('tahun', date('Y'));
    // Filter akun dinamis berdasarkan kegiatan dan output
    $kegiatanFilter = request('kegiatan', '');
    $outputFilter = request('output', '');
    $akunFilter = request('akun_id', '');
    $summaryAkunFilter = request('summary_akun_id', '');
    $summaryKegiatanFilter = request('summary_kegiatan', '');
    $summaryOutputFilter = request('summary_output', '');
    // Akun filter for summary: only show akun that match parent filters
    $summaryAkunsQuery = Akun::query();
    if ($summaryKegiatanFilter && $summaryOutputFilter) {
        $summaryAkunIds = RencanaKegiatan::whereYear('created_at', $tahun)
            ->where('kegiatan', $summaryKegiatanFilter)
            ->where('output', $summaryOutputFilter)
            ->pluck('akun_id')->unique();
        $summaryAkunsQuery = $summaryAkunsQuery->whereIn('id_akun', $summaryAkunIds);
    } elseif ($summaryKegiatanFilter) {
        $summaryAkunIds = RencanaKegiatan::whereYear('created_at', $tahun)
            ->where('kegiatan', $summaryKegiatanFilter)
            ->pluck('akun_id')->unique();
        $summaryAkunsQuery = $summaryAkunsQuery->whereIn('id_akun', $summaryAkunIds);
    } else {
        // Jika tidak ada filter kegiatan/output, tampilkan semua akun
        $summaryAkunsQuery = Akun::query();
    }
    $summaryAkuns = $summaryAkunsQuery->get();
        $akunsQuery = Akun::query();
        if ($kegiatanFilter && $outputFilter) {
            $akunIds = RencanaKegiatan::whereYear('created_at', $tahun)
                ->where('kegiatan', $kegiatanFilter)
                ->where('output', $outputFilter)
                ->pluck('akun_id')->unique();
            $akunsQuery = $akunsQuery->whereIn('id_akun', $akunIds);
        } elseif ($kegiatanFilter) {
            $akunIds = RencanaKegiatan::whereYear('created_at', $tahun)
                ->where('kegiatan', $kegiatanFilter)
                ->pluck('akun_id')->unique();
            $akunsQuery = $akunsQuery->whereIn('id_akun', $akunIds);
        }
        $akuns = $akunsQuery->orderBy('kode')->get();
        // Also provide a full akun list for modal dropdowns so modal can add records
        // for other kegiatan even when the page is filtered.
        $allAkuns = Akun::orderBy('kode')->get();
        // Filter data rencana juga berdasarkan akun jika dipilih
        // Pastikan $rencanaAll sudah didefinisikan sebelum filter akun
        $rencanaAllQuery = RencanaKegiatan::with(['akun', 'uraian'])->whereYear('created_at', $tahun);
        if ($kegiatanFilter) {
            $rencanaAllQuery = $rencanaAllQuery->where('kegiatan', $kegiatanFilter);
        }
        if ($outputFilter) {
            $rencanaAllQuery = $rencanaAllQuery->where('output', $outputFilter);
        }
        if ($akunFilter) {
            $rencanaAllQuery = $rencanaAllQuery->where('akun_id', $akunFilter);
        }
        $rencanaAll = $rencanaAllQuery->get();
        $uraians = Uraian::orderBy('kode')->get();
        // Ambil semua kegiatan unik dan urutkan ascending untuk filter dropdown
        $kegiatanOptions = Kegiatan::orderBy('kode')->pluck('kode');
        $kegiatanFilter = request('kegiatan', '');
        $outputFilter = request('output', '');
        // rencanaAll: seluruh data tanpa filter kegiatan/output
        $rencanaAll = RencanaKegiatan::with(['akun', 'uraian'])->whereYear('created_at', $tahun)->get();
        // Output dropdown logic: prefer DB-driven mapping via kegiatan->outputs
        $mainOutputOptions = collect();
        if ($kegiatanFilter) {
            $kegModel = Kegiatan::where('kode', (string)$kegiatanFilter)->with('outputs')->first();
            if ($kegModel && $kegModel->outputs->count() > 0) {
                $mainOutputOptions = $kegModel->outputs->pluck('kode')->unique()->values();
            } else {
                // fallback to existing rencanaAll data
                $mainOutputOptions = $rencanaAll->where('kegiatan', (string)$kegiatanFilter)->pluck('output')->unique()->values();
            }
        } else {
            $mainOutputOptions = $rencanaAll->pluck('output')->unique()->values();
        }
        // Filter untuk Data Rencana (tabel utama)
        // Filter data: jika user memilih kegiatan dan output, tampilkan semua data yang sesuai (AND)
        $rencanaFiltered = $rencanaAll;
        if ($kegiatanFilter) {
            $rencanaFiltered = $rencanaFiltered->where('kegiatan', (string)$kegiatanFilter);
        }
        if ($outputFilter) {
            $rencanaFiltered = $rencanaFiltered->where('output', (string)$outputFilter);
        }
        if ($akunFilter) {
            $rencanaFiltered = $rencanaFiltered->where('akun_id', (string)$akunFilter);
        }
        $rencanaSorted = $rencanaFiltered->sortBy(function ($item) {
            $kegiatan = strtolower($item->kegiatan);
            $output = strtolower($item->output);
            $akunKode = strtolower($item->akun ? $item->akun->kode : '');
            $akunKodePadded = str_pad($akunKode, 3, '0', STR_PAD_RIGHT);
            $uraianKode = strtolower($item->uraian ? $item->uraian->kode : '');
            $uraianNama = strtolower($item->uraian ? $item->uraian->nama : '');
            $uraiansText = strtolower(trim($item->uraians ?? ''));
            return $kegiatan . '|' . $output . '|' . $akunKodePadded . '|' . $uraianKode . '|' . $uraianNama . '|' . $uraiansText;
        })->values();
        $rencanaPerPage = 5;
        // Jika user memilih filter kegiatan atau output, tampilkan semua data tanpa paginasi
        // kecuali jumlah baris hasil filter lebih dari 10 — dalam kasus itu gunakan
        // pagination dengan ukuran 10 per halaman. Untuk tanpa filter gunakan
        // pagination default (5 per halaman).
        if ($kegiatanFilter || $outputFilter) {
            $filteredCount = $rencanaSorted->count();
            if ($filteredCount > 5) {
                $rencanaPage = request('rencana_page', 1);
                $perPage = 5;
                $lastPage = max(1, ceil($filteredCount / $perPage));
                if ($rencanaPage > $lastPage) {
                    $rencanaItems = collect([]);
                } else {
                    $rencanaItems = $rencanaSorted->forPage($rencanaPage, $perPage)->values();
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
                // Preserve current query parameters (filters) when rendering links
                $rencana->appends(request()->except('rencana_page'));
            } else {
                $rencana = $rencanaSorted;
            }
        } else {
            $rencanaPage = request('rencana_page', 1);
            $rencanaTotal = $rencanaSorted->count();
            $lastPage = max(1, ceil($rencanaTotal / $rencanaPerPage));
            // Jika user akses halaman di luar range, tampilkan data kosong (tidak redirect)
            if ($rencanaPage > $lastPage) {
                $rencanaItems = collect([]);
            } else {
                $rencanaItems = $rencanaSorted->forPage($rencanaPage, $rencanaPerPage)->values();
            }
            $rencana = new \Illuminate\Pagination\LengthAwarePaginator(
                $rencanaItems,
                $rencanaTotal,
                $rencanaPerPage,
                $rencanaPage,
                [
                    'path' => request()->url(),
                    'pageName' => 'rencana_page',
                ]
            );
            // Preserve current query parameters (filters) when rendering links
            $rencana->appends(request()->except('rencana_page'));
        }

        // NOTE: do not mutate $rencanaAll here for special-case EBA.994; the view
        // already applies the EBA.994 filtering when rendering the table. Keeping
        // $rencanaAll as the full dataset ensures the kegiatan filter and dropdowns
        // can always read all data even when filters are active.

        // Filter untuk summary (ringkasan) -- TIDAK mempengaruhi tabel utama
        $summaryKegiatan = $summaryKegiatanFilter;
        $summaryOutput = $summaryOutputFilter;
        $summaryAkun = $summaryAkunFilter;
        $summary = [];
        foreach ($rencanaAll as $item) {
            if ($summaryKegiatan && $item->kegiatan !== $summaryKegiatan) continue;
            if ($summaryOutput && $item->output !== $summaryOutput) continue;
            if ($summaryAkun && (string)$item->akun_id !== (string)$summaryAkun) continue;
            $key = $item->kegiatan . '|' . $item->output . '|' . $item->akun->kode . '|' . $item->akun->nama;
            if (!isset($summary[$key])) {
                $summary[$key] = [
                    'kegiatan' => $item->kegiatan,
                    'output' => $item->output,
                    'akun' => $item->akun->kode . ' - ' . $item->akun->nama,
                    'total_pagu' => 0,
                    'total_rpd' => 0
                ];
            }
            $summary[$key]['total_pagu'] += $item->target;
            $rpd = 0;
            foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'okt', 'nov', 'des'] as $m) $rpd += (int)$item->$m;
            $summary[$key]['total_rpd'] += $rpd;
        }
        $sortedSummary = collect($summary)->sortBy([['kegiatan', 'asc'], ['output', 'asc'], ['akun', 'asc']])->values();
        $summaryPage = request('summary_page', 1);
        $summaryPerPage = 8;
        // Each visible row (not rowspan group) counts as one item for pagination
        $summaryTotal = $sortedSummary->count();
        $summaryPages = ceil($summaryTotal / $summaryPerPage);
        $summaryData = $sortedSummary->slice(($summaryPage - 1) * $summaryPerPage, $summaryPerPage);
        // Build outputMap from the pivot table `kegiatan_output` so mappings
        // are driven by DB relations rather than hardcoded values.
        // Map struktur: outputMap[output_kode][kegiatan_kode] = {akuns: [], uraians: []}
        $outputMap = [];
        $pivotRows = DB::table('kegiatan_output')
            ->join('outputs', 'kegiatan_output.output_id', '=', 'outputs.id_output')
            ->join('kegiatans', 'kegiatan_output.kegiatan_id', '=', 'kegiatans.id_kegiatan')
            ->select('outputs.kode as output_kode', 'kegiatans.kode as kegiatan_kode', 'kegiatan_output.akun_id', 'kegiatan_output.uraian_id')
            ->get();

        foreach ($pivotRows as $row) {
            $outputKode = $row->output_kode;
            $kegiatanKode = $row->kegiatan_kode;
            
            if (!isset($outputMap[$outputKode])) {
                $outputMap[$outputKode] = [];
            }
            if (!isset($outputMap[$outputKode][$kegiatanKode])) {
                $outputMap[$outputKode][$kegiatanKode] = [
                    'akuns' => [],
                    'uraians' => [],
                ];
            }
            
            if ($row->akun_id) {
                $outputMap[$outputKode][$kegiatanKode]['akuns'][] = $row->akun_id;
            }
            if ($row->uraian_id) {
                $outputMap[$outputKode][$kegiatanKode]['uraians'][] = $row->uraian_id;
            }
        }

        // Deduplicate lists and ensure arrays
        foreach ($outputMap as $outputKode => $kegiatanMap) {
            foreach ($kegiatanMap as $kegiatanKode => $mapping) {
                $outputMap[$outputKode][$kegiatanKode]['akuns'] = array_values(array_unique(array_filter($mapping['akuns'])));
                $outputMap[$outputKode][$kegiatanKode]['uraians'] = array_values(array_unique(array_filter($mapping['uraians'])));
            }
        }
        // Summary akun untuk ringkasan (max 10 per halaman, filter output)
        // ...existing code...
        // Output list untuk filter: prefer DB mapping when kegiatan filter present
        if ($kegiatanFilter) {
            $kegModel = Kegiatan::where('kode', (string)$kegiatanFilter)->with('outputs')->first();
            if ($kegModel && $kegModel->outputs->count() > 0) {
                $outputList = $kegModel->outputs->pluck('kode')->unique()->sort()->values();
            } else {
                $outputList = collect($rencanaAll)->pluck('output')->unique()->sort()->values();
            }
        } else {
            $outputList = collect($rencanaAll)->pluck('output')->unique()->sort()->values();
        }
        $selectedKegiatan = $kegiatanFilter;
        $selectedOutput = $outputFilter;
        $selectedSummaryKegiatan = $summaryKegiatan;
        $selectedSummaryOutput = $summaryOutput;

        // Load DB-driven kegiatan and outputs for modal/dropdowns
        $kegiatans = Kegiatan::orderBy('kode')->get();
        $allOutputs = Output::with('kegiatans')->get();

        // Build flat list of [kegiatanKode, outputKode] pairs for frontend filters
        $allOutputPairs = collect();
        foreach ($allOutputs as $o) {
            foreach ($o->kegiatans as $k) {
                $allOutputPairs->push([$k->kode, $o->kode]);
            }
        }
        $allOutputPairs = $allOutputPairs->unique()->values();

        return view('rencana.index', compact(
            'akuns',
            'summaryAkuns',
            'uraians',
            'rencana',
            'rencanaAll',
            'tahun',
            'outputMap',
            'summaryData',
            'summaryPage',
            'summaryPages',
            'summaryTotal',
            'summaryPerPage',
            'outputList',
            'summaryOutput',
            'selectedKegiatan',
            'selectedOutput',
            'selectedSummaryKegiatan',
            'selectedSummaryOutput',
            'kegiatanOptions',
            'kegiatans',
            'allOutputs',
            'allOutputPairs',
            'allAkuns'
        ));
    }

    // Simpan data baru (AJAX)
    public function store(Request $request)
    {
        $data = $request->validate([
            'kegiatan' => 'required|string',
            'uraians' => 'nullable|string',
            'komponen' => 'nullable|string',
            'jenis_belanja' => 'nullable|string',
            'unit_kerja' => 'nullable|string',
            'output' => 'required|string',
            'akun_id' => 'required|exists:akuns,id_akun',
            'uraian_id' => 'required|exists:uraians,id_uraian',
            'target' => 'required|integer',
            'jan' => 'integer',
            'feb' => 'integer',
            'mar' => 'integer',
            'apr' => 'integer',
            'mei' => 'integer',
            'jun' => 'integer',
            'jul' => 'integer',
            'agt' => 'integer',
            'sep' => 'integer',
            'okt' => 'integer',
            'nov' => 'integer',
            'des' => 'integer'
        ]);

        // Server-side duplicate prevention: check same kegiatan + output + akun_id + uraian_id + uraians (ignore unit_kerja, komponen, jenis_belanja)
        $tahun = $request->input('tahun', date('Y'));
        $uraiansTrim = trim($request->input('uraians', ''));
        $exists = RencanaKegiatan::whereYear('created_at', $tahun)
            ->where('kegiatan', $data['kegiatan'])
            ->where('output', $data['output'])
            ->where('akun_id', $data['akun_id'])
            ->where('uraian_id', $data['uraian_id'])
            ->whereRaw("COALESCE(TRIM(uraians),'') = ?", [$uraiansTrim])
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Data duplikat: kombinasi kegiatan/output/akun/uraian/uraians sudah ada untuk tahun tersebut.'], 409);
        }

        $rencana = RencanaKegiatan::create($data);
        return response()->json(['success' => true, 'id' => $rencana->id_rencana]);
    }

    // Update data (AJAX)
    public function update(Request $request, $id)
    {
        $rencana = RencanaKegiatan::findOrFail($id);
        $data = $request->validate([
            'kegiatan' => 'required|string',
            'uraians' => 'nullable|string',
            'komponen' => 'nullable|string',
            'jenis_belanja' => 'nullable|string',
            'unit_kerja' => 'nullable|string',
            'output' => 'required|string',
            'akun_id' => 'required|exists:akuns,id_akun',
            'uraian_id' => 'required|exists:uraians,id_uraian',
            'target' => 'required|integer',
            'jan' => 'integer',
            'feb' => 'integer',
            'mar' => 'integer',
            'apr' => 'integer',
            'mei' => 'integer',
            'jun' => 'integer',
            'jul' => 'integer',
            'agt' => 'integer',
            'sep' => 'integer',
            'okt' => 'integer',
            'nov' => 'integer',
            'des' => 'integer'
        ]);
        // Server-side duplicate prevention for update: exclude current id, check kegiatan+output+akun+uraian+uraians (ignore unit_kerja, komponen, jenis_belanja)
        $tahun = $request->input('tahun', date('Y'));
        $uraiansTrim = trim($request->input('uraians', ''));
        $exists = RencanaKegiatan::whereYear('created_at', $tahun)
            ->where('kegiatan', $data['kegiatan'])
            ->where('output', $data['output'])
            ->where('akun_id', $data['akun_id'])
            ->where('uraian_id', $data['uraian_id'])
            ->whereRaw("COALESCE(TRIM(uraians),'') = ?", [$uraiansTrim])
            ->where('id_rencana', '<>', $id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Data duplikat: kombinasi kegiatan/output/akun/uraian/uraians sudah ada untuk tahun tersebut.'], 409);
        }

        $rencana->update($data);
        return response()->json(['success' => true]);
    }

    // Hapus data (AJAX)
    public function destroy($id)
    {
        $rencana = RencanaKegiatan::findOrFail($id);
        $tahun = date('Y', strtotime($rencana->created_at));

        
        DB::transaction(function () use ($rencana, $tahun) {
            // Hapus semua realisasi yang memiliki kombinasi kegiatan, akun_id, uraian_id, dan tahun yang sama.
            \App\Models\Realisasi::where('kegiatan', $rencana->kegiatan)
                ->where('akun_id', $rencana->akun_id)
                ->where('uraian_id', $rencana->uraian_id)
                ->whereYear('created_at', $tahun)
                ->delete();

            $rencana->delete();
        });

        return response()->json(['success' => true]);
    }

    // JSON endpoint: return all rencana for a given year (default current year)
    public function allData(Request $request)
    {
        $tahun = $request->query('year', date('Y'));
        $rencanaAll = RencanaKegiatan::with(['akun', 'uraian'])->whereYear('created_at', $tahun)->get();
        return response()->json($rencanaAll);
    }

    // Tampil rencana kegiatan untuk user (read only)
    public function userIndex()
    {
        $tahun = request('tahun', date('Y'));
        $akuns = Akun::orderBy('kode')->get();
        $uraians = Uraian::orderBy('kode')->get();
        $rencana = RencanaKegiatan::with(['akun', 'uraian'])->whereYear('created_at', $tahun)->paginate(5);
        $rencanaAll = RencanaKegiatan::with(['akun', 'uraian'])->whereYear('created_at', $tahun)->get();
        // Ambil semua kegiatan unik dan urutkan ascending untuk filter dropdown (user)
        $kegiatanOptions = RencanaKegiatan::select('kegiatan')
            ->whereYear('created_at', $tahun)
            ->distinct()
            ->orderBy('kegiatan', 'asc')
            ->pluck('kegiatan');
        $kegiatanFilter = request('kegiatan', '');
        $outputFilter = request('output', '');
        // Output dropdown logic (sama seperti admin) - prefer DB-driven mapping
        if ($kegiatanFilter) {
            $kegModel = Kegiatan::where('kode', (string)$kegiatanFilter)->with('outputs')->first();
            if ($kegModel && $kegModel->outputs->count() > 0) {
                $mainOutputOptions = $kegModel->outputs->pluck('kode')->unique()->values();
            } else {
                $mainOutputOptions = $rencanaAll->where('kegiatan', (string)$kegiatanFilter)->pluck('output')->unique();
            }
        } else {
            $mainOutputOptions = $rencanaAll->pluck('output')->unique();
        }
        // Filter untuk Data Rencana (tabel utama)
        $rencanaFiltered = $rencanaAll;
        if ($kegiatanFilter) {
            $rencanaFiltered = $rencanaFiltered->where('kegiatan', (string)$kegiatanFilter);
        }
        if ($outputFilter) {
            $rencanaFiltered = $rencanaFiltered->where('output', (string)$outputFilter);
        }
        $rencanaSorted = $rencanaFiltered->sortBy(function($item) {
            $kegiatan = strtolower($item->kegiatan);
            $output = strtolower($item->output);
            $akunKode = strtolower($item->akun ? $item->akun->kode : '');
            $akunKodePadded = str_pad($akunKode, 3, '0', STR_PAD_RIGHT);
            $uraianKode = strtolower($item->uraian ? $item->uraian->kode : '');
            $uraianNama = strtolower($item->uraian ? $item->uraian->nama : '');
            $uraiansText = strtolower(trim($item->uraians ?? ''));
            return $kegiatan . '|' . $output . '|' . $akunKodePadded . '|' . $uraianKode . '|' . $uraianNama . '|' . $uraiansText;
        })->values();
        $rencanaPerPage = 5;
        if ($kegiatanFilter) {
            $rencana = $rencanaSorted;
        } else {
            $rencanaPage = request('rencana_page', 1);
            $rencanaTotal = $rencanaSorted->count();
            $rencanaItems = $rencanaSorted->forPage($rencanaPage, $rencanaPerPage)->values();
            $rencana = new \Illuminate\Pagination\LengthAwarePaginator(
                $rencanaItems,
                $rencanaTotal,
                $rencanaPerPage,
                $rencanaPage,
                [
                    'path' => request()->url(),
                    'pageName' => 'rencana_page',
                ]
            );
        }
        // Summary (ringkasan) tetap
        $summaryKegiatan = request('summary_kegiatan', '');
        $summaryOutput = request('summary_output', '');
        $summary = [];
        foreach ($rencanaAll as $item) {
            if ($summaryKegiatan && $item->kegiatan !== $summaryKegiatan) continue;
            if ($summaryOutput && $item->output !== $summaryOutput) continue;
            $key = $item->kegiatan . '|' . $item->output . '|' . $item->akun->kode . '|' . $item->akun->nama;
            if (!isset($summary[$key])) {
                $summary[$key] = [
                    'kegiatan' => $item->kegiatan,
                    'output' => $item->output,
                    'akun' => $item->akun->kode . ' - ' . $item->akun->nama,
                    'total_pagu' => 0,
                    'total_rpd' => 0
                ];
            }
            $summary[$key]['total_pagu'] += $item->target;
            $rpd = 0;
            foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'okt', 'nov', 'des'] as $m) $rpd += (int)$item->$m;
            $summary[$key]['total_rpd'] += $rpd;
        }
        $sortedSummary = collect($summary)->sortBy([['kegiatan', 'asc'], ['output', 'asc'], ['akun', 'asc']])->values();
        $summaryPage = request('summary_page', 1);
        $summaryPerPage = 8;
        $summaryTotal = $sortedSummary->count();
        $summaryPages = ceil($summaryTotal / $summaryPerPage);
        $summaryData = $sortedSummary->slice(($summaryPage - 1) * $summaryPerPage, $summaryPerPage);
        $outputList = collect($rencanaAll)->pluck('output')->unique()->sort()->values();
        $selectedKegiatan = $kegiatanFilter;
        $selectedOutput = $outputFilter;
        $selectedSummaryKegiatan = $summaryKegiatan;
        $selectedSummaryOutput = $summaryOutput;
        return view('rencana.index', compact(
            'akuns',
            'uraians',
            'rencana',
            'rencanaAll',
            'tahun',
            'outputMap',
            'summaryData',
            'summaryPage',
            'summaryPages',
            'summaryTotal',
            'summaryPerPage',
            'outputList',
            'summaryOutput',
            'kegiatanOptions',
            'selectedKegiatan',
            'selectedOutput',
            'selectedSummaryKegiatan',
            'selectedSummaryOutput',
            'mainOutputOptions'
        ));
    }
}
