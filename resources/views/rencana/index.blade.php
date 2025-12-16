@extends('layouts.app')

@php
  $outputFilter = request()->get('output') ?? '';
  $selectedOutput = $selectedOutput ?? $outputFilter;
@endphp

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div style="display:flex; justify-content:center;">
  <div style="width:95%; max-width:1200px;">
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
    <!-- Judul -->
    <h1 style="text-align:center; font-size:2.2rem;font-weight:700;letter-spacing:-1px; margin-bottom:10px;">Rencana Kegiatan Tahun {{ $tahun ?? date('Y') }}</h1>

    <!-- Card utama -->
    <div class="card" style="background:linear-gradient(120deg,#f6f8fa 60%,#e3f0ff 100%); box-shadow:0 2px 16px #007bff22; padding:20px; border-radius:10px;">

      <!-- Kontrol -->
      <div class="controls" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
        <span class="controls-text" style="font-size:1.1rem;font-weight:500;">Data Rencana</span>
        <div style="display:flex;align-items:center;gap:8px;">
          <label for="mainKegiatanFilter" style="margin:0;font-size:1em;">Kegiatan:</label>
          <select id="mainKegiatanFilter" style="padding:4px 8px; border-radius:4px; border:1px solid #ccc; width:100px;">
            <option value="">Semua</option>
            @foreach($kegiatanOptions as $keg)
              <option value="{{ $keg }}" @if((string)($selectedKegiatan ?? request('kegiatan')) === (string)$keg) selected @endif>{{ $keg }}</option>
            @endforeach
          </select>
          <label for="mainOutputFilter" style="margin:0;font-size:1em;">Output:</label>
          <select id="mainOutputFilter" style="padding:4px 8px; border-radius:4px; border:1px solid #ccc; width:100px;" @if(!($selectedKegiatan ?? request('kegiatan'))) disabled @endif>
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
            @foreach($mainOutputOptions as $output)
              <option value="{{ $output }}" @if((string)$outVal === (string)$output) selected @endif>{{ $output }}</option>
            @endforeach
          </select>
          <label for="mainAkunFilter" style="margin:0;font-size:1em;">Sub Komponen:</label>
          <select id="mainAkunFilter" name="akun_id" style="padding:4px 8px; border-radius:4px; border:1px solid #ccc; width:100px;" @if(!($selectedKegiatan ?? request('kegiatan')) || !($selectedOutput ?? request('output'))) disabled @endif>
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
          @if(auth()->user() && auth()->user()->role === 'admin')
            <button id="openModalBtn" class="btn primary" style="font-size:1rem; padding:8px 16px; background:#007bff; color:#fff; border:none; border-radius:5px; cursor:pointer; transition:0.2s;"
              onmouseover="this.style.background='#0056b3'"
              onmouseout="this.style.background='#007bff'"
              >+ Tambah Data
            </button>
          @endif
        <script>
        // Filter dinamis utama: kegiatan selalu semua data, output menyesuaikan kegiatan, akun menyesuaikan output
        const mainKegiatanEl = document.getElementById('mainKegiatanFilter');
        const mainOutputEl = document.getElementById('mainOutputFilter');
        const mainAkunEl = document.getElementById('mainAkunFilter');
        // Data mapping output per kegiatan (from DB mapping)
        const mainAllOutputs = @json($allOutputPairs);
        // All rencana data for the selected year (used by client-side validation)
        window.allRencanaData = @json($rencanaAll);
        mainKegiatanEl.addEventListener('change', function() {
          const keg = this.value;
          let outputSet = new Set();
          if(keg && keg !== '') {
            mainAllOutputs.forEach(function(pair){
              if(pair[0] === keg) outputSet.add(pair[1]);
            });
          } else {
            mainAllOutputs.forEach(function(pair){
              outputSet.add(pair[1]);
            });
          }
          mainOutputEl.innerHTML = '';
          const optAll = document.createElement('option');
          optAll.value = '';
          optAll.textContent = 'Semua';
          mainOutputEl.appendChild(optAll);
          outputSet.forEach(function(out){
            const opt = document.createElement('option');
            opt.value = out;
            opt.textContent = out;
            mainOutputEl.appendChild(opt);
          });
          // Set output ke value terakhir jika ada
          var lastOutput = "{{ $selectedOutput ?? request('output') }}";
          if(lastOutput && outputSet.has(lastOutput)) {
            mainOutputEl.value = lastOutput;
          } else {
            mainOutputEl.value = '';
          }
          // Setelah update, reload halaman
          const url = new URL(window.location.href);
          if(keg) url.searchParams.set('kegiatan', keg); else url.searchParams.delete('kegiatan');
          url.searchParams.delete('output');
          url.searchParams.delete('akun_id');
          // Reset pagination to first page when changing filters to avoid stale page numbers
          url.searchParams.set('rencana_page', 1);
          window.location.href = url.toString();
        });
        mainOutputEl.addEventListener('change', function() {
          const keg = mainKegiatanEl.value;
          const val = this.value;
          const url = new URL(window.location.href);
          if(keg) url.searchParams.set('kegiatan', keg); else url.searchParams.delete('kegiatan');
          if(val) url.searchParams.set('output', val); else url.searchParams.delete('output');
          url.searchParams.delete('akun_id');
          // Reset pagination to first page when changing filters
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
          // Reset pagination to first page when changing sub-komponen filter
          url.searchParams.set('rencana_page', 1);
          window.location.href = url.toString();
        });
        </script>
        </div>
      </div>

      <script>
      document.getElementById('summaryAkunFilter').addEventListener('change', function() {
        const val = this.value;
        const url = new URL(window.location.href);
        if(val) url.searchParams.set('summary_akun_id', val); else url.searchParams.delete('summary_akun_id');
        window.location.href = url.toString();
      });
      </script>
      {{-- Tabel Utama Rencana Kegiatan --}}
        <div class="table-wrap" style="overflow-x:auto;">
          <table id="mainTable" style="width:100%; background:#fff; border-radius:6px; border-collapse:collapse; color:#000; border:1px solid #000; font-size:0.85rem;">
            <thead>
              <tr>
                <th style="text-align:center; :middle; border:1px solid #000; padding: 3px;" rowspan="2">No</th>
                <th style="vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">Kegiatan</th>
                <th style="vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">Output/KRO/RO</th>
                <th style="vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">Komponen</th>
                <th style="text-align:center; vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">Jenis Belanja</th>
                <th style="text-align:center; vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">Bagian Kelompok Substansi</th>
                <th style="text-align:center; vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">Sub Komponen</th>
                <th style="text-align:center; vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">Akun</th>
                <th style="text-align:center; vertical-align:middle; border:1px solid #000; padding: 3px;" rowspan="2">Uraian Kegiatan</th>
                <th style="text-align:center; vertical-align:middle; border:1px solid #000;" rowspan="2">Pagu</th>
                <th colspan="12" style="text-align:center; border:1px solid #000;">Bulan</th>
                <th style="text-align:center; vertical-align:middle; border:1px solid #000;" rowspan="2">RPD</th>
                <th style="text-align:center; vertical-align:middle; border:1px solid #000;" rowspan="2">Selisih (Pagu - RPD)</th>
                <th style="text-align:center; vertical-align:middle; border:1px solid #000;" rowspan="2">Keterangan</th>
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
          @foreach($rencana as $item)
            @php
              $total_bulan = 0;
              foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m) {
                $total_bulan += (int)$item->$m;
              }

              // Hitung indeks baris berkelanjutan (continuous numbering)
              if ($rencana instanceof \Illuminate\Pagination\LengthAwarePaginator || $rencana instanceof \Illuminate\Pagination\Paginator) {
                $index = ($rencana->perPage() * ($rencana->currentPage() - 1)) + $loop->iteration;
              } else {
                $index = $loop->iteration;
              }
            @endphp

            <tr data-id_rencana="{{ $item->id_rencana }}" 
                data-akun="{{ $item->akun_id }}" 
                data-uraian="{{ $item->uraian_id }}" 
                data-target="{{ $item->target }}"
                @foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m)
                  data-{{ $m }}="{{ $item->$m }}"
                @endforeach
                style="transition:background 0.2s; color:#000; font-size:0.9rem;">
              
              <td style="text-align:center; border:1px solid #000;">{{ $index }}</td>
              <td style="text-align:center; border:1px solid #000;">{{ $item->kegiatan }}</td>
              <td style="text-align:center; border:1px solid #000;">{{ $item->output }}</td>
              <td style="text-align:center; border:1px solid #000;">{{ $item->komponen }}</td>
              <td style="text-align:center; border:1px solid #000;">{{ $item->jenis_belanja }}</td>
              <td style="text-align:center; border:1px solid #000;">{{ $item->unit_kerja }}</td>
              <td style="border:1px solid #000;">
                <span style="font-weight:600;color:#007bff;">{{ $item->akun ? $item->akun->kode : '-' }}</span> 
                <span style="color:#444;">- {{ $item->akun ? $item->akun->nama : '-' }}</span>
              </td>
              <td style="border:1px solid #000;">
                <span style="font-weight:600;color:#28a745;">{{ $item->uraian ? $item->uraian->kode : '-' }}</span> 
                <span style="color:#444;">- {{ $item->uraian ? $item->uraian->nama : '-' }}</span>
              </td>
              <td style="text-align:left; border:1px solid #000;">
                  @php
                      $raw = trim($item->uraians ?? '');

                      if ($raw === '') {
                          echo '-';
                      } else {
                          // Pisahkan berdasarkan koma
                          $parts = array_filter(array_map('trim', explode(',', $raw)));

                          // Cek apakah ini list (semua bagian 1 kata)
                          $isList = true;
                          foreach ($parts as $p) {
                              if (str_contains($p, ' ')) {
                                  $isList = false;
                                  break;
                              }
                          }

                          if ($isList && count($parts) > 1) {
                              // Jika benar list → boleh sort
                              usort($parts, fn($a, $b) => strcasecmp($a, $b));
                              echo implode(', ', $parts);
                          } else {
                              // Jika kalimat → TIDAK disort
                              echo $raw;
                          }
                      }
                  @endphp
              </td>
              <td style="border:1px solid #000; text-align:right; font-weight:bold;">
                <span style="white-space:nowrap;">Rp {{ number_format($item->target) }}</span>
              </td>

              @foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m)
                <td style="border:1px solid #000; text-align:right;">
                  <span style="white-space:nowrap;">Rp {{ number_format($item->$m) }}</span>
                </td>
              @endforeach

              <td style="border:1px solid #000; text-align:right;">
                <span style="white-space:nowrap; font-weight:bold; color:#000;">Rp {{ number_format($total_bulan) }}</span>
              </td>

              <td style="white-space:nowrap; border:1px solid #000; text-align:right; font-weight:bold; color:red;">
                Rp {{ number_format((int)$item->target - $total_bulan) }}
              </td>

              <td style="border:1px solid #000; text-align:center; font-weight:bold;">
                @if($item->target == $total_bulan)
                  <span style="color:#28a745;">Sesuai</span>
                @else
                  <span style="color:#dc3545;">Tidak Sesuai</span>
                @endif
              </td>

              <td style="border:1px solid #000; text-align:center;">
                <button class="btn warning" style="margin-bottom:5px; padding:2px 6px; background:#ffc107; color:#000; border:none;  border-radius:4px; cursor:pointer; transition:0.2s;"
                  onmouseover="this.style.background='#e0a800'"
                  onmouseout="this.style.background='#ffc107'"
                  >✎
                </button>
                @if(auth()->user() && auth()->user()->role === 'admin')
                <button class="btn danger" style="padding:2px 6px; background:#dc3545; color:#fff; border:none; border-radius:4px; cursor:pointer; transition:0.2s;"
                  onmouseover="this.style.background='#b52a36'"
                  onmouseout="this.style.background='#dc3545'"
                  >✕
                </button>
                @endif
              </td>

            </tr>
          @endforeach

          @if($rencana->count() === 0)
            <tr>
              <td colspan="26" style="border:1px solid #000; text-align:center; color:#888; font-style:italic;">Tidak ada data</td>
            </tr>
          @endif
        </tbody>
      </table>
      </div>

      {{-- Pagination Summary + Pagination --}}
      <div 
          style="
              margin-top:10px; 
              display:flex; 
              justify-content:space-between; 
              align-items:center;
              flex-wrap:wrap;                      /* AGAR STACK DI MOBILE */
              row-gap:10px;                       /* Jarak antar elemen saat mobile */
          "
      >
          {{-- SUMMARY DI KIRI --}}
            @if($rencana instanceof \Illuminate\Pagination\LengthAwarePaginator)
              @php
                  $start = ($rencana->currentPage() - 1) * $rencana->perPage() + 1;
                  $end   = min($rencana->currentPage() * $rencana->perPage(), $rencana->total());
              @endphp

              <div 
                  style="
                      font-size:0.9rem; 
                      color:#000; 
                      flex:1;                      /* AGAR MUDAH MENYESUAIKAN */
                      min-width:200px;             /* AGAR TIDAK PECAH DI MOBILE */
                  "
              >
                  Menampilkan <strong>{{ $start }}</strong>–<strong>{{ $end }}</strong> 
                  dari <strong>{{ number_format($rencana->total()) }}</strong> hasil
                </div>
              @else
                @php
                $filterCount = count(request()->except('page'));
                @endphp
                <div 
                  style="
                    font-size:0.9rem; 
                    color:#000; 
                    flex:1;                      /* AGAR MUDAH MENYESUAIKAN */
                    min-width:200px;             /* AGAR TIDAK PECAH DI MOBILE */
                  "
                >
                  Total <strong>{{ $rencana->count() }}</strong> data @if($filterCount > 0) <span style="color:#666;"></span> @endif
                </div>
              @endif

          {{-- PAGINATION --}}
          <div 
              style="
                  flex:1; 
                  text-align:right; 
                  min-width:200px;                /* AGAR PAGINATION TIDAK KEPOTONG */
              "
          >
              <style>
                  .pagination { 
                      display:inline-flex; 
                      gap:2px; 
                      flex-wrap:wrap;             /* RESPONSIVE */
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
                      white-space:nowrap;         /* AGAR TIDAK PUTUS DI MOBILE */
                  }
                  .pagination .active .page-link { 
                      background:#007bff; 
                      color:#fff; 
                      border-color:#007bff; 
                  }
              </style>

                @if($rencana instanceof \Illuminate\Pagination\LengthAwarePaginator)
                  {{ $rencana->links('vendor.pagination.custom') }}
                @endif
          </div>
      </div>

    <!-- Ringkasan Total per Akun, beri margin top 100px -->
    <div class="summary-controls" style="margin-top:10px;">
      <h3 style="text-align:center;font-size:1.1rem;margin-bottom:5px; font-weight:500;">Ringkasan Total per Kegiatan, Output & Sub Komponen</h3>
      <div class="summary-filters" style="margin-bottom:10px; display:flex; gap:16px; align-items:center;">
        <label for="summaryKegiatanFilter" style="font-size:1em;">Filter Kegiatan (Ringkasan):</label>
        <select id="summaryKegiatanFilter" style="padding:4px 8px; border-radius:4px; border:1px solid #ccc; width:300px">
          <option value="">Semua</option>
          @foreach($kegiatanOptions as $keg)
            <option value="{{ $keg }}" @if((string)($selectedSummaryKegiatan ?? request('summary_kegiatan')) === (string)$keg) selected @endif>{{ $keg }}</option>
          @endforeach
        </select>
        <label for="summaryOutputFilter" style="font-size:1em; margin-left:10px;">Filter Output (Ringkasan):</label>
        <select id="summaryOutputFilter" style="padding:4px 8px; border-radius:4px; border:1px solid #ccc; width:300px" @if(!($selectedSummaryKegiatan ?? request('summary_kegiatan'))) disabled @endif>
          <option value="">@if(!($selectedSummaryKegiatan ?? request('summary_kegiatan'))) Pilih Kegiatan dulu @else Semua @endif</option>
          @php
            $kegVal = $selectedSummaryKegiatan ?? request('summary_kegiatan');
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
      <select id="summaryAkunFilter" name="summary_akun_id" style="padding:4px 8px; border-radius:4px; border:1px solid #ccc; width:300px" @if(!($selectedSummaryOutput ?? request('summary_output'))) disabled @endif>
        <option value="">
          @if(!($selectedSummaryKegiatan ?? request('summary_kegiatan')))
            Pilih Kegiatan dulu
          @elseif(!($selectedSummaryOutput ?? request('summary_output')))
            Pilih Output dulu
          @else
            Semua
          @endif
        </option>
        @if($selectedSummaryKegiatan ?? request('summary_kegiatan'))
          @foreach($summaryAkuns as $akun)
            <option value="{{ $akun->id_akun }}" @if((string)request('summary_akun_id') === (string)$akun->id_akun) selected @endif>{{ $akun->kode }} - {{ $akun->nama }}</option>
          @endforeach
        @endif
      </select>
      </div>
        <script>
        // Filter dinamis ringkasan: kegiatan selalu semua data, output menyesuaikan kegiatan
        const summaryKegiatanEl = document.getElementById('summaryKegiatanFilter');
        const summaryOutputEl = document.getElementById('summaryOutputFilter');
        // Data mapping output per kegiatan
        const summaryAllOutputs = @json($rencanaAll->map(fn($r)=>[$r->kegiatan,$r->output])->unique()->values());
        summaryKegiatanEl.addEventListener('change', function() {
          const keg = this.value;
          // Update output options dinamis tanpa reload
          let outputSet = new Set();
          if(keg && keg !== '') {
            summaryAllOutputs.forEach(function(pair){
              if(pair[0] === keg) outputSet.add(pair[1]);
            });
          } else {
            summaryAllOutputs.forEach(function(pair){
              outputSet.add(pair[1]);
            });
          }
          summaryOutputEl.innerHTML = '';
          const optAll = document.createElement('option');
          optAll.value = '';
          optAll.textContent = 'Semua';
          summaryOutputEl.appendChild(optAll);
          outputSet.forEach(function(out){
            const opt = document.createElement('option');
            opt.value = out;
            opt.textContent = out;
            summaryOutputEl.appendChild(opt);
          });
          // Set output ke value terakhir jika ada
          var lastOutput = "{{ $selectedSummaryOutput ?? request('summary_output') }}";
          if(lastOutput && outputSet.has(lastOutput)) {
            summaryOutputEl.value = lastOutput;
          } else {
            summaryOutputEl.value = '';
          }
          // Setelah update, reload halaman
          const url = new URL(window.location.href);
          if(keg) url.searchParams.set('summary_kegiatan', keg); else url.searchParams.delete('summary_kegiatan');
          url.searchParams.delete('summary_output');
          url.searchParams.set('summary_page', 1);
          window.location.href = url.toString();
        });
        summaryOutputEl.addEventListener('change', function() {
          const keg = summaryKegiatanEl.value;
          const val = this.value;
          const url = new URL(window.location.href);
          if(keg) url.searchParams.set('summary_kegiatan', keg); else url.searchParams.delete('summary_kegiatan');
          if(val) url.searchParams.set('summary_output', val); else url.searchParams.delete('summary_output');
          url.searchParams.set('summary_page', 1);
          window.location.href = url.toString();
        });
        const summaryAkunEl = document.getElementById('summaryAkunFilter');
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
        <div class="table-wrap" style="overflow-x:auto;">
          <style>
            .summary-rowspan-cell {
              vertical-align: middle !important;
              text-align: center;
            }
          </style>
          <table class="table table-bordered table-hover table-sm">
            <thead class="thead-light">
              <tr>
                <th style="text-align:center;vertical-align:middle; border:1px solid #000;">No</th>
                <th style="text-align:center;vertical-align:middle; border:1px solid #000;">Kegiatan</th>
                <th style="text-align:center;vertical-align:middle; border:1px solid #000;">Output/KRO/RO</th>
                <th style="text-align:center;vertical-align:middle; border:1px solid #000;">Sub Komponen</th>
                <th class="text-end" style="text-align:center; vertical-align:middle; border:1px solid #000;">Pagu</th>
                <th class="text-end" style="text-align:center; vertical-align:middle; border:1px solid #000;" >RPD</th>
                <th class="text-end" style="text-align:center; vertical-align:middle; border:1px solid #000;">Selisih (Pagu - RPD)</th>
              </tr>
            </thead>
            <tbody>
              @php
                // Hitung rowspan berdasarkan kombinasi kegiatan+output dari paginated $summaryData
                $groupCounts = [];
                foreach($summaryData as $row) {
                  $kegiatanVal = isset($row['kegiatan']) ? $row['kegiatan'] : '';
                  $outputVal = isset($row['output']) ? $row['output'] : '';
                  $gk = $kegiatanVal.'|'.$outputVal;
                  if (!isset($groupCounts[$gk])) $groupCounts[$gk] = 0;
                  $groupCounts[$gk]++;
                }
                $lastGroup = null;
              @endphp
              @php
                // Build a global ordered list of unique groups (kegiatan|output)
                // using the full dataset $rencanaAll so we can compute a global
                // group index (continuous across pages) without controller changes.
                $globalGroups = [];
                if (isset($rencanaAll)) {
                  foreach($rencanaAll as $gitem) {
                    $gk = (isset($gitem->kegiatan) ? $gitem->kegiatan : '') . '|' . (isset($gitem->output) ? $gitem->output : '');
                    if (!in_array($gk, $globalGroups)) $globalGroups[] = $gk;
                  }
                }
                // Sort to have deterministic ordering (kegiatan then output lexicographically)
                sort($globalGroups, SORT_STRING);
              @endphp
              @php
                // detect if a kegiatan filter is active for the summary
                $selectedKeg = $selectedSummaryKegiatan ?? request('summary_kegiatan');
                // counter for filtered numbering (starts at 1 when filter active)
                $filterLocalNo = 1;
              @endphp
              @foreach($summaryData as $row)
              @php
                $currentGroup = ($row['kegiatan'] ?? '').'|'.($row['output'] ?? '');
                $isNewGroup = $lastGroup !== $currentGroup;
                if ($isNewGroup) {
                  if ($selectedKeg && $selectedKeg !== '') {
                    // when filtering by kegiatan, only number groups that match the selected kegiatan
                    if ((string)($row['kegiatan'] ?? '') === (string)$selectedKeg) {
                      $groupNo = $filterLocalNo;
                      $filterLocalNo++;
                    } else {
                      $groupNo = '';
                    }
                  } else {
                    // default paginated numbering: position in the global groups
                    $pos = array_search($currentGroup, $globalGroups);
                    $groupNo = ($pos === false) ? 0 : ($pos + 1);
                  }
                }
              @endphp
              <tr>
                @if($isNewGroup)
                  <td rowspan="{{ $groupCounts[$currentGroup] }}" style="vertical-align:top; text-align:center; border:1px solid #000;">{{ $groupNo }}</td>
                @endif
                @if($isNewGroup)
                  <td rowspan="{{ $groupCounts[$currentGroup] }}" style="vertical-align: top; text-align: center; border:1px solid #000;">{{ $row['kegiatan'] }}</td>
                  <td rowspan="{{ $groupCounts[$currentGroup] }}" style="vertical-align: top; text-align: center; border:1px solid #000;">{{ $row['output'] }}</td>
                  @php $lastGroup = $currentGroup; @endphp
                @endif
                <td style="border:1px solid #000;">{{ $row['akun'] }}</td>
                <td style="text-align:right; border:1px solid #000;" class="text-end"><span style="white-space:nowrap;">Rp {{ number_format($row['total_pagu']) }}</span></td>
                <td style="text-align:right; border:1px solid #000;" class="text-end"><span style="white-space:nowrap;">Rp {{ number_format($row['total_rpd']) }}</span></td>
                <td style="text-align:right; border:1px solid #000; color:red;" class="text-end"><span style="white-space:nowrap;">Rp {{ number_format($row['total_pagu'] - $row['total_rpd']) }}</span></td>
              </tr>
              @endforeach
              @if($summaryData->count() === 0)
                <tr>
                  <td colspan="7" style="text-align:center; color:#888; font-style:italic; border:1px solid #000;">Tidak ada data</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
        <!-- Pagination for summary table -->
        @if(empty($selectedSummaryKegiatan) && empty($selectedSummaryOutput))
        @php
          // Gunakan $globalGroups (array 'kegiatan|output') yang sudah dibangun sebelumnya
          $summaryGroups = $globalGroups ?? [];

          // Jika ada filter kegiatan pada ringkasan, hitung total grup yang sesuai filter
          $selectedKeg = $selectedSummaryKegiatan ?? request('summary_kegiatan');
          if ($selectedKeg && $selectedKeg !== '') {
            $summaryTotalGroups = 0;
            foreach ($summaryGroups as $g) {
              $parts = explode('|', $g);
              if ((string)($parts[0] ?? '') === (string)$selectedKeg) $summaryTotalGroups++;
            }
          } else {
            $summaryTotalGroups = is_array($summaryGroups) ? count($summaryGroups) : 0;
          }

          // Build ordered list of unique groups present on this page
          $groupsOnPageOrdered = [];
          foreach ($summaryData as $row) {
            $gk = (isset($row['kegiatan']) ? $row['kegiatan'] : '') . '|' . (isset($row['output']) ? $row['output'] : '');
            if (!in_array($gk, $groupsOnPageOrdered)) $groupsOnPageOrdered[] = $gk;
          }
          $groupsOnPageCount = count($groupsOnPageOrdered);

          // Determine summaryStart/summaryEnd based on global ordering in $summaryGroups (aka $globalGroups)
          if ($groupsOnPageCount > 0) {
            $firstKey = $groupsOnPageOrdered[0];
            $lastKey = $groupsOnPageOrdered[$groupsOnPageCount - 1];
            $firstPos = array_search($firstKey, $summaryGroups);
            $lastPos = array_search($lastKey, $summaryGroups);
            $summaryStart = ($firstPos === false) ? 1 : ($firstPos + 1);
            $summaryEnd = ($lastPos === false) ? $summaryStart : ($lastPos + 1);
          } else {
            $summaryStart = 0;
            $summaryEnd = 0;
          }
        @endphp

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            width:100%;
            margin-top:16px;
            flex-wrap:wrap;            /* AGAR STACK DI MOBILE */
            row-gap:10px;             /* Jarak saat mobile */
        ">

            <!-- Summary Kiri -->
            <div style="
                font-size:0.95rem; 
                white-space:nowrap; 
                line-height:1; 
                flex:1;                /* biar fleksibel */
                min-width:200px;       /* aman di mobile */
            ">
                Menampilkan <strong>{{ $summaryStart }}</strong> -
                <strong>{{ $summaryEnd }}</strong>
                dari <strong>{{ number_format($summaryTotalGroups) }}</strong> hasil
            </div>

            <!-- Pagination Kanan -->
            <div style="
                white-space:nowrap;
                flex:1; 
                text-align:right;
                min-width:200px;        /* agar tidak pecah */
            ">
                <ul class="pagination pagination-sm mb-0" 
                    style="
                        margin:0; 
                        padding:0; 
                        display:inline-flex; 
                        gap:3px;
                        flex-wrap:wrap;        /* RESPONSIVE */
                        justify-content:flex-end;
                    ">

                    {{-- First --}}
                    @if($summaryPage == 1)
                      <li style="list-style:none;" class="disabled"><span class="page-link" style="padding:3px 8px; font-size:0.85rem; border:1px solid #eee; border-radius:4px; color:#999; background:#f7f7f7; display:inline-block;">First</span></li>
                    @else
                      <li style="list-style:none;"><a class="page-link" style="padding:3px 8px; font-size:0.85rem; border:1px solid #ddd; border-radius:4px; display:inline-block; text-decoration:none; color:#007bff; background:#fff;" href="?summary_page=1{{ $outputFilter ? '&summary_output='.urlencode($outputFilter) : '' }}#summary">First</a></li>
                    @endif

                    <li class="page-item {{ $summaryPage == 1 ? 'disabled' : '' }}" style="list-style:none;">
                        <a class="page-link" 
                          style="
                                padding:3px 8px; 
                                border:1px solid #ddd; 
                                border-radius:4px; 
                                text-decoration:none;
                                display:inline-block;
                                font-size:0.85rem;
                            "
                          href="?summary_page={{ max(1, $summaryPage-1) }}@if($summaryOutput)&summary_output={{ $summaryOutput }}@endif#summary">
                            &laquo;
                        </a>
                    </li>

                    @for($i=1; $i<=$summaryPages; $i++)
                        <li class="page-item {{ $i == $summaryPage ? 'active' : '' }}" style="list-style:none;">
                            <a class="page-link" 
                              style="
                                    padding:3px 8px;
                                    border:1px solid #ddd;
                                    border-radius:4px;
                                    text-decoration:none;
                                    display:inline-block;
                                    background:{{ $i == $summaryPage ? '#007bff' : '#fff' }};
                                    color:{{ $i == $summaryPage ? '#fff' : '#007bff' }};
                                "
                              href="?summary_page={{ $i }}@if($summaryOutput)&summary_output={{ $summaryOutput }}@endif#summary">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor

                    <li class="page-item {{ $summaryPage == $summaryPages ? 'disabled' : '' }}" style="list-style:none;">
                        <a class="page-link" 
                          style="
                                padding:3px 8px; 
                                border:1px solid #ddd; 
                                border-radius:4px; 
                                text-decoration:none;
                                display:inline-block;
                            "
                          href="?summary_page={{ min($summaryPages, $summaryPage+1) }}@if($summaryOutput)&summary_output={{ $summaryOutput }}@endif#summary">
                            &raquo;
                        </a>
                    </li>
                    {{-- Last --}}
                    @if($summaryPage == $summaryPages)
                      <li style="list-style:none;" class="disabled"><span class="page-link" style="padding:3px 8px; font-size:0.85rem; border:1px solid #eee; border-radius:4px; color:#999; background:#f7f7f7; display:inline-block;">Last</span></li>
                    @else
                      <li style="list-style:none;"><a class="page-link" style="padding:3px 8px; font-size:0.85rem; border:1px solid #ddd; border-radius:4px; display:inline-block; text-decoration:none; color:#007bff; background:#fff;" href="?summary_page={{ $summaryPages }}{{ $outputFilter ? '&summary_output='.urlencode($outputFilter) : '' }}#summary">Last</a></li>
                    @endif

                </ul>
            </div>
        </div>
        @endif
        <script>
          document.getElementById('summaryOutputFilter').addEventListener('change', function() {
            const val = this.value;
            const url = new URL(window.location.href);
            if(val) url.searchParams.set('summary_output', val); else url.searchParams.delete('summary_output');
            url.searchParams.set('summary_page', 1);
            window.location.href = url.toString();
          });
        </script>
      </div>

      <!-- Tabel Total Target per Output -->
      <div style="margin-top:18px; width:100%; text-align:center;">
        <div style="margin-top:18px; width:100%; text-align:center;">
          <h4 style="font-size:1.1rem; text-align:center; font-weight:500; margin-bottom:10px;">
            Total Pagu & Total RPD per Kegiatan & Output
          </h4>

          @php
            $kegiatanOutputTotals = [];
            foreach($rencanaAll as $item) {
              $key = $item->kegiatan.'|||'.$item->output;
              if (!isset($kegiatanOutputTotals[$key])) {
                $kegiatanOutputTotals[$key] = [
                  'kegiatan' => $item->kegiatan,
                  'output' => $item->output,
                  'pagu' => 0,
                  'rpd' => 0
                ];
              }
              $kegiatanOutputTotals[$key]['pagu'] += $item->target;
              foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m) {
                $kegiatanOutputTotals[$key]['rpd'] += (int)$item->$m;
              }
            }
            $kegiatanOutputSummary = collect($kegiatanOutputTotals)->sortBy([['kegiatan','asc'],['output','asc']]);
          @endphp

          <!-- Table Wrapper -->
          <div style="
            width:100%;
            overflow-x:auto;
            -webkit-overflow-scrolling:touch;
            margin:0 auto;
            padding-bottom:1px; /* hindari clipping di bawah */
          ">
            <table style="
              width:100%;
              border-collapse:collapse;
              border:1px solid #000;
              margin:0 auto;
              table-layout:auto;
            ">
              <thead style="background:#e3f0ff;">
                <tr>
                  <th style="text-align:center; border:1px solid #000; padding:6px;">Kegiatan</th>
                  <th style="text-align:center; border:1px solid #000; padding:6px;">Output</th>
                  <th style="text-align:center; border:1px solid #000; padding:6px;">Pagu</th>
                  <th style="text-align:center; border:1px solid #000; padding:6px;">RPD</th>
                  <th style="text-align:center; border:1px solid #000; padding:6px;">Selisih (Pagu - RPD)</th>
                </tr>
              </thead>
              <tbody>
                @php $grandTotal = 0; $grandTotalRpd = 0; @endphp
                @foreach($kegiatanOutputSummary as $row)
                  @php $grandTotal += $row['pagu']; $grandTotalRpd += $row['rpd']; @endphp
                  <tr>
                    <td style="text-align:center; border:1px solid #000; padding:6px;">{{ $row['kegiatan'] }}</td>
                    <td style="text-align:center; border:1px solid #000; padding:6px;">{{ $row['output'] }}</td>
                    <td style="text-align:right; border:1px solid #000; padding:6px; white-space:nowrap;">Rp {{ number_format($row['pagu']) }}</td>
                    <td style="text-align:right; border:1px solid #000; color:#000; padding:6px; white-space:nowrap;">Rp {{ number_format($row['rpd']) }}</td>
                    <td style="text-align:right; border:1px solid #000; color:#000; padding:6px; color:red; white-space:nowrap;">Rp {{ number_format($row['pagu'] - $row['rpd']) }}</td>
                  </tr>
                @endforeach
                <tr style="background:#f8f9fa; font-weight:bold; color:#000;">
                  <td colspan="2" style="text-align:center; border:1px solid #000; padding:6px;">Total</td>
                  <td style="text-align:right; border:1px solid #000; padding:6px; white-space:nowrap;">Rp {{ number_format($grandTotal) }}</td>
                  <td style="text-align:right; border:1px solid #000; color:#000; padding:6px; white-space:nowrap;">Rp {{ number_format($grandTotalRpd) }}</td>
                  <td style="text-align:right; border:1px solid #000; color:#000; padding:6px; color:red; white-space:nowrap;">Rp {{ number_format($grandTotal - $grandTotalRpd) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      @php
    // Daftar bulan
    $bulanLabels = [
        'jan'=>'Januari',
        'feb'=>'Februari',
        'mar'=>'Maret',
        'apr'=>'April',
        'mei'=>'Mei',
        'jun'=>'Juni',
        'jul'=>'Juli',
        'agt'=>'Agustus',
        'sep'=>'September',
        'okt'=>'Oktober',
        'nov'=>'November',
        'des'=>'Desember'
    ];

    // Jenis belanja yang ingin ditampilkan
    $orderedJenis = ['51','52','53'];

    // Inisialisasi array total per jenis per bulan
    $summaryTable = [];
    foreach ($bulanLabels as $m => $label) {
        foreach ($orderedJenis as $jenis) {
            $summaryTable[$m][$jenis] = 0;
        }
        $summaryTable[$m]['total_bulan'] = 0; // kolom total per bulan
    }

    // Isi data dari $rencanaAll
    foreach($rencanaAll as $item) {
        $jenis = $item->jenis_belanja;
        if(in_array($jenis, $orderedJenis)) {
            foreach(array_keys($bulanLabels) as $m) {
                $val = (int)($item->$m ?? 0);
                $summaryTable[$m][$jenis] += $val;
                $summaryTable[$m]['total_bulan'] += $val; // hitung total bulanan
            }
        }
    }

    // Hitung grand total per jenis
    $grandTotal = [];
    $grandTotal['total_bulan'] = 0;
    foreach ($orderedJenis as $jenis) {
        $grandTotal[$jenis] = array_sum(array_column($summaryTable, $jenis));
        $grandTotal['total_bulan'] += $grandTotal[$jenis]; // grand total keseluruhan
    }
@endphp

<h3 style="text-align:center;font-size:1.1rem;margin-bottom:10px; margin-top:10px; font-weight:500;">
    Ringkasan Total per Jenis Belanja
</h3>
<div style="overflow-x:auto; position:relative; -webkit-overflow-scrolling:touch;">
  <!-- Judul sticky di sebelah kiri ketika scroll horizontal -->

  <table style="width:100%; max-width:950px; margin:8px auto 0; border-collapse:collapse; font-size:0.95rem;">
    <thead>
      <tr style="background:#e3f0ff; color:#000; text-align:center;">
        <!-- Kolom 'Bulan' sticky -->
        <th style="text-align:center; border:1px solid #000; padding:4px 6px;
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
      @foreach($bulanLabels as $m => $label)
        <tr style="text-align:right; color:#000;">
          <td style="border:1px solid #000; padding:3px 6px; text-align:left;
                     position:sticky; left:0; z-index:4; background:#fff;">
            {{ $label }}
          </td>

          @foreach($orderedJenis as $jenis)
            <td style="text-align:right; border:1px solid #000; padding:3px 6px; white-space:nowrap;">
              Rp {{ number_format($summaryTable[$m][$jenis]) }}
            </td>
          @endforeach

          <td style="text-align:right; border:1px solid #000; padding:3px 6px; white-space:nowrap;">
            Rp {{ number_format($summaryTable[$m]['total_bulan']) }}
          </td>
        </tr>
      @endforeach
    </tbody>

    <tfoot style="background:#f9f9f9; font-weight:bold; text-align:right;">
      <tr>
        <td style="border:1px solid #000; padding:3px 6px; text-align:center;
                   position:sticky; left:0; z-index:4; background:#f9f9f9;">
          Grand Total
        </td>

        @foreach($orderedJenis as $jenis)
          <td style="text-align:right; border:1px solid #000; padding:3px 6px; white-space:nowrap;">
            Rp {{ number_format($grandTotal[$jenis]) }}
          </td>
        @endforeach

        <td style="text-align:right; border:1px solid #000; padding:3px 6px; white-space:nowrap;">
          Rp {{ number_format($grandTotal['total_bulan']) }}
        </td>
      </tr>
    </tfoot>
  </table>
</div>

<!-- Modal Gabungan untuk Rencana & Realisasi, grid 4 kolom, kecil -->
<div class="modal" id="dataModal" style="display:none; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.3); z-index:1000;">
  <div class="modal-content" style="max-width:500px; width:98%; padding:24px 24px 18px 24px; border-radius:14px; background:#fff; box-shadow:0 4px 24px #0002; display:flex; flex-direction:column;">
    <div class="modal-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
      <h2 id="modalTitle" style="margin:0; font-size:1.1rem;">Tambah Data</h2>
      <span class="close" id="closeModal" style="cursor:pointer; font-size:1.3rem;">&times;</span>
    </div>
    <form id="dataForm">
      <div class="form-section" style="margin-bottom:10px;">
        <h3 style="text-align:left; margin-bottom:6px; font-size:1rem;">Informasi Utama</h3>
          <div class="grid-main" style="display:grid; grid-template-columns:1fr 1fr; column-gap:32px; row-gap:2px;">
            <div style="text-align:left;">
            <label>Kegiatan</label>
                @if(auth()->user() && auth()->user()->role === 'user')
                  <select id="kegiatan" name="kegiatan" required disabled tabindex="-1" data-readonly="1" class="disabled-readonly-select" style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc; background:#f5f5f5; cursor:not-allowed; pointer-events:none;">
                @else
                  <select id="kegiatan" name="kegiatan" required style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc;">
                @endif
                    <option value="">- Pilih Kegiatan -</option>
                    @if(isset($kegiatans))
                      @foreach($kegiatans as $keg)
                        <option value="{{ $keg->kode }}">{{ $keg->kode }}@if($keg->nama) - {{ $keg->nama }}@endif</option>
                      @endforeach
                    @endif
                </select>
            </div>
            <div style="text-align:left;">
              <label>Output/KRO/RO</label>
              <select id="output" required
                @if(auth()->user() && auth()->user()->role === 'user')
                  disabled
                  tabindex="-1"
                  data-readonly="1"
                  class="disabled-readonly-select"
                  style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc; background:#f5f5f5; cursor:not-allowed; pointer-events:none;"
                @else
                  style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc;"
                @endif
              >
                  <option value="">- Pilih Output -</option>
                @if(isset($allOutputs))
                  @foreach($allOutputs as $o)
                    @php $kcodes = $o->kegiatans->pluck('kode')->join(','); @endphp
                    <option value="{{ $o->kode }}" data-output-id="{{ $o->id_output }}" data-kegiatan="{{ $kcodes }}">{{ $o->kode }}@if($o->nama) - {{ $o->nama }}@endif</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div style="text-align:left;">
              <label>Komponen</label>
                <input type="text" id="komponen" name="komponen" required style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc; @if(auth()->user() && auth()->user()->role === 'user') background:#f5f5f5; cursor:not-allowed; @endif" @if(auth()->user() && auth()->user()->role === 'user') readonly @endif>
            </div>
            <div style="text-align:left;">
              <label>Jenis Belanja</label>
                <select id="jenis_belanja" name="jenis_belanja" required style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc; @if(auth()->user() && auth()->user()->role === 'user') background:#f5f5f5; cursor:not-allowed; @endif" @if(auth()->user() && auth()->user()->role === 'user') disabled @endif>
                  <option value="">- Pilih Jenis Belanja -</option>
                  <option value="51">51</option>
                  <option value="52">52</option>
                  <option value="53">53</option>
              </select>
            </div>
            <div style="text-align:left;">
              <label>Bagian Kelompok Substansi</label>
                <select id="unit_kerja" name="unit_kerja" required style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc; @if(auth()->user() && auth()->user()->role === 'user') background:#f5f5f5; cursor:not-allowed; @endif" @if(auth()->user() && auth()->user()->role === 'user') disabled @endif>
                  <option value="">- Pilih Bag. Kelompok Substansi -</option>
                  <option option value="Penyedik">Penyedik</option>
                  <option value="Sijitu">Sijitu</option>
                  <option value="Renbang">Renbang</option>
                  <option value="Umum">Umum</option>
              </select>
            </div>
            <div id="wrap-akun" style="display:none; text-align:left;">
            <label>Sub Komponen</label>
              <select id="akun" required
                style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc;
                  @if(auth()->user()->role === 'user') background:#f5f5f5; cursor:not-allowed; @endif"
                  @if(auth()->user()->role === 'user') disabled @endif>
                    <option value="">- Pilih Sub Komponen -</option>
                            @if(isset($allAkuns))
                              @foreach($allAkuns as $a)
                                <option value="{{ $a->id_akun }}"
                                    data-akun-kode="{{ $a->kode }}"
                                    data-akun-nama="{{ $a->nama }}">
                                    {{ $a->kode }} - {{ $a->nama }}
                                </option>
                              @endforeach
                            @else
                              @foreach($akuns as $a)
                                <option value="{{ $a->id_akun }}"
                                    data-akun-kode="{{ $a->kode }}"
                                    data-akun-nama="{{ $a->nama }}">
                                    {{ $a->kode }} - {{ $a->nama }}
                                </option>
                              @endforeach
                            @endif
                </select>
            </div>
            <div id="wrap-uraian" style="display:none; text-align:left;">
              <label>Akun</label>
              <select id="uraian" required style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc; @if(auth()->user() && auth()->user()->role === 'user') background:#f5f5f5; cursor:not-allowed; @endif" @if(auth()->user() && auth()->user()->role === 'user') disabled @endif>
                <option value="">- Pilih Akun -</option>
                @foreach($uraians as $u)
                  <option value="{{ $u->id_uraian }}" data-uraian-kode="{{ $u->kode }}" data-uraian-nama="{{ $u->nama }}">{{ $u->kode }} - {{ $u->nama }}</option>
                @endforeach
              </select>
          </div>
          <div style="text-align:left;">
            <label>Uraian Kegiatan (Opsional)</label>
              <input type="text" id="uraians" name="uraians" style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc; @if(auth()->user() && auth()->user()->role === 'user') background:#f5f5f5; cursor:not-allowed; @endif" @if(auth()->user() && auth()->user()->role === 'user') readonly @endif>
          </div>
          <label style="text-align:left;">Pagu
            <input type="number" id="target" value="0" required style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc; @if(auth()->user() && auth()->user()->role === 'user') background:#f5f5f5; cursor:not-allowed; @endif" @if(auth()->user() && auth()->user()->role === 'user') readonly @endif>
          </label>
        </div>
      </div>
      <div class="form-section" style="margin-bottom:10px;">
        <h3 style="margin-bottom:6px; font-size:1rem; text-align:left;">Rencana per Bulan</h3>
        <div class="grid-bulan" style="text-align:left; display:grid; grid-template-columns:repeat(2, 1fr); column-gap:28px; row-gap:2px;">
          @foreach(['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'] as $m)
          <div>
            <label>{{ $m }}</label>
            <input type="number" id="bulan-{{ $m }}" value="0" required style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc; @if(auth()->user() && auth()->user()->role === 'user') background:#f5f5f5; cursor:not-allowed; @endif" @if(auth()->user() && auth()->user()->role === 'user') readonly @endif>
          </div>
          @endforeach
        </div>
      </div>
      {{-- Keterangan --}}
      <div style="text-align:left; margin-top:12px; background:#f9f9f9; border-left:4px solid #007bff; padding:10px 12px; border-radius:6px; font-size:0.9rem; color:#333;">
        <strong>Keterangan:</strong>
        <ul style="margin-top:6px; margin-left:18px; list-style-type:disc;">
          @if(auth()->user() && auth()->user()->role === 'admin')
            <li>Setiap kolom bulan <strong>wajib diisi</strong> dan tidak boleh kosong.</li>
            <li>Jika tidak ada rencana pada bulan tertentu, isi dengan <strong>0 (nol)</strong> sebagai nilai default.</li>
            <li>Nilai input harus berupa <strong>angka bulat (integer)</strong>.</li>
          @endif

          @if(auth()->user() && auth()->user()->role === 'user')
            <li>Bagi pengguna dengan peran <em>User</em>, kolom hanya dapat dilihat (tidak bisa diubah).</li>
          @endif
        </ul>
      </div>
      <div class="modal-footer" style="display:flex; justify-content:flex-end; margin-top:8px;">
        @if(! (auth()->user() && auth()->user()->role === 'user'))
          <button type="submit" class="btn primary" style="padding:6px 12px; font-size:0.95rem; background:#007bff; color:#fff; border:none; border-radius:4px; cursor:pointer; transition:0.2s;"
            onmouseover="this.style.background='#0069d9'"
            onmouseout="this.style.background='#007bff'"
            >💾 Simpan
          </button>
        @endif
      </div>
    </form>
  </div>
</div>

<!-- Script AJAX -->
<script src="{{ asset('js/rencana.js') }}"></script>
<script>
// Output mapping from backend
const outputMap = @json($outputMap);
function filterAkunUraianByOutput() {
  const outputEl = document.getElementById('output');
  const output = outputEl ? outputEl.value : '';
  const akunSelect = document.getElementById('akun');
  const uraianSelect = document.getElementById('uraian');
  const wrapAkun = document.getElementById('wrap-akun');
  const wrapUraian = document.getElementById('wrap-uraian');
  const kegiatanVal = (document.getElementById('kegiatan') && document.getElementById('kegiatan').value) || '';
  // Show/hide akun & uraian
  if (output) {
    wrapAkun.style.display = '';
    wrapUraian.style.display = '';
  } else {
    wrapAkun.style.display = 'none';
    wrapUraian.style.display = 'none';
  }
  // Akun
  Array.from(akunSelect.options).forEach(opt => {
    if (!opt.value) return opt.style.display = '';

    const output = outputEl ? outputEl.value : '';
    const kegiatanVal = (document.getElementById('kegiatan') && document.getElementById('kegiatan').value) || '';

    // Gunakan kegiatan + output untuk lookup akun yang valid
    if (output && kegiatanVal && outputMap[output] && outputMap[output][kegiatanVal]) {
      const allowedAkunIds = outputMap[output][kegiatanVal].akuns;
      if (allowedAkunIds.includes(parseInt(opt.value))) {
        opt.style.display = '';
      } else {
        opt.style.display = 'none';
      }
      return;
    }

    // Jika tidak ada mapping kegiatan+output, sembunyikan
    if (output) {
      opt.style.display = 'none';
      return;
    }

    // Jika tidak ada output yang dipilih, tampilkan semua
    opt.style.display = '';
  });
  
  // Uraian (special-case: when output === 'EBA.994' we also filter by kegiatan)
  Array.from(uraianSelect.options).forEach(opt => {
    if (!opt.value) return opt.style.display = '';
    
    const output = outputEl ? outputEl.value : '';
    const kegiatanVal = (document.getElementById('kegiatan') && document.getElementById('kegiatan').value) || '';

    // Sembunyikan 524119 jika output DCF.001
    if (opt.getAttribute('data-hide-on-dcf001') === '1' && output === 'DCF.001') {
      opt.style.display = 'none';
      return;
    }

    // Gunakan kegiatan + output untuk lookup uraian yang valid
    if (output && kegiatanVal && outputMap[output] && outputMap[output][kegiatanVal]) {
      const allowedUraianIds = outputMap[output][kegiatanVal].uraians;
      if (allowedUraianIds.includes(parseInt(opt.value))) {
        opt.style.display = '';
      } else {
        opt.style.display = 'none';
      }
      return;
    }

    // Jika tidak ada mapping kegiatan+output, sembunyikan
    if (output) {
      opt.style.display = 'none';
      return;
    }

    // Jika tidak ada output yang dipilih, tampilkan semua
    opt.style.display = '';
  });
  // Reset selection if not valid - SELALU reset jika option tidak visible
  if (akunSelect.value && akunSelect.options[akunSelect.selectedIndex] && akunSelect.options[akunSelect.selectedIndex].style.display === 'none') {
    akunSelect.value = '';
  }
  if (uraianSelect.value && uraianSelect.options[uraianSelect.selectedIndex] && uraianSelect.options[uraianSelect.selectedIndex].style.display === 'none') {
    uraianSelect.value = '';
  }
}
const _outEl_for_filter = document.getElementById('output');
let _isLoadingData = false; // Flag untuk mencegah reset saat loading data
if (_outEl_for_filter) {
  _outEl_for_filter.addEventListener('change', function() {
    // Hanya filter jika bukan sedang loading data dari edit form
    if (!_isLoadingData) {
      filterAkunUraianByOutput();
    }
  });
}

// Juga filter akun ketika kegiatan berubah di saat bukan loading
const _kegEl = document.getElementById('kegiatan');
if (_kegEl) {
  _kegEl.addEventListener('change', function() {
    if (!_isLoadingData) {
      filterAkunUraianByOutput();
    }
  });
}

if (document.getElementById('openModalBtn')) document.getElementById('openModalBtn').addEventListener('click', filterAkunUraianByOutput);

// Enable/disable dan filter opsi output pada form tambah/edit data
const kegiatanInput = document.getElementById('kegiatan');
const outputInput = document.getElementById('output');
// Current authenticated user role (empty string when not authenticated)
const _currentUserRole = "{{ auth()->user()->role ?? '' }}";
if (kegiatanInput && outputInput) {
  function updateOutputState() {
    // If current user is role `user`, keep output disabled regardless of other state
    if (_currentUserRole === 'user') {
      // Force fully non-interactive state for `user` role
      outputInput.disabled = true;
      outputInput.setAttribute('disabled', 'disabled');
      outputInput.style.background = '#f5f5f5';
      outputInput.style.cursor = 'not-allowed';
      outputInput.style.pointerEvents = 'none';
      // remove from tab order
      try { outputInput.tabIndex = -1; } catch(e){}
      // prevent accidental programmatic focus/interaction
      outputInput.addEventListener('mousedown', function(e){ e.preventDefault(); e.stopPropagation(); }, {capture:true});
      outputInput.addEventListener('click', function(e){ e.preventDefault(); e.stopPropagation(); }, {capture:true});
      outputInput.addEventListener('keydown', function(e){ e.preventDefault(); e.stopPropagation(); }, {capture:true});
      // also add an inert overlay style so it's visually obvious
      outputInput.classList.add('disabled-readonly-select');
      return;
    }

    const keg = kegiatanInput.value;
    let hasKeg = !!keg;
    outputInput.disabled = !hasKeg;
    // Tampilkan/hide opsi sesuai kegiatan
    Array.from(outputInput.options).forEach(opt => {
      if (!opt.value) return opt.style.display = '';
      if (!hasKeg) {
        opt.style.display = 'none';
      } else {
        // Tampilkan jika data-kegiatan mengandung kode kegiatan atau 'all'
        const allowed = (opt.dataset.kegiatan || '').split(',');
        if (allowed.includes(keg) || allowed.includes('all')) opt.style.display = '';
        else opt.style.display = 'none';
      }
    });
    // Reset value jika tidak valid
    if (!hasKeg) outputInput.value = '';
    else if (outputInput.options[outputInput.selectedIndex] && outputInput.options[outputInput.selectedIndex].style.display === 'none') outputInput.value = '';
  }
  kegiatanInput.addEventListener('change', updateOutputState);
  // Inisialisasi saat load
  updateOutputState();
}

// Re-filter akun/uraian when kegiatan changes in the modal form (so EBA.994 special-case works)
if (document.getElementById('kegiatan')) {
  document.getElementById('kegiatan').addEventListener('change', function() {
    // small timeout to allow output state update to run first
    setTimeout(filterAkunUraianByOutput, 50);
  });
}

// Filter tabel saat dropdown output diubah
if(document.getElementById('filterOutput')){
  document.getElementById('filterOutput').addEventListener('change', function() {
    const val = this.value;
    const url = new URL(window.location.href);
    if(val) url.searchParams.set('output', val); else url.searchParams.delete('output');
    window.location.href = url.toString();
  });
}
// Otomatis filter tabel sesuai output yang dipilih di modal tambah data
if(document.getElementById('output')){
  document.getElementById('output').addEventListener('change', function() {
    const val = this.value;
    if(val) document.getElementById('filterOutput').value = val;
  });
}
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
    @media (max-width: 640px) {
    .form-tahun {
      width: 100%;
    }
  }
}
</style>
@endsection
