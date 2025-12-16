@extends('layouts.app')

@section('content')

<div style="display:flex; justify-content:center;">
  <div style="width:95%; max-width:1200px;">

    <!-- Filter Tahun -->
    <form method="get" class="flex items-center gap-2">
        <label for="tahun" class="text-base">Tahun:</label>
        <input type="number" 
               name="tahun" 
               id="tahun" 
               value="{{ $tahun ?? date('Y') }}" 
               min="2020" 
               max="2100" 
               class="form-tahun w-24 px-2 py-1 rounded border border-gray-300">
        <button type="submit" style="cursor: pointer; padding:4px 14px; border-radius:4px; background:#007bff; color:#fff; border:none; transition: 0.2s;"
          onmouseover="this.style.background='#0056b3'"
          onmouseout="this.style.background='#007bff'"
          >Tampilkan
        </button>
    </form>
    <h1 style="text-align:center; font-size:2.2rem;font-weight:700;letter-spacing:-1px; margin-bottom:10px;">Realisasi Tahun {{ $tahun ?? date('Y') }}</h1>

    <!-- ========== CARD UTAMA: MEMBUNGKUS TABEL + SEMUA RINGKASAN ========== -->
    <div class="card" style="background:linear-gradient(120deg,#f6f8fa 60%,#e3f0ff 100%); box-shadow:0 2px 16px #007bff22; padding:20px; border-radius:10px;">

      <!-- Kontrol & Filter Output -->
      <div class="controls" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
        <span class="controls-text" style="font-size:1.1rem;font-weight:500;">Data Realisasi</span>
        <div style="display:flex;align-items:center;gap:8px;">
          <label for="mainKegiatanFilter" style="margin:0;font-size:1em;">Kegiatan:</label>
          <select id="mainKegiatanFilter" style="padding:4px 8px; border-radius:4px; border:1px solid #ccc; width:120px;">
            <option value="">Semua</option>
            @php
              $kegiatanOptions = $rencanaAll->pluck('kegiatan')->unique()->sort();
            @endphp
            @foreach($kegiatanOptions as $keg)
              <option value="{{ $keg }}" @if((string)($selectedKegiatan ?? request('kegiatan')) === (string)$keg) selected @endif>{{ $keg }}</option>
            @endforeach
          </select>
          <label for="mainOutputFilter" style="margin:0;font-size:1em;">Output:</label>
          <select id="mainOutputFilter" style="padding:4px 8px; border-radius:4px; border:1px solid #ccc; width:120px;" @if(!($selectedKegiatan ?? request('kegiatan'))) disabled @endif>
            <option value="">@if(!($selectedKegiatan ?? request('kegiatan'))) Pilih Kegiatan dulu @else Semua @endif</option>
            @php
              $kegVal = $selectedKegiatan ?? request('kegiatan');
              $outVal = $selectedOutput ?? request('output');
              $mainOutputOptions = collect();

              if ($kegVal && $kegVal !== '') {
                  // Ambil semua output unik berdasarkan kegiatan, dinamis
                  $mainOutputOptions = $rencanaAll
                      ->where('kegiatan', (string)$kegVal)
                      ->pluck('output')
                      ->unique()
                      ->values();
              } else {
                  $mainOutputOptions = collect();
              }
            @endphp
            @if($selectedKegiatan ?? request('kegiatan'))
              @foreach($mainOutputOptions as $output)
                <option value="{{ $output }}" @if((string)$outVal === (string)$output) selected @endif>{{ $output }}</option>
              @endforeach
            @endif
          </select>
          <label for="mainAkunFilter" style="margin:0;font-size:1em;">Sub Komponen:</label>
          <select id="mainAkunFilter" name="akun_id" style="padding:4px 8px; border-radius:4px; border:1px solid #ccc; width:120px;" @if(!($selectedKegiatan ?? request('kegiatan')) || !($selectedOutput ?? request('output'))) disabled @endif>
            <option value="">
              @if(!($selectedKegiatan ?? request('kegiatan')))
                Pilih Kegiatan dulu
              @elseif(!($selectedOutput ?? request('output')))
                Pilih Output dulu
              @else
                Semua
              @endif
            </option>
            @if(($selectedKegiatan ?? request('kegiatan')) && ($selectedOutput ?? request('output')))
              @foreach($akuns as $akun)
                <option value="{{ $akun->id_akun }}" @if((string)request('akun_id') === (string)$akun->id_akun) selected @endif>{{ $akun->kode }} - {{ $akun->nama }}</option>
              @endforeach
            @endif
          </select>
        <script>
        // Filter dinamis utama: kegiatan harus dipilih dulu, output dan akun menyesuaikan parent
        const mainKegiatanEl = document.getElementById('mainKegiatanFilter');
        const mainOutputEl = document.getElementById('mainOutputFilter');
        const mainAkunEl = document.getElementById('mainAkunFilter');
        // Data mapping output per kegiatan
  const mainAllOutputs = @json($rencanaAll->map(fn($r)=>[$r->kegiatan,$r->output])->unique()->values());
        mainKegiatanEl.addEventListener('change', function() {
          const keg = this.value;
          let outputSet = new Set();
          if(keg === '3365') {
            outputSet.add('DCF.001');
            outputSet.add('SCF.002');
          } else if(keg && keg !== '') {
            mainAllOutputs.forEach(function(pair){
              if(pair[0] === keg) outputSet.add(pair[1]);
            });
          }
          mainOutputEl.innerHTML = '';
          const optAll = document.createElement('option');
          optAll.value = '';
          optAll.textContent = keg ? 'Semua' : 'Pilih Kegiatan dulu';
          mainOutputEl.appendChild(optAll);
          outputSet.forEach(function(out){
            const opt = document.createElement('option');
            opt.value = out;
            opt.textContent = out;
            mainOutputEl.appendChild(opt);
          });
          mainOutputEl.disabled = !keg;
          mainAkunEl.disabled = true;
          // Setelah update, reload halaman
          const url = new URL(window.location.href);
          if(keg) url.searchParams.set('kegiatan', keg); else url.searchParams.delete('kegiatan');
          url.searchParams.delete('output');
          url.searchParams.delete('akun_id');
          // When changing filters, always reset to page 1 to avoid stale page numbers
          url.searchParams.set('rencana_page', 1);
          window.location.href = url.toString();
        });
        mainOutputEl.addEventListener('change', function() {
          const keg = mainKegiatanEl.value;
          const val = this.value;
          // Enable akun only if output selected
          mainAkunEl.disabled = !val;
          const url = new URL(window.location.href);
          if(keg) url.searchParams.set('kegiatan', keg); else url.searchParams.delete('kegiatan');
          if(val) url.searchParams.set('output', val); else url.searchParams.delete('output');
          url.searchParams.delete('akun_id');
          // Reset to first page when parent filter changes
          url.searchParams.set('rencana_page', 1);
          window.location.href = url.toString();
        });
        mainAkunEl.addEventListener('change', function() {
          const keg = mainKegiatanEl.value;
          const out = mainOutputEl.value;
          const akun = this.value;
          const url = new URL(window.location.href);
          if(keg) url.searchParams.set('kegiatan', keg); else url.searchParams.delete('kegiatan');
          if(out) url.searchParams.set('output', out); else url.searchParams.delete('output');
          if(akun) url.searchParams.set('akun_id', akun); else url.searchParams.delete('akun_id');
          // Reset to first page after changing sub-komponen filter
          url.searchParams.set('rencana_page', 1);
          window.location.href = url.toString();
        });
        </script>
        </div>
      </div>

      <!-- Tabel Utama Realisasi -->
      <div class="table-wrap" style="overflow-x:auto;">
        <table id="mainTable" style="width:100%; background:#fff; border-radius:6px; border-collapse:collapse; color:#000; font-size:0.85rem;">
          <thead>
            <tr>
              <th style="text-align:center; vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">No</th>
              <th style="vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">Kegiatan</th>
              <th style="vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">Output/KRO/RO</th>
              <th style="vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">Komponen</th>
              <th style="text-align:center; vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">Jenis Belanja</th>
              <th style="text-align:center; vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">Bagian Kelompok Substansi</th>
              <th style="text-align:center; vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">Sub Komponen</th>
              <th style="text-align:center; vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">Akun</th>
              <th style="text-align:center; vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">Uraian Kegiatan</th>
              <th style="text-align:center; vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">Pagu</th>
              <th style="text-align:center; vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">RPD</th>
              <th colspan="12" style="text-align:center; border:1px solid #000;">Bulan</th>
              <th style="text-align:center; vertical-align:middle; border:1px solid #000;" rowspan="2">Realisasi</th>
              <th style="text-align:center; vertical-align:middle; border:1px solid #000;" rowspan="2">Selisih (RPD - Realisasi)</th>
              <th style="text-align:center; vertical-align:middle; border:1px solid #000;" rowspan="2">Aksi</th>
            </tr>
            <tr style="background:#e3f0ff; color:#000;">
              <th style="text-align:center; border:1px solid #000;">Januari</th>
              <th style="text-align:center; border:1px solid #000;">Februari</th>
              <th style="text-align:center; border:1px solid #000;">Maret</th>
              <th style="text-align:center; border:1px solid #000;">April</th>
              <th style="text-align:center; border:1px solid #000;">Mei</th>
              <th style="text-align:center; border:1px solid #000;">Juni</th>
              <th style="text-align:center; border:1px solid #000;">Juli</th>
              <th style="text-align:center; border:1px solid #000;">Agustus</th>
              <th style="text-align:center; border:1px solid #000;">September</th>
              <th style="text-align:center; border:1px solid #000;">Oktober</th>
              <th style="text-align:center; border:1px solid #000;">November</th>
              <th style="text-align:center; border:1px solid #000;">Desember</th>
            </tr>
          </thead>
          <tbody id="tableBody">
            @php
              // Selalu gunakan data hasil paginasi ($rencana) agar pagination tetap konsisten
                // Urutkan data paginasi berdasarkan kegiatan, output, akun, uraian, dan uraians (alphabetical)
                $sorted = $rencana->sortBy(function($item) {
                  $kegiatan = strtolower($item->kegiatan ?? '');
                  $output = strtolower($item->output ?? '');
                  $akunKode = strtolower($item->akun ? $item->akun->kode : '');
                  $akunKodePadded = str_pad($akunKode, 3, '0', STR_PAD_RIGHT);
                  $uraianKode = strtolower($item->uraian ? $item->uraian->kode : '');
                  $uraianNama = strtolower($item->uraian ? $item->uraian->nama : '');
                  $uraiansText = strtolower(trim($item->uraians ?? ''));
                  return $kegiatan.'|'.$output.'|'.$akunKodePadded.'|'.$uraianKode.'|'.$uraianNama.'|'.$uraiansText;
                });
            @endphp
            @foreach($sorted as $item)
              @php 
                // Ambil realisasi berdasarkan composite key output-akun_id-uraian_id-uraians (uraians sebagai pembeda)
                $uraiansKey = trim($item->uraians ?? '');
                $realKey = $item->output.'-'.$item->akun_id.'-'.$item->uraian_id.'-'.$uraiansKey;
                // Fallback: if no exact uraians match, accept a record with empty/NULL uraians
                $emptyKey = $item->output.'-'.$item->akun_id.'-'.$item->uraian_id.'-';
                $real = $realisasi[$realKey] ?? $realisasi[$emptyKey] ?? null;
              @endphp
              @php
                // compute continuous index for this row (supports paginator)
                if ($rencana instanceof \Illuminate\Pagination\LengthAwarePaginator || $rencana instanceof \Illuminate\Pagination\Paginator) {
                  $index = ($rencana->perPage() * ($rencana->currentPage() - 1)) + $loop->iteration;
                } else {
                  $index = $loop->iteration;
                }
              @endphp
              <tr data-id_rencana="{{ $item->id_rencana }}" data-id_realisasi="{{ $real ? $real->id_realisasi : '' }}"
                  @foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m)
                  data-{{ $m }}="{{ $real ? $real->$m : 0 }}"
                  @endforeach
                  style="transition:background 0.2s; color:#000; font-size:0.9rem;">
                <td style="text-align:center; border:1px solid #000;">{{ $index }}</td>
                <td style="text-align:center; border:1px solid #000;">{{ $item->kegiatan }}</td>
                <td style="text-align:center; border:1px solid #000;">{{ $item->output }}</td>
                <td style="text-align:center; border:1px solid #000;">{{ $item->komponen }}</td>
                <td style="text-align:center; border:1px solid #000;">{{ $item->jenis_belanja }}</td>
                <td style="text-align:center; border:1px solid #000;">{{ $item->unit_kerja }}</td>
                <td style="border:1px solid #000;"><span style="font-weight:600;color:#007bff;">{{ $item->akun->kode }}</span> <span style="color:#444;">- {{ $item->akun->nama }}</span></td>
                <td style="border:1px solid #000;"><span style="font-weight:600;color:#28a745;">{{ $item->uraian->kode }}</span> <span style="color:#444;">- {{ $item->uraian->nama }}</span></td>
                <td style="border:1px solid #000;">
                  @php
                      $raw = trim($item->uraians ?? '');

                      if ($raw === '') {
                          echo '-';
                      } else {
                          // Pecah berdasarkan koma
                          $parts = array_filter(array_map('trim', explode(',', $raw)));

                          // Deteksi apakah semua item adalah 1 kata (tanpa spasi)
                          $isList = true;
                          foreach ($parts as $p) {
                              if (str_contains($p, ' ')) { 
                                  $isList = false;
                                  break;
                              }
                          }

                          if ($isList && count($parts) > 1) {
                              // Jika benar-benar list → sort
                              usort($parts, fn($a, $b) => strcasecmp($a, $b));
                              echo implode(', ', $parts);
                          } else {
                              // Jika bukan list (kalimat dan mengandung spasi) → jangan sort
                              echo $raw;
                          }
                      }
                  @endphp
              </td>
                <td style="border:1px solid #000; text-align:right; font-weight:bold;">
                  <span style="white-space:nowrap;">Rp {{ number_format($item->target) }}</span>
                </td>
                <td style="border:1px solid #000; text-align:right;">
                  <span style="white-space:nowrap; font-weight:bold; color:#000;">Rp {{ number_format(
                    collect(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'])->reduce(function($carry, $m) use ($item) {
                      return $carry + ((isset($item->$m)) ? (int)$item->$m : 0);
                    }, 0)
                  ) }}</span>
                </td>
                @foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m)
                  <td style="border:1px solid #000; text-align:right;">
                    <span style="white-space:nowrap;">Rp {{ number_format((isset($real) && isset($real->$m)) ? $real->$m : 0) }}</span>
                  </td>
                @endforeach
                <td style="border:1px solid #000; text-align:right;font-weight:bold;">
                  <span style="white-space:nowrap;">Rp {{ number_format(
                    collect(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'])->reduce(function($carry, $m) use ($real) {
                      return $carry + ((isset($real) && isset($real->$m)) ? (int)$real->$m : 0);
                    }, 0)
                  ) }}</span>
                </td>
                <td style="border:1px solid #000; text-align:right; font-weight:bold; color:red;">
                  @php
                    $rpdVal = collect(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'])->reduce(function($carry, $m) use ($item) {
                      return $carry + ((isset($item->$m)) ? (int)$item->$m : 0);
                    }, 0);
                    $realVal = collect(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'])->reduce(function($carry, $m) use ($real) {
                      return $carry + ((isset($real) && isset($real->$m)) ? (int)$real->$m : 0);
                    }, 0);
                  @endphp
                  <span style="white-space:nowrap;">Rp {{ number_format($rpdVal - $realVal) }}</span>
                </td>
                <td style="border:1px solid #000;">
                  <button class="btn warning" style="vertical-align:middle; padding:2px 6px; background:#ffc107; color:#000; border:none;  border-radius:4px; cursor:pointer; transition:0.2s;"
                    onmouseover="this.style.background='#e0a800'"
                    onmouseout="this.style.background='#ffc107'"
                    >✎
                  </button>
                </td>
              </tr>

            @endforeach
            @if($rencana->count() === 0)
              <tr>
                <td colspan="26" style="text-align:center; color:#888; font-style:italic; border:1px solid #000;">Tidak ada data</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>

      <!-- Pagination Summary + Pagination (tetap di dalam card) -->
      <div style="
          margin-top:10px; 
          display:flex; 
          justify-content:space-between; 
          align-items:center;
          flex-wrap:wrap;          /* AGAR STACK DI MOBILE */
          row-gap:8px;             /* Jarak antar elemen saat stack */
          width:100%;
      ">

          {{-- SUMMARY DI KIRI --}}
          @if($rencana instanceof \Illuminate\Pagination\LengthAwarePaginator)
              @php
                  $start = ($rencana->currentPage() - 1) * $rencana->perPage() + 1;
                  $end   = min($rencana->currentPage() * $rencana->perPage(), $rencana->total());
              @endphp

              <div style="
                  font-size:0.9rem; 
                  color:#000; 
                  padding-left:5px;
                  flex:1;                 /* RESPONSIVE */
                  min-width:200px;        /* AGAR TIDAK PECAH */
              ">
                  Menampilkan <strong>{{ $start }}</strong>–<strong>{{ $end }}</strong> 
                  dari <strong>{{ number_format($rencana->total()) }}</strong> hasil
              </div>
          @else
              <div style="
                  font-size:0.9rem; 
                  color:#000; 
                  padding-left:5px;
                  flex:1;
                  min-width:200px;
              ">
                  Total <strong>{{ $rencana->count() }}</strong> data
              </div>
          @endif

          {{-- PAGINATION DI KANAN --}}
          <div style="
              text-align:right; 
              flex:1;                 /* SUPAYA RESPONSIVE */
              min-width:200px;
          ">
              <style>
                  .pagination { 
                      display:inline-flex; 
                      gap:2px; 
                      flex-wrap:wrap;          /* AGAR RESPONSIVE DI MOBILE */
                      justify-content:flex-end;
                  }
                  .pagination li { 
                      font-size:0.95em; 
                      list-style:none; 
                  }
                  .pagination .page-link { 
                      padding:2px 8px; 
                      font-size:0.95em; 
                      border-radius:4px; 
                      border:1px solid #ddd; 
                      background:#fff; 
                      color:#007bff; 
                      cursor:pointer;
                      white-space:nowrap;      /* JAGA FORM TIDAK PUTUS */
                  }
                  .pagination .active .page-link { 
                      background:#007bff; 
                      color:#fff; 
                      border-color:#007bff; 
                  }
              </style>

              @if($rencana instanceof \Illuminate\Pagination\LengthAwarePaginator || $rencana instanceof \Illuminate\Pagination\Paginator)
                  {{ $rencana->links('vendor.pagination.custom') }}
              @endif
          </div>
      </div>

      <!-- Ringkasan Total per Kegiatan, Output & Sub Komponen (fungsikan filter di sini saja, hapus dari tabel realisasi utama) -->
      <div class="summary-totals" style="margin-top:30px;">
        <h3 style="text-align:center; font-size:1.1rem;margin-bottom:5px; font-weight:500;">Ringkasan Total per Kegiatan, Output & Sub Komponen</h3>
        <div class="summary-filters" style="margin-bottom:10px; display:flex; gap:16px; align-items:center;">
          <label for="summaryKegiatanFilter" style="font-size:1em;">Filter Kegiatan (Ringkasan):</label>
          <select id="summaryKegiatanFilter" style="padding:4px 8px; border-radius:4px; border:1px solid #ccc; width:300px;">
            <option value="">Semua</option>
            @php
              $kegiatanOptions = $rencanaAll->pluck('kegiatan')->unique()->sort();
              $selectedSummaryKegiatan = $selectedSummaryKegiatan ?? request('summary_kegiatan');
              $selectedSummaryOutput = $selectedSummaryOutput ?? request('summary_output');
            @endphp
            @foreach($kegiatanOptions as $keg)
              <option value="{{ $keg }}" @if((string)$selectedSummaryKegiatan === (string)$keg) selected @endif>{{ $keg }}</option>
            @endforeach
          </select>
          <label for="summaryOutputFilter" style="font-size:1em; margin-left:10px;">Filter Output (Ringkasan):</label>
          <select id="summaryOutputFilter" style="padding:4px 8px; border-radius:4px; border:1px solid #ccc; width:300px;" @if(!$selectedSummaryKegiatan) disabled @endif>
            <option value="">@if(!$selectedSummaryKegiatan) Pilih Kegiatan dulu @else Semua @endif</option>
            @php
              $kegVal = $selectedSummaryKegiatan;
              $outVal = $selectedSummaryOutput ?? request('summary_output');
              $summaryOutputOptions = collect();

              if ($kegVal && $kegVal !== '') {
                  // Ambil semua output dinamis berdasarkan kegiatan
                  $summaryOutputOptions = $rencanaAll
                      ->where('kegiatan', (string)$kegVal)
                      ->pluck('output')
                      ->unique()
                      ->values();
              } else {
                  $summaryOutputOptions = collect();
              }
            @endphp
            @foreach($summaryOutputOptions as $output)
              <option value="{{ $output }}" @if((string)$outVal === (string)$output) selected @endif>{{ $output }}</option>
            @endforeach
          </select>
          <label for="summaryAkunFilter" style="margin:0;font-size:1em;">Sub Komponen (Ringkasan):</label>
        <select id="summaryAkunFilter" name="summary_akun_id" style="padding:4px 8px; border-radius:4px; border:1px solid #ccc; width:300px;" @if(!$selectedSummaryOutput) disabled @endif>
          <option value="">
            @if(!$selectedSummaryKegiatan)
              Pilih Kegiatan dulu
            @elseif(!$selectedSummaryOutput)
              Pilih Output dulu
            @else
              Semua
            @endif
          </option>
          @if($selectedSummaryOutput)
            @php
              $summaryAkunIds = $rencanaAll
                ->when($selectedSummaryKegiatan, fn($q) => $q->where('kegiatan', (string)$selectedSummaryKegiatan))
                ->where('output', (string)$selectedSummaryOutput)
                ->pluck('akun_id')->unique();
              // Selalu tampilkan semua akun yang relevan dengan parent (kegiatan & output)
              $summaryAkunOptions = $summaryAkuns->whereIn('id_akun', $summaryAkunIds);
            @endphp
            @foreach($summaryAkunOptions as $akun)
              <option value="{{ $akun->id_akun }}" @if((string)request('summary_akun_id') === (string)$akun->id_akun) selected @endif>{{ $akun->kode }} - {{ $akun->nama }}</option>
            @endforeach
          @endif
        </select>
        </div>
        <!-- Tabel Ringkasan Realisasi -->
        <div class="table-wrap" style="overflow-x:auto;">
          <table id="mainTable" style="width:100%; background:#fff; border-radius:6px; border-collapse:collapse; color:#000; font-size:0.9rem; border:1px solid #000;">
            <thead>
              <tr>
                  <th style="text-align:center;vertical-align:middle; border:1px solid #000;">No</th>
                  <th style="text-align:center;vertical-align:middle; border:1px solid #000; padding: 2px;">Kegiatan</th>
                  <th style="text-align:center;vertical-align:middle; border:1px solid #000; padding: 2px;">Output/KRO/RO</th>
                  <th style="text-align:center;vertical-align:middle; border:1px solid #000; padding: 2px;">Sub Komponen</th>
                  <th style="text-align:center; vertical-align:middle; border:1px solid #000; padding: 2px;">Pagu</th>
                  <th style="text-align:center; vertical-align:middle; border:1px solid #000; padding: 2px;">RPD</th>
                  <th style="text-align:center; vertical-align:middle; border:1px solid #000; padding: 2px;">Realisasi</th>
                  <th style="text-align:center; vertical-align:middle; border:1px solid #000; padding: 2px;">Selisih (RPD - Realisasi)</th>
              </tr>
            </thead>
            <tbody>
              @php
                // Use all rencana data for summary (not just paginated page)
                $rencanaAll = isset($rencanaAll) && $rencanaAll->count() ? $rencanaAll : (method_exists($rencana, 'getCollection') ? $rencana->getCollection() : collect($rencana));
                $summaryKegiatanFilter = request()->get('summary_kegiatan') ?? '';
                $outputFilter = request()->get('summary_output') ?? '';
                $summaryPage = (int) (request()->get('summary_page') ?? 1);
                $perPage = 8;
                $summaryData = [];
                foreach ($rencanaAll as $item) {
                  if ($summaryKegiatanFilter && $item->kegiatan !== $summaryKegiatanFilter) continue;
                  if ($outputFilter && $item->output !== $outputFilter) continue;
                  if (request('summary_akun_id') && (string)$item->akun_id !== (string)request('summary_akun_id')) continue;
                  $key = $item->kegiatan.'-'.$item->output.'-'.$item->akun->kode;
                  if (!isset($summaryData[$key])) {
                    $summaryData[$key] = [
                      'kegiatan' => $item->kegiatan,
                      'output' => $item->output,
                      'akun' => $item->akun->kode.' - '.$item->akun->nama,
                      'total_pagu' => 0,
                      'total_rpd' => 0,
                      'total_realisasi' => 0
                    ];
                  }
                  $summaryData[$key]['total_pagu'] += isset($item->target) ? (int)$item->target : 0;
                  $rpd = 0;
                  foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m) {
                    $rpd += isset($item->$m) ? (int)$item->$m : 0;
                  }
                  $summaryData[$key]['total_rpd'] += $rpd;
                  $uraiansKey = trim($item->uraians ?? '');
                  $realKey = $item->output.'-'.$item->akun_id.'-'.$item->uraian_id.'-'.$uraiansKey;
                  $emptyKey = $item->output.'-'.$item->akun_id.'-'.$item->uraian_id.'-';
                  $real = $realisasi[$realKey] ?? $realisasi[$emptyKey] ?? null;
                  foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m) {
                    $summaryData[$key]['total_realisasi'] += $real ? (int)$real->$m : 0;
                  }
                }
                // Urutkan berdasarkan kegiatan dan output
                $sortedSummary = collect($summaryData)->sortBy([['kegiatan','asc'],['output','asc']])->values();
                // Group by output untuk rowspan
                $grouped = $sortedSummary->groupBy(function($row){ return $row['kegiatan'].'|'.$row['output']; });
                $flatRows = [];
                foreach ($grouped as $groupKey => $rows) {
                  foreach ($rows as $row) {
                    $flatRows[] = $row;
                  }
                }
                $totalRows = count($flatRows);
                $summaryPages = ceil($totalRows / $perPage);
                // Jika user akses summary_page di luar range, tampilkan data kosong (tidak redirect)
                if ($summaryPage > $summaryPages || $summaryPages == 0) {
                  $pagedRows = [];
                } else {
                  $pagedRows = array_slice($flatRows, ($summaryPage-1)*$perPage, $perPage);
                }
                // For rowspan calculation
                $groupCounts = [];
                foreach ($pagedRows as $row) {
                  $gk = $row['kegiatan'].'|'.$row['output'];
                  if (!isset($groupCounts[$gk])) $groupCounts[$gk] = 0;
                  $groupCounts[$gk]++;
                }
                $lastGroup = null;
              @endphp
              @php
                // Build global group list based on the filtered/sorted flatRows so
                // numbering reflects only the groups currently shown in summary filters.
                $globalGroups = [];
                foreach ($flatRows as $fr) {
                  $gk = $fr['kegiatan'].'|'.$fr['output'];
                  if (!in_array($gk, $globalGroups)) $globalGroups[] = $gk;
                }
                // Keep order as in sortedSummary (already sorted by kegiatan/output)
                $groupNo = 0;
              @endphp
              @php
                // Determine starting group number for this paginated slice.
                // If a summary filter is active, restart numbering from 1 for the filtered results.
                $hasSummaryFilter = ($summaryKegiatanFilter && $summaryKegiatanFilter !== '') || ($outputFilter && $outputFilter !== '') || (request()->has('summary_akun_id') && request('summary_akun_id'));

                // First group key shown on this page (kegiatan|output)
                $firstGroupKey = null;
                if (!empty($pagedRows)) {
                  $first = $pagedRows[0];
                  $firstGroupKey = ($first['kegiatan'] ?? '') . '|' . ($first['output'] ?? '');
                }

                if ($hasSummaryFilter) {
                  $startNo = 1;
                } else {
                  if ($firstGroupKey !== null && in_array($firstGroupKey, $globalGroups)) {
                    $startNo = array_search($firstGroupKey, $globalGroups) + 1; // 1-based
                  } else {
                    $startNo = 1;
                  }
                }

                $localNo = $startNo;
              @endphp
              @foreach($pagedRows as $row)
              @php
                $currentGroup = $row['kegiatan'].'|'.$row['output'];
                $isNewGroup = $lastGroup !== $currentGroup;
              @endphp
              <tr style="border:1px solid #000;">
                @if($isNewGroup)
                  <td style="border:1px solid #000; vertical-align: top; text-align: center;" rowspan="{{ $groupCounts[$row['kegiatan'].'|'.$row['output']] }}">{{ $localNo }}</td>
                @endif
                @if($isNewGroup)
                  <td style="border:1px solid #000; vertical-align: top; text-align: center;" rowspan="{{ $groupCounts[$row['kegiatan'].'|'.$row['output']] }}">
                    {{ $row['kegiatan'] }}
                  </td>
                  <td style="border:1px solid #000; vertical-align: top; text-align: center;" rowspan="{{ $groupCounts[$row['kegiatan'].'|'.$row['output']] }}">
                    {{ $row['output'] }}
                  </td>
                  @php $lastGroup = $row['kegiatan'].'|'.$row['output']; $localNo++; @endphp
                @endif
                <td style="border:1px solid #000;">{{ $row['akun'] }}</td>
                <td style="text-align:right; border:1px solid #000;"class="text-end">
                  <span style="white-space:nowrap;">Rp {{ number_format($row['total_pagu']) }}</span>
                </td>
                <td style="text-align:right; border:1px solid #000;" class="text-end">
                  <span style="white-space:nowrap;">Rp {{ number_format($row['total_rpd']) }}</span>
                </td>
                <td style="text-align:right; border:1px solid #000;" class="text-end">
                  <span style="white-space:nowrap;">Rp {{ number_format($row['total_realisasi']) }}</span>
                </td>
                <td style="text-align:right; border:1px solid #000;" class="text-end">
                  <span style="white-space:nowrap; color:red;">Rp {{ number_format($row['total_rpd'] - $row['total_realisasi']) }}</span>
                </td>
              </tr>
              @endforeach
              @if(count($pagedRows) === 0)
                <tr>
                  <td colspan="8" style="text-align:center; color:#888; font-style:italic; border:1px solid #000;">Tidak ada data</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
        <!-- Pagination for summary table -->
        @if(empty(request('summary_kegiatan')) && empty(request('summary_output')))
        @if(empty($selectedSummaryKegiatan) && empty($selectedSummaryOutput))
        @php
          // Compute summary range based on unique groups (kegiatan|output) so numbering
          // matches the 'No' column which numbers groups, not rows.
          $groupsOnPageOrdered = [];
          foreach ($pagedRows as $row) {
            $gk = ($row['kegiatan'] ?? '') . '|' . ($row['output'] ?? '');
            if (!in_array($gk, $groupsOnPageOrdered)) $groupsOnPageOrdered[] = $gk;
          }
          $groupsCount = count($groupsOnPageOrdered);

          if ($groupsCount > 0) {
            $firstKey = $groupsOnPageOrdered[0];
            $lastKey = $groupsOnPageOrdered[$groupsCount - 1];
            $firstPos = array_search($firstKey, $globalGroups);
            $lastPos = array_search($lastKey, $globalGroups);
            $from = ($firstPos === false) ? 1 : ($firstPos + 1);
            $to = ($lastPos === false) ? $from : ($lastPos + 1);
          } else {
            $from = 0;
            $to = 0;
          }

          // totalRows should represent total groups (kegiatan|output) in current filters
          $totalRows = count($globalGroups);
        @endphp

        <!-- WRAP FLEX RESPONSIVE -->
        <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            width:100%;
            margin-top:10px;
            flex-wrap:wrap;
            row-gap:8px;
        ">

            <!-- SUMMARY (KIRI) -->
            <div style="
                font-size:0.9rem;
                white-space:nowrap;
                color:#333;
                flex:0 1 auto; 
            ">
                Menampilkan <strong>{{ $from }}</strong> - <strong>{{ $to }}</strong>
                dari <strong>{{ $totalRows }}</strong> hasil
            </div>

            <!-- PAGINATION (KANAN – TETAP SATU BARIS DI DESKTOP) -->
            <nav aria-label="Summary pagination" style="
                white-space:nowrap;
                flex:0 1 auto;                    /* DESKTOP: tidak melebar */
                display:flex;
                justify-content:flex-end;
                overflow-x:auto;

                /* MOBILE AUTO: akan wrap jika layar sempit */
                max-width:calc(100% - 150px);     /* Ruang sisa dari summary */
            ">
                <ul class="pagination pagination-sm mb-0" style="
                    margin:0;
                    padding:0;
                    display:flex;
                    gap:3px;
                ">

                    @php $last = $summaryPages; @endphp

                    {{-- First --}}
                    @if($summaryPage == 1)
                      <li style="list-style:none;" class="disabled"><span class="page-link" style="padding:3px 8px; font-size:0.85rem; border:1px solid #eee; border-radius:4px; color:#999; background:#f7f7f7; display:inline-block;">First</span></li>
                    @else
                      <li style="list-style:none;"><a class="page-link" style="padding:3px 8px; font-size:0.85rem; border:1px solid #ddd; border-radius:4px; display:inline-block; text-decoration:none; color:#007bff; background:#fff;" href="?summary_page=1{{ $outputFilter ? '&summary_output='.urlencode($outputFilter) : '' }}#summary">First</a></li>
                    @endif

                    {{-- Previous --}}
                    @if($summaryPage == 1)
                      <li style="list-style:none;" class="disabled"><span class="page-link" style="padding:3px 8px; font-size:0.85rem; border:1px solid #eee; border-radius:4px; color:#999; background:#f7f7f7; display:inline-block;">&laquo;</span></li>
                    @else
                      <li style="list-style:none;"><a class="page-link" style="padding:3px 8px; font-size:0.85rem; border:1px solid #ddd; border-radius:4px; display:inline-block; text-decoration:none; color:#007bff; background:#fff;" href="?summary_page={{ max(1, $summaryPage-1) }}{{ $outputFilter ? '&summary_output='.urlencode($outputFilter) : '' }}#summary">&laquo;</a></li>
                    @endif

                    {{-- Page window --}}
                    @php
                        $start = max($summaryPage - 2, 1);
                        $end = min($summaryPage + 2, $last);
                        if ($start === 1) $end = min(5, $last);
                        if ($end === $last) $start = max($end - 4, 1);
                    @endphp

                    @for($i = $start; $i <= $end; $i++)
                        @if($i == $summaryPage)
                          <li style="list-style:none;" class="active"><span class="page-link" style="padding:3px 8px; font-size:0.85rem; border:1px solid #007bff; border-radius:4px; display:inline-block; background:#007bff; color:#fff;">{{ $i }}</span></li>
                        @else
                          <li style="list-style:none;"><a class="page-link" style="padding:3px 8px; font-size:0.85rem; border:1px solid #ddd; border-radius:4px; display:inline-block; text-decoration:none; color:#007bff; background:#fff;" href="?summary_page={{ $i }}{{ $outputFilter ? '&summary_output='.urlencode($outputFilter) : '' }}#summary">{{ $i }}</a></li>
                        @endif
                    @endfor

                    {{-- Next --}}
                    @if($summaryPage < $last)
                      <li style="list-style:none;"><a class="page-link" style="padding:3px 8px; font-size:0.85rem; border:1px solid #ddd; border-radius:4px; display:inline-block; text-decoration:none; color:#007bff; background:#fff;" href="?summary_page={{ min($last, $summaryPage+1) }}{{ $outputFilter ? '&summary_output='.urlencode($outputFilter) : '' }}#summary">&raquo;</a></li>
                    @else
                      <li style="list-style:none;" class="disabled"><span class="page-link" style="padding:3px 8px; font-size:0.85rem; border:1px solid #eee; border-radius:4px; color:#999; background:#f7f7f7; display:inline-block;">&raquo;</span></li>
                    @endif

                    {{-- Last --}}
                    @if($summaryPage == $last)
                      <li style="list-style:none;" class="disabled"><span class="page-link" style="padding:3px 8px; font-size:0.85rem; border:1px solid #eee; border-radius:4px; color:#999; background:#f7f7f7; display:inline-block;">Last</span></li>
                    @else
                      <li style="list-style:none;"><a class="page-link" style="padding:3px 8px; font-size:0.85rem; border:1px solid #ddd; border-radius:4px; display:inline-block; text-decoration:none; color:#007bff; background:#fff;" href="?summary_page={{ $last }}{{ $outputFilter ? '&summary_output='.urlencode($outputFilter) : '' }}#summary">Last</a></li>
                    @endif

                </ul>
            </nav>
        </div>
        @endif
        @endif
        <script>
        // Filter dinamis ringkasan: kegiatan harus dipilih dulu, output dan akun menyesuaikan parent
        const summaryKegiatanEl = document.getElementById('summaryKegiatanFilter');
        const summaryOutputEl = document.getElementById('summaryOutputFilter');
        const summaryAkunEl = document.getElementById('summaryAkunFilter');
        // Data mapping output per kegiatan
  const summaryAllOutputs = @json($rencanaAll->map(fn($r)=>[$r->kegiatan,$r->output])->unique()->values());
        summaryKegiatanEl.addEventListener('change', function() {
          const keg = this.value;
          let outputSet = new Set();
          if(keg === '3365') {
            outputSet.add('DCF.001');
            outputSet.add('SCF.002');
          } else if(keg && keg !== '') {
            summaryAllOutputs.forEach(function(pair){
              if(pair[0] === keg) outputSet.add(pair[1]);
            });
          }
          summaryOutputEl.innerHTML = '';
          const optAll = document.createElement('option');
          optAll.value = '';
          optAll.textContent = keg ? 'Semua' : 'Pilih Kegiatan dulu';
          summaryOutputEl.appendChild(optAll);
          outputSet.forEach(function(out){
            const opt = document.createElement('option');
            opt.value = out;
            opt.textContent = out;
            summaryOutputEl.appendChild(opt);
          });
          summaryOutputEl.disabled = !keg;
          summaryAkunEl.disabled = true;
          // Setelah update, reload halaman
          const url = new URL(window.location.href);
          if(keg) url.searchParams.set('summary_kegiatan', keg); else url.searchParams.delete('summary_kegiatan');
          url.searchParams.delete('summary_output');
          url.searchParams.delete('summary_akun_id');
          window.location.href = url.toString();
        });
        summaryOutputEl.addEventListener('change', function() {
          const keg = summaryKegiatanEl.value;
          const val = this.value;
          // Enable akun only if output selected
          summaryAkunEl.disabled = !val;
          const url = new URL(window.location.href);
          if(keg) url.searchParams.set('summary_kegiatan', keg); else url.searchParams.delete('summary_kegiatan');
          if(val) url.searchParams.set('summary_output', val); else url.searchParams.delete('summary_output');
          url.searchParams.delete('summary_akun_id');
          url.searchParams.set('summary_page', 1);
          window.location.href = url.toString();
        });
        summaryAkunEl.addEventListener('change', function() {
          const keg = summaryKegiatanEl.value;
          const out = summaryOutputEl.value;
          const akun = this.value;
          const url = new URL(window.location.href);
          if(keg) url.searchParams.set('summary_kegiatan', keg); else url.searchParams.delete('summary_kegiatan');
          if(out) url.searchParams.set('summary_output', out); else url.searchParams.delete('summary_output');
          if(akun) url.searchParams.set('summary_akun_id', akun); else url.searchParams.delete('summary_akun_id');
          url.searchParams.set('summary_page', 1);
          window.location.href = url.toString();
        });
        </script>
      </div>

      <!-- ================== Total Realisasi per Output (ringkasan kecil) ================== -->
      @php
        // Use all rencana data for summary (not just paginated page)
        $rencanaAll = isset($rencanaAll) && $rencanaAll->count() ? $rencanaAll : (method_exists($rencana, 'getCollection') ? $rencana->getCollection() : collect($rencana));
        $outputRealisasiSummary = [];
        foreach ($rencanaAll as $item) {
          $uraiansKey = trim($item->uraians ?? '');
          $realKey = $item->output.'-'.$item->akun_id.'-'.$item->uraian_id.'-'.$uraiansKey;
          $real = $realisasi[$realKey] ?? null;
          if (!isset($outputRealisasiSummary[$item->output])) $outputRealisasiSummary[$item->output] = 0;
          foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m) {
            $outputRealisasiSummary[$item->output] += $real ? (int)$real->$m : 0;
          }
        }
      @endphp

      {{-- Total Realisasi per Kegiatan & Output --}}
      <div style="margin-top:18px; width:100%; text-align:center;">
        <h4 style="font-size:1.1rem; font-weight:500; margin-bottom:10px; text-align:center;">
          Total Realisasi per Kegiatan & Output
        </h4>
        <div class="table-responsive" style="margin-bottom:0; overflow-x:auto;">
          <table class="table table-bordered table-hover table-sm" style="margin:0 auto; text-align:center; margin-bottom:0;">
            <thead class="thead-light">
              <tr>
                  <th style="text-align:center; border:1px solid #000;">Kegiatan</th>
                  <th style="text-align:center; border:1px solid #000;">Output</th>
                  <th style="text-align:center; border:1px solid #000;">Pagu</th>
                  <th style="text-align:center; border:1px solid #000;">RPD</th>
                  <th style="text-align:center; border:1px solid #000;">Realisasi</th>
                  <th style="text-align:center; border:1px solid #000;">Selisih (RPD - Realisasi)</th>
              </tr>
            </thead>
            <tbody>
              @php
                $grandTotalRpd = 0;
                $grandTotalRealisasi = 0;
                  $grandTotalPagu = 0;
                $rows = [];
                $grouped = collect($rencanaAll)->groupBy(function($item){
                  return $item->kegiatan.'|||'.$item->output;
                });
                foreach($grouped as $key => $items) {
                  $first = $items->first();
                  $kegiatan = $first->kegiatan;
                  $output = $first->output;
                    $pagu = 0;
                  $rpd = 0;
                  $realisasiSum = 0;
                  foreach($items as $item) {
                      $pagu += isset($item->target) ? (int)$item->target : 0;
                    foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m) {
                      $rpd += (int)$item->$m;
                    }
                    $uraiansKey = trim($item->uraians ?? '');
                    $realKey = $item->output.'-'.$item->akun_id.'-'.$item->uraian_id.'-'.$uraiansKey;
                    $emptyKey = $item->output.'-'.$item->akun_id.'-'.$item->uraian_id.'-';
                    $real = $realisasi[$realKey] ?? $realisasi[$emptyKey] ?? null;
                    foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m) {
                      $realisasiSum += $real ? (int)$real->$m : 0;
                    }
                  }
                  $rows[] = [
                    'kegiatan' => $kegiatan,
                    'output' => $output,
                      'pagu' => $pagu,
                    'rpd' => $rpd,
                    'realisasi' => $realisasiSum,
                    'selisih' => $rpd - $realisasiSum
                  ];
                }
                $rows = collect($rows)->sortBy([['kegiatan','asc'],['output','asc']])->values();
              @endphp
              @foreach($rows as $row)
                  @php $grandTotalPagu += $row['pagu']; $grandTotalRpd += $row['rpd']; $grandTotalRealisasi += $row['realisasi']; @endphp
                <tr>
                  <td style="text-align:center; border:1px solid #000;">{{ $row['kegiatan'] }}</td>
                  <td style="text-align:center; border:1px solid #000;">{{ $row['output'] }}</td>
                    <td style="text-align:right; border:1px solid #000; white-space:nowrap;">Rp {{ number_format($row['pagu']) }}</td>
                  <td style="text-align:right; border:1px solid #000; white-space:nowrap;">Rp {{ number_format($row['rpd']) }}</td>
                  <td style="text-align:right; border:1px solid #000; white-space:nowrap;">Rp {{ number_format($row['realisasi']) }}</td>
                  <td style="text-align:right; border:1px solid #000; color:red; white-space:nowrap;">Rp {{ number_format($row['selisih']) }}</td>
                </tr>
              @endforeach
                <tr style="background:#f9f9f9; font-weight:bold; color:#000;">
                  <td style="text-align:center; border:1px solid #000;" colspan="2">Total</td>
                  <td style="text-align:right; border:1px solid #000; white-space:nowrap;">Rp {{ number_format($grandTotalPagu) }}</td>
                  <td style="text-align:right; border:1px solid #000; white-space:nowrap;">Rp {{ number_format($grandTotalRpd) }}</td>
                  <td style="text-align:right; border:1px solid #000; white-space:nowrap;">Rp {{ number_format($grandTotalRealisasi) }}</td>
                  <td style="text-align:right; border:1px solid #000; color:red; white-space:nowrap;">Rp {{ number_format($grandTotalRpd - $grandTotalRealisasi) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- ================== Ringkasan per Jenis Belanja per Bulan ================== -->
      @php
// Ambil data realisasi
$rencanaAll = isset($rencanaAll) && $rencanaAll->count() 
    ? $rencanaAll 
    : (method_exists($rencana, 'getCollection') ? $rencana->getCollection() : collect($rencana));

$jenisBelanjaSummary = [];

foreach ($rencanaAll as $item) {
  $uraiansKey = trim($item->uraians ?? '');
  $realKey = $item->output.'-'.$item->akun_id.'-'.$item->uraian_id.'-'.$uraiansKey;
  $emptyKey = $item->output.'-'.$item->akun_id.'-'.$item->uraian_id.'-';
  $real = $realisasi[$realKey] ?? $realisasi[$emptyKey] ?? null;
  $jenis = $item->jenis_belanja;

  if (!isset($jenisBelanjaSummary[$jenis])) {
    $jenisBelanjaSummary[$jenis] = array_fill_keys(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'], 0);
  }

  foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m) {
    $jenisBelanjaSummary[$jenis][$m] += $real ? (int)$real->$m : 0;
  }
}
// Pastikan key 51, 52, 53 selalu ada meskipun data kosong
foreach(['51','52','53'] as $j){
  if(!isset($jenisBelanjaSummary[$j])){
  $jenisBelanjaSummary[$j] = array_fill_keys(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'], 0);
  }
}

$bulanLabels = [
    'jan'=>'Januari','feb'=>'Februari','mar'=>'Maret','apr'=>'April','mei'=>'Mei',
    'jun'=>'Juni','jul'=>'Juli','agt'=>'Agustus','sep'=>'September','okt'=>'Oktober',
    'nov'=>'November','des'=>'Desember'
];

// Pastikan jenis belanja 51,52,53 ada
$orderedJenis = ['51','52','53'];
@endphp

  
      <!-- Judul tetap diam -->
      <h3 style="text-align:center;font-size:1.1rem;margin-bottom:10px; margin-top:10px; font-weight:500;">
        Ringkasan Total per Jenis Belanja
      </h3>
    <div style="overflow-x:auto; position:relative; -webkit-overflow-scrolling:touch;">
      <table style="width:100%; border-collapse:collapse; text-align:right; font-size:0.95rem; min-width:700px;">
          <thead>
              <tr style="background:#e3f0ff;">
                  <!-- Kolom Bulan sticky -->
                  <th style="border:1px solid #000; text-align:center; padding:4px 6px;
                            position:sticky; left:0; z-index:5;">
                      Bulan
                  </th>
                  @foreach($orderedJenis as $jenis)
                      <th style="text-align:center; border:1px solid #000; padding:4px 6px;">
                          Jenis Belanja {{ $jenis }}
                      </th>
                  @endforeach
                  <th style="text-align:center; border:1px solid #000; padding:4px 6px;">
                      Total Bulanan
                  </th>
              </tr>
          </thead>
          <tbody>
              @php $grandTotal = 0; @endphp
              @foreach($bulanLabels as $m => $label)
                  <tr>
                      <!-- Bulan sticky di setiap baris -->
                      <td style="border:1px solid #000; text-align:left; padding:4px 6px;
                                position:sticky; left:0; z-index:4; background:#fff;">
                          {{ $label }}
                      </td>
                      @php $totalBulanan = 0; @endphp
                      @foreach($orderedJenis as $jenis)
                          @php
                              $val = $jenisBelanjaSummary[$jenis][$m] ?? 0;
                              $totalBulanan += $val;
                          @endphp
                          <td style="text-align:right; border:1px solid #000; padding:4px 6px;">
                              Rp {{ number_format($val) }}
                          </td>
                      @endforeach
                      <td style="text-align:right; border:1px solid #000; padding:4px 6px;">
                          Rp {{ number_format($totalBulanan) }}
                      </td>
                      @php $grandTotal += $totalBulanan; @endphp
                  </tr>
              @endforeach
          </tbody>
          <tfoot>
              <tr style="background:#f9f9f9; font-weight:bold;">
                  <td style="border:1px solid #000; text-align:center; padding:4px 6px;
                            position:sticky; left:0; z-index:4; background:#f9f9f9;">
                      Grand Total
                  </td>
                  @foreach($orderedJenis as $jenis)
                      @php $totalJenis = array_sum($jenisBelanjaSummary[$jenis]); @endphp
                      <td style="text-align:right; border:1px solid #000; padding:4px 6px;">
                          Rp {{ number_format($totalJenis) }}
                      </td>
                  @endforeach
                  <td style="text-align:right; border:1px solid #000; padding:4px 6px;">
                      Rp {{ number_format($grandTotal) }}
                  </td>
              </tr>
          </tfoot>
      </table>
  </div>
 <!-- END CARD UTAMA -->

    <!-- Modal Tambah/Edit Data Realisasi (readonly master, input bulanan) -->
    <div class="modal" id="dataModal" style="display:none; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.3); z-index:1000;">
      <div class="modal-content" style="max-width:520px; width:98%; padding:24px 24px 18px 24px; border-radius:14px; background:#fff; box-shadow:0 4px 24px #0002; display:flex; flex-direction:column;">
        <div class="modal-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
          <h2 id="modalTitle" style="margin:0; font-size:1.1rem;">Edit Realisasi</h2>
          <span class="close" id="closeModal" style="cursor:pointer; font-size:1.3rem;">&times;</span>
        </div>
        <form id="dataForm">
          <input type="hidden" id="modalRencanaId">
          <div class="form-section" style="margin-bottom:10px;">
            <h3 style="margin-bottom:6px; font-size:1rem;">Data Master (readonly)</h3>
            <div style="display:grid; grid-template-columns:1fr 1fr; column-gap:32px; row-gap:2px;">
              <div>
                <label>Kegiatan</label>
                <input type="text" id="kegiatan" readonly style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc; background:#f5f5f5;">
              </div>
              <div>
                <label>Output/KRO/RO</label>
                <input type="text" id="output" readonly style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc; background:#f5f5f5;">
              </div>
              <div>
                <label>Komponen</label>
                <input type="text" id="komponen" readonly style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc; background:#f5f5f5;">
              </div>
              <div>
                <label>Jenis Belanja</label>
                <input type="text" id="jenis_belanja" readonly style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc; background:#f5f5f5;">
              </div>
              <div>
                <label>Bagian Kelompok Substansi</label>
                <input type="text" id="unit_kerja" readonly style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc; background:#f5f5f5;">
              </div>
              <div>
                <label>Sub Komponen</label>
                <input type="text" id="sub_komponen" readonly style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc; background:#f5f5f5;">
              </div>
              <div>
                <label>Akun</label>
                <input type="text" id="akun" readonly style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc; background:#f5f5f5;">
              </div>
              <div>
                <label>Uraian Kegiatan (Opsional)</label>
                <input type="text" id="uraians" readonly style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc; background:#f5f5f5;">
              </div>
              <div>
                <label>Pagu</label>
                <input type="number" id="target" readonly style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc; background:#f5f5f5;">
              </div>
            </div>
          </div>

          <div class="form-section" style="margin-bottom:10px;">
            <h3 style="margin-bottom:6px; font-size:1rem;">Realisasi per Bulan</h3>
            <div class="grid-bulan" style="display:grid; grid-template-columns:repeat(2, 1fr); column-gap:28px; row-gap:2px;">
              @foreach(['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'] as $m)
              <div>
                <label>{{ $m }}</label>
                <input type="number" id="bulan-{{ $m }}" value="0" required style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc;">
              </div>
              @endforeach
            </div>
          </div>
          {{-- Keterangan --}}
                <div style="margin-top:12px; background:#f9f9f9; border-left:4px solid #007bff; padding:10px 12px; border-radius:6px; font-size:0.9rem; color:#333;">
                  <strong>Keterangan:</strong>
                  <ul style="margin-top:6px; margin-left:18px; list-style-type:disc;">
                      <li>Setiap kolom bulan <strong>wajib diisi</strong> dan tidak boleh kosong.</li>
                      <li>Jika tidak ada realisasi pada bulan tertentu, isi dengan <strong>0 (nol)</strong> sebagai nilai default.</li>
                      <li>Nilai input harus berupa <strong>angka bulat (integer)</strong>.</li>
                  </ul>
                </div>
          <div class="modal-footer" style="display:flex; justify-content:flex-end; margin-top:8px;">
            <button type="submit" class="btn primary" style="padding:6px 12px; font-size:0.95rem; background:#007bff; color:#fff; border:none; border-radius:4px; cursor:pointer; transition:0.2s;"
              onmouseover="this.style.background='#0069d9'"
              onmouseout="this.style.background='#007bff'"
              >💾 Simpan
            </button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>

<!-- Output mapping (dipakai di JS) -->
@php
  if (!isset($outputMap)) {
    $outputMap = [];
    foreach ($akuns as $a) {
      foreach ($a->outputs ?? [] as $out) {
        if (!isset($outputMap[$out])) $outputMap[$out] = ['akuns'=>[], 'uraians'=>[]];
        $outputMap[$out]['akuns'][] = $a->id;
      }
    }
    foreach ($uraians as $u) {
      foreach ($u->outputs ?? [] as $out) {
        if (!isset($outputMap[$out])) $outputMap[$out] = ['akuns'=>[], 'uraians'=>[]];
        $outputMap[$out]['uraians'][] = $u->id;
      }
    }
  }
@endphp

<!-- External JS (fungsi yang kamu miliki) -->
<script src="{{ asset('js/realisasi.js') }}"></script>

<!-- Inline JS: filter output, mapping akun/uraian, modal open/close, summary filter -->
<script>
  // Filter tabel berdasarkan dropdown output (mengalihkan URL)
  const filterOutputEl = document.getElementById('filterOutput');
  if(filterOutputEl){
    filterOutputEl.addEventListener('change', function() {
      const val = this.value;
      const url = new URL(window.location.href);
      if(val) url.searchParams.set('output', val); else url.searchParams.delete('output');
      window.location.href = url.toString();
    });
  }

  // Summary Output Filter
        const summaryKegiatanEl = document.getElementById('summaryKegiatanFilter');
        const summaryOutputEl = document.getElementById('summaryOutputFilter');
        const summaryAkunEl = document.getElementById('summaryAkunFilter');
        // Data mapping output per kegiatan
  const summaryAllOutputs = @json($rencanaAll->map(fn($r)=>[$r->kegiatan,$r->output])->unique()->values());
        summaryKegiatanEl.addEventListener('change', function() {
          const keg = this.value;
          let outputSet = new Set();
          if(keg === '3365') {
            outputSet.add('DCF.001');
            outputSet.add('SCF.002');
          } else if(keg && keg !== '') {
            summaryAllOutputs.forEach(function(pair){
              if(pair[0] === keg) outputSet.add(pair[1]);
            });
          }
          summaryOutputEl.innerHTML = '';
          const optAll = document.createElement('option');
          optAll.value = '';
          optAll.textContent = keg ? 'Semua' : 'Pilih Kegiatan dulu';
          summaryOutputEl.appendChild(optAll);
          outputSet.forEach(function(out){
            const opt = document.createElement('option');
            opt.value = out;
            opt.textContent = out;
            summaryOutputEl.appendChild(opt);
          });
          summaryOutputEl.disabled = !keg;
          summaryAkunEl.disabled = true;
          // Setelah update, langsung redirect dan tampilkan data yang difilter
          const url = new URL(window.location.href);
          if(keg) url.searchParams.set('summary_kegiatan', keg); else url.searchParams.delete('summary_kegiatan');
          url.searchParams.delete('summary_output');
          url.searchParams.delete('summary_akun_id');
          url.searchParams.set('summary_page', 1);
          window.location.href = url.toString();
        });
        summaryOutputEl.addEventListener('change', function() {
          const keg = summaryKegiatanEl.value;
          const val = this.value;
          // Enable akun only if output selected
          summaryAkunEl.disabled = !val;
          const url = new URL(window.location.href);
          if(keg) url.searchParams.set('summary_kegiatan', keg); else url.searchParams.delete('summary_kegiatan');
          if(val) url.searchParams.set('summary_output', val); else url.searchParams.delete('summary_output');
          url.searchParams.delete('summary_akun_id');
          window.location.href = url.toString();
        });
        summaryAkunEl.addEventListener('change', function() {
          const out = summaryOutputEl.value;
          const akun = this.value;
          const url = new URL(window.location.href);
          if(out) url.searchParams.set('summary_output', out); else url.searchParams.delete('summary_output');
          if(akun) url.searchParams.set('summary_akun_id', akun); else url.searchParams.delete('summary_akun_id');
          window.location.href = url.toString();
        });
        opt.style.display = 'none';
      }
    });

    // Reset selection jika sekarang tidak valid
    if (akunSelect.value && akunSelect.options[akunSelect.selectedIndex].style.display === 'none') akunSelect.value = '';
    if (uraianSelect.value && uraianSelect.options[uraianSelect.selectedIndex].style.display === 'none') uraianSelect.value = '';
  }

  // Event listeners untuk modal + filter akun/uraian
  document.addEventListener('DOMContentLoaded', function(){
    const outputSel = document.getElementById('output');
    if(outputSel) outputSel.addEventListener('change', function(){ 
      filterAkunUraianByOutput();
      // juga sinkron ke filter tabel
      const val = this.value;
      const filterOut = document.getElementById('filterOutput');
      if(filterOut && val) filterOut.value = val;
    });

    document.getElementById('openModalBtn')?.addEventListener('click', function(e){
      e.preventDefault();
      // reset form (opsional)
      const modal = document.getElementById('dataModal');
      modal.style.display = 'flex';
      filterAkunUraianByOutput();
    });

    document.getElementById('closeModal')?.addEventListener('click', function(){
      document.getElementById('dataModal').style.display = 'none';
    });

    // close modal on outside click
    document.getElementById('dataModal')?.addEventListener('click', function(e){
      if(e.target === this) this.style.display = 'none';
    });
  });
</script>
<style>
 @media (max-width: 768px) {
  /* Container utama */
  .controls {
    flex-direction: column !important; /* Stack ke bawah */
    align-items: flex-start !important; /* Ratakan ke kiri */
    gap: 8px; /* Jarak antar elemen */
  }

  /* Tulisan "Data Rencana" di atas */
  .controls > span {
    width: 100%;
    margin-bottom: 6px;
    display: block;
  }

  /* Container filter select + button bertumpuk */
  .controls > div {
    flex-direction: column !important;
    width: 100%;
    gap: 6px;
  }

  /* Semua select dan button full width */
  .controls select,
  .controls button {
    width: 100% !important;
    min-width: 0;
  }

  /* Optional: agar label tetap rapih */
  .controls label {
    margin-bottom: 2px;
  }

  .controls-text {
    text-align: center;
  }

  @media (max-width: 768px) {
  .summary-filters {
    flex-direction: column;
    align-items: stretch;
  }

  .summary-filters label,
  .summary-filters select {
    width: 100% !important;
    margin-bottom: 6px;
  }
}
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    column-gap: 32px;
    row-gap: 8px;
  }

  select, input {
    width: 100%;
    padding: 8px 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 0.95rem;
    box-sizing: border-box;
  }

  label {
    display: block;
    font-size: 0.9rem;
    margin-bottom: 4px;
  }

  /* grid untuk Rencana per Bulan */
  .grid-bulan {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    column-gap: 28px;
    row-gap: 6px;
  }

  @media (max-width: 1024px) {
    .grid-bulan {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  @media (max-width: 640px) {
    .form-grid {
      grid-template-columns: 1fr !important;
      column-gap: 0 !important;
    }

    .grid-bulan {
      grid-template-columns: repeat(2, 1fr) !important;
      column-gap: 16px !important;
      row-gap: 8px !important;
    }
  }
  @media (max-width: 640px) {
    .form-tahun {
      width: 100%;
    }
  }
</style>
@endsection
