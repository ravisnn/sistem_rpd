@extends('layouts.app')

@section('content')
<!-- Chart.js CDN (modern) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.tailwindcss.com"></script>

@php
  // SAFETY / FALLBACKS - jangan ubah nama variabel utama
  $summaryOutput = $summaryOutput ?? [];
  $summaryUnitKerja = $summaryUnitKerja ?? [];
  $summaryJenisBelanjaBulan = $summaryJenisBelanjaBulan ?? [];
  $summaryJenisBelanjaBulanRencana = $summaryJenisBelanjaBulanRencana ?? [];
  $bulanLabels = $bulanLabels ?? ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
  $orderJenis = $orderJenis ?? ['51','52','53'];

  // Totals (safe)
  $totalPagu = $totalPagu ?? (is_array($summaryUnitKerja) ? array_sum(array_column($summaryUnitKerja, 'total_pagu')) : 0);
  $totalRpd = is_array($summaryOutput) ? array_sum(array_column($summaryOutput, 'total_rpd')) : 0;
  $totalRealisasiNominal = $totalRealisasiNominal ?? (is_array($summaryOutput) ? array_sum(array_column($summaryOutput, 'total_realisasi')) : 0);

  $selisihPaguRpd = $totalPagu - $totalRpd;
  $selisihRpdRealisasi = $totalRpd - $totalRealisasiNominal;
  $selisihPaguRealisasi = $totalPagu - $totalRealisasiNominal;

  // Ensure summaryOutput list is array_values for consistent ordering
  $summaryOutputList = is_array($summaryOutput) ? array_values($summaryOutput) : [];

  // Prepare jenis belanja summary if not provided (safe fallback)
  $ringkasanJenisBelanja = $ringkasanJenisBelanja ?? [];
  if (!is_array($ringkasanJenisBelanja) || count($ringkasanJenisBelanja) === 0) {
    foreach ($orderJenis as $j) {
      $bulanReal = is_array($summaryJenisBelanjaBulan[$j] ?? null) ? $summaryJenisBelanjaBulan[$j] : array_fill(0, count($bulanLabels), 0);
      $bulanRenc = is_array($summaryJenisBelanjaBulanRencana[$j] ?? null) ? $summaryJenisBelanjaBulanRencana[$j] : array_fill(0, count($bulanLabels), 0);
      $pagu = 0;
      $rpd = array_sum($bulanRenc);
      $realisasi = array_sum($bulanReal);
      $ringkasanJenisBelanja[$j] = ['label' => $j, 'pagu' => $pagu, 'rpd' => $rpd, 'realisasi' => $realisasi];
    }
  }

  // Grand totals for jenis belanja
  $grandJenisPagu = 0; $grandJenisRpd = 0; $grandJenisRealisasi = 0;
  foreach ($ringkasanJenisBelanja as $k => $v) {
    $grandJenisPagu += $v['pagu'] ?? 0;
    $grandJenisRpd += $v['rpd'] ?? 0;
    $grandJenisRealisasi += $v['realisasi'] ?? 0;
  }
@endphp
{{-- ================= FILTER TAHUN ================= --}}
    <form method="get" class="flex items-center gap-2">
        <label for="tahun" class="text-base">Tahun:</label>
        <input type="number" name="tahun" id="tahun"
               value="{{ $tahun ?? date('Y') }}"
               min="2020" max="2100"
               class="filter-tahun w-24 px-2 py-1 rounded border border-gray-300">
        <button type="submit" style="cursor: pointer; padding:4px 14px; border-radius:4px; background:#007bff; color:#fff; border:none; transition: 0.2s;"
          onmouseover="this.style.background='#0056b3'"
          onmouseout="this.style.background='#007bff'"
          >Tampilkan
        </button>
    </form>
  <h1 style="text-align:center; font-size:2.2rem;font-weight:700;letter-spacing:-1px;">Dashboard</h1>
  <div style="width:100%; max-width:100%; padding:0; margin:0;">
  <div style="width:100%; background:#fff; border-radius:6px;">
    <!-- FLEX 2 KOLOM -->
    <div class="flex flex-wrap lg:flex-nowrap gap-8 items-stretch mb-8">
      {{-- Statistik Card --}}
      <div class="bg-white rounded-xl shadow-lg p-7 flex-1 min-w-[320px]">

        <h2 class="text-xl font-semibold mb-5">
          Statistik Ringkasan (Tahun {{ $tahun ?? date('Y') }})
        </h2>

        <div class="space-y-4">

          <div class="flex justify-between border-b pb-2">
            <span class="text-gray-600">Total Pagu</span>
            <span class="text-lg font-bold">Rp {{ number_format($totalPagu,0,',','.') }}</span>
          </div>

          <div class="flex justify-between border-b pb-2">
            <span class="text-gray-600">Total RPD</span>
            <span class="text-lg font-semibold">Rp {{ number_format($totalRpd,0,',','.') }}</span>
          </div>

          <div class="flex justify-between border-b pb-2">
            <span class="text-gray-600">Total Realisasi</span>
            <span class="text-lg font-semibold">Rp {{ number_format($totalRealisasiNominal,0,',','.') }}</span>
          </div>

          <!-- RINGKASAN SELISIH -->
          <div style="margin-top:30px; font-size:0.8rem;" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 pt-4">

            <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-3">
              <div style="font-size:0.8rem;" class="text-yellow-700 text-sm">Selisih (Pagu - RPD)</div>
              <div class="font-semibold text-yellow-700 whitespace-nowrap">
                Rp {{ number_format($selisihPaguRpd,0,',','.') }}
              </div>
            </div>

            <div class="bg-red-50 border border-red-300 rounded-lg p-3">
              <div style="font-size:0.8rem;" class="text-red-700 text-sm">Selisih (RPD - Realisasi)</div>
              <div class="font-semibold text-red-700 whitespace-nowrap">
                Rp {{ number_format($selisihRpdRealisasi,0,',','.') }}
              </div>
            </div>

            <div class="bg-green-50 border border-green-300 rounded-lg p-3">
              <div style="font-size:0.8rem;" class="text-green-700 text-sm">Selisih (Pagu - Realisasi)</div>
              <div class="font-semibold text-green-700 whitespace-nowrap">
                Rp {{ number_format($selisihPaguRealisasi,0,',','.') }}
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Chart Donut --}}
      <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center justify-center flex-1 min-w-[320px]">
        <h2 class="text-xl font-semibold mb-4">Ringkasan Selisih</h2>

        <div class="w-full max-w-[300px] h-[300px]">
          <canvas id="statistikChartDonut"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
  <!-- Full width sections below -->
  <!-- 1) Ringkasan Kegiatan & Output (full width) -->
  <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
    <h3 style="text-align:center; font-weight:600; font-size:1.1rem; margin-bottom:10px;">Ringkasan Total per Kegiatan & Output (Tahun {{ $tahun }})</h3>

    <div class="overflow-x-auto mb-4">
  <table class="min-w-full text-sm text-gray-700 table-auto">
    <thead class="bg-blue-50">
      <tr>
        <th class="py-2 px-3 text-center border" style="text-align:center; border:1px solid #000;">Kegiatan</th>
        <th class="py-2 px-3 text-center border" style="text-align:center; border:1px solid #000;">Output/KRO/RO</th>
        <th class="py-2 px-3 text-center border" style="text-align:center; border:1px solid #000;">Pagu</th>
        <th class="py-2 px-3 text-center border" style="text-align:center; border:1px solid #000;">RPD</th>
        <th class="py-2 px-3 text-center border" style="text-align:center; border:1px solid #000;">Realisasi</th>
        <th class="py-2 px-3 text-center border" style="text-align:center; border:1px solid #000;">Selisih (Pagu - RPD)</th>
        <th class="py-2 px-3 text-center border" style="text-align:center; border:1px solid #000;">Selisih (RPD - Realisasi)</th>
        <th class="py-2 px-3 text-center border" style="text-align:center; border:1px solid #000;">Selisih (Pagu - Realisasi)</th>
      </tr>
    </thead>

    <tbody>
      @foreach($summaryOutput as $key => $row)
      <tr class="hover:bg-gray-50">
        <td class="py-2 px-3 border whitespace-normal wrap-break-word max-w-[200px] text-center" style="text-align:center; border:1px solid #000;">
          {{ $row['kegiatan'] ?? '-' }}
        </td>
        <td class="py-2 px-3 border whitespace-normal wrap-break-word max-w-[200px] text-center" style="text-align:center; border:1px solid #000;">
          {{ $row['output'] ?? '-' }}
        </td>
        <td class="py-2 px-3 border text-right nowrap-number" style="text-align:right; border:1px solid #000;">Rp {{ number_format($row['total_pagu'],0,',','.') }}</td>
        <td class="py-2 px-3 border text-right nowrap-number" style="text-align:right; border:1px solid #000;">Rp {{ number_format($row['total_rpd'],0,',','.') }}</td>
        <td class="py-2 px-3 border text-right nowrap-number" style="text-align:right; border:1px solid #000;">Rp {{ number_format($row['total_realisasi'],0,',','.') }}</td>
        <td class="py-2 px-3 border text-right nowrap-number text-red-700" style="text-align:right; border:1px solid #000; color:red;">Rp {{ number_format(($row['total_pagu'] ?? 0) - ($row['total_rpd'] ?? 0),0,',','.') }}</td>
        <td class="py-2 px-3 border text-right nowrap-number text-red-700" style="text-align:right; border:1px solid #000; color:red;">Rp {{ number_format($row['total_rpd'] - $row['total_realisasi'],0,',','.') }}</td>
        <td class="py-2 px-3 border text-right nowrap-number text-red-700" style="text-align:right; border:1px solid #000; color:red;">Rp {{ number_format(($row['total_pagu'] ?? 0) - ($row['total_realisasi'] ?? 0),0,',','.') }}</td>
      </tr>
      @endforeach
        @php
          $grandPagu = array_sum(array_column($summaryOutput, 'total_pagu'));
          $grandRpd = array_sum(array_column($summaryOutput, 'total_rpd'));
          $grandRealisasi = array_sum(array_column($summaryOutput, 'total_realisasi'));
          $grandSelisih = $grandRpd - $grandRealisasi;
            $grandSelisihPaguRpd = $grandPagu - $grandRpd;
            $grandSelisihPaguRealisasi = $grandPagu - $grandRealisasi;
        @endphp
        <tr class="bg-blue-50 font-semibold">
          <td colspan="2" class="py-2 px-3 text-center" style="text-align:center; font-weight:bold; border:1px solid #000;">Total</td>
          <td class="py-2 px-3 text-right nowrap-number" style="text-align:right; font-weight:bold; border:1px solid #000;">Rp {{ number_format($grandPagu,0,',','.') }}</td>
          <td class="py-2 px-3 text-right nowrap-number" style="text-align:right; font-weight:bold; border:1px solid #000;">Rp {{ number_format($grandRpd,0,',','.') }}</td>
          <td class="py-2 px-3 text-right nowrap-number" style="text-align:right; font-weight:bold; border:1px solid #000;">Rp {{ number_format($grandRealisasi,0,',','.') }}</td>
          <td class="py-2 px-3 text-right nowrap-number text-yellow-700" style="text-align:right; font-weight:bold; color:red; border:1px solid #000;">Rp {{ number_format($grandSelisihPaguRpd,0,',','.') }}</td>
          <td class="py-2 px-3 text-right nowrap-number text-red-600" style="text-align:right; font-weight:bold; color:red; border:1px solid #000;">Rp {{ number_format($grandSelisih,0,',','.') }}</td>
          <td class="py-2 px-3 text-right nowrap-number text-green-700" style="text-align:right; font-weight:bold; color:red; border:1px solid #000;">Rp {{ number_format($grandSelisihPaguRealisasi,0,',','.') }}</td>
        </tr>
    </tbody>
  </table>
</div>

    <!-- Chart for Kegiatan & Output (placed under the table as requested) -->
    <div class="mt-4">
      <h4 class="text-sm text-gray-600 mb-2 text-center">Chart: Ringkasan per Kegiatan & Output</h4>
      <div class="w-full">
        <canvas id="outputChartBar" height="160"></canvas>
      </div>
    </div>
  </div>

  <!-- 2) Ringkasan Bagian Kelompok Substansi (full width) -->
  <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
    <h3 style="text-align:center; font-weight:600; font-size:1.1rem; margin-bottom:10px;">Ringkasan Total per Bagian Kelompok Substansi (Tahun {{ $tahun }})</h3>

    <div class="overflow-x-auto mb-4">
      <table class="min-w-full text-sm text-gray-700">
        <thead class="bg-blue-50">
          <tr>
            <th class="py-2 px-3 text-center border" style="text-align:center; border:1px solid #000;">Bagian Kelompok Substansi</th>
            <th class="py-2 px-3 text-center border" style="text-align:center; border:1px solid #000;">Pagu</th>
            <th class="py-2 px-3 text-center border" style="text-align:center; border:1px solid #000;">RPD</th>
            <th class="py-2 px-3 text-center border" style="text-align:center; border:1px solid #000;">Realisasi</th>
            <th class="py-2 px-3 text-center border" style="text-align:center; border:1px solid #000;">Selisih (Pagu - RPD)</th>
            <th class="py-2 px-3 text-center border" style="text-align:center; border:1px solid #000;">Deviasi</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          @php $totalPaguUK = 0; $totalRpdUK = 0; $totalRealisasiUK = 0; $totalSelisihPaguRpdUK = 0; $totalDeviasiUK = 0; @endphp
          @foreach($summaryUnitKerja as $unit => $row)
            @php
              $paguU = $row['total_pagu'] ?? 0;
              $rpdU = $row['total_rpd'] ?? 0;
              $realU = $row['total_realisasi'] ?? 0;
              $devU = $row['deviasi'] ?? 0;
              $selisihPaguRpdU = $paguU - $rpdU;
              $totalPaguUK += $paguU;
              $totalRpdUK += $rpdU;
              $totalRealisasiUK += $realU;
              $totalSelisihPaguRpdUK += $selisihPaguRpdU;
              $totalDeviasiUK += $devU;
            @endphp
            <tr class="hover:bg-gray-50">
              <td class="py-2 px-3 text-center border" style="text-align:center; border:1px solid #000;">{{ $unit }}</td>
              <td class="py-2 px-3 text-center border" style="text-align:right; border:1px solid #000; white-space:nowrap;">Rp {{ number_format($paguU,0,',','.') }}</td>
              <td class="py-2 px-3 text-center border" style="text-align:right; border:1px solid #000; white-space:nowrap;">Rp {{ number_format($rpdU,0,',','.') }}</td>
              <td class="py-2 px-3 text-center border" style="text-align:right; border:1px solid #000; white-space:nowrap;">Rp {{ number_format($realU,0,',','.') }}</td>
              <td class="py-2 px-3 text-center border" style="text-align:right; border:1px solid #000; color:red; white-space:nowrap;">Rp {{ number_format($selisihPaguRpdU,0,',','.') }}</td>
              <td class="py-2 px-3 text-center border" style="text-align:right; color:red; border:1px solid #000; white-space:nowrap;">Rp {{ number_format($devU,0,',','.') }}</td>
            </tr>
          @endforeach
          <tr class="bg-blue-50 font-semibold">
            <td class="py-2 px-3" style="text-align:center; font-weight:bold; border:1px solid #000;">Total</td>
            <td class="py-2 px-3" style="text-align:right; font-weight:bold; border:1px solid #000; white-space:nowrap;">Rp {{ number_format($totalPaguUK,0,',','.') }}</td>
            <td class="py-2 px-3" style="text-align:right; font-weight:bold; border:1px solid #000; white-space:nowrap;">Rp {{ number_format($totalRpdUK,0,',','.') }}</td>
            <td class="py-2 px-3" style="text-align:right; font-weight:bold; border:1px solid #000; white-space:nowrap;">Rp {{ number_format($totalRealisasiUK,0,',','.') }}</td>
            <td class="py-2 px-3" style="text-align:right; font-weight:bold; border:1px solid #000; color:red; white-space:nowrap;">Rp {{ number_format($totalSelisihPaguRpdUK,0,',','.') }}</td>
            <td class="py-2 px-3" style="text-align:right; font-weight:bold; color:red; border:1px solid #000; white-space:nowrap;">Rp {{ number_format($totalDeviasiUK,0,',','.') }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Chart for Bagian Kelompok Substansi (under the table) -->
    <div class="mt-4">
      <h4 class="text-sm text-gray-600 mb-2 text-center">Chart: Ringkasan per Bagian Kelompok Substansi</h4>
      <div class="w-full">
        <canvas id="unitKerjaChart" height="160"></canvas>
      </div>
    </div>
  </div>

  <!-- 3) Ringkasan Jenis Belanja (Realisasi per bulan) -->
  <div style="width:100%; background:#fff; border-radius:6px; padding:12px; margin-top:10px;">
  <h3 style="text-align:center; font-weight:600; font-size:1.1rem; margin-bottom:10px;">
    Ringkasan Total per Bulan dan Jenis Belanja (Sumber Data Realisasi)
  </h3>

  <div style="overflow-x:auto;">
    <table style="width:100%; border-collapse:collapse; font-size:14px; border:1px solid #000;">
      <thead style="background:#e7f1ff;">
        <tr>
          <th style="border:1px solid #000; padding:4px; text-align:center;">Bulan</th>
          @foreach($orderJenis as $jenis)
            <th style="border:1px solid #000; padding:4px; text-align:center;">Jenis Belanja {{ $jenis }}</th>
          @endforeach
          <th style="border:1px solid #000; padding:4px; text-align:center;">Total Bulanan</th>
        </tr>
      </thead>
      <tbody>
        @php
          $grandTotalJenis = array_fill_keys($orderJenis, 0); // total per jenis
          $grandTotalKeseluruhan = 0;
        @endphp

        @foreach($bulanLabels as $m => $label)
          @php
            $namaBulan = match($label) {
              'Jan' => 'Januari', 'Feb' => 'Februari', 'Mar' => 'Maret', 'Apr' => 'April',
              'May' => 'Mei', 'Jun' => 'Juni', 'Jul' => 'Juli', 'Aug' => 'Agustus',
              'Sep' => 'September', 'Oct' => 'Oktober', 'Nov' => 'November', 'Dec' => 'Desember',
              default => $label,
            };
            $totalBulan = 0;
          @endphp
          <tr>
            <td style="border:1px solid #000; padding:4px;">{{ $namaBulan }}</td>
            @foreach($orderJenis as $jenis)
              @php
                $nilai = $summaryJenisBelanjaBulan[$jenis][$m] ?? 0;
                $grandTotalJenis[$jenis] += $nilai;
                $totalBulan += $nilai;
              @endphp
              <td style="border:1px solid #000; padding:4px; text-align:right; white-space:nowrap;">
                Rp {{ number_format($nilai,0,',','.') }}
              </td>
            @endforeach
            <td style="border:1px solid #000; padding:4px; text-align:right; font-weight:600; white-space:nowrap;">
              Rp {{ number_format($totalBulan,0,',','.') }}
            </td>
            @php $grandTotalKeseluruhan += $totalBulan; @endphp
          </tr>
        @endforeach
      </tbody>

      <tfoot style="background:#f3f3f3; font-weight:bold;">
        <tr>
          <td style="border:1px solid #000; padding:5px; text-align:center;">Grand Total</td>
          @foreach($orderJenis as $jenis)
            <td style="border:1px solid #000; padding:5px; text-align:right; white-space:nowrap;">
              Rp {{ number_format($grandTotalJenis[$jenis],0,',','.') }}
            </td>
          @endforeach
          <td style="border:1px solid #000; padding:5px; text-align:right; white-space:nowrap;">
            Rp {{ number_format($grandTotalKeseluruhan,0,',','.') }}
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

  <!-- 4) Ringkasan Jenis Belanja (Rencana per bulan) -->
  <div style="width:100%; background:#fff; border-radius:8px; padding:16px; margin-top:20px;">
  <h3 style="text-align:center; font-weight:600; font-size:1.1rem; margin-bottom:10px;">
    Ringkasan Total per Bulan dan Jenis Belanja (Sumber Data Rencana Kegiatan)
  </h3>

  <div style="overflow-x:auto;">
    <table style="width:100%; border-collapse:collapse; font-size:14px; border:1px solid #000;">
      <thead style="background:#eaf2ff;">
        <tr>
          <th style="border:1px solid #000; padding:5px; text-align:center;">Bulan</th>
          @foreach($orderJenis as $jenis)
            <th style="border:1px solid #000; padding:5px; text-align:center;">Jenis Belanja {{ $jenis }}</th>
          @endforeach
          <th style="border:1px solid #000; padding:5px; text-align:center;">Total Bulanan</th>
        </tr>
      </thead>

      <tbody>
        @php
          $grandTotalJenis = array_fill_keys($orderJenis, 0);
          $grandTotalKeseluruhan = 0;
        @endphp

        @foreach($bulanLabels as $m => $label)
          @php
            $namaBulan = match($label) {
              'Jan' => 'Januari', 'Feb' => 'Februari', 'Mar' => 'Maret', 'Apr' => 'April',
              'May' => 'Mei', 'Jun' => 'Juni', 'Jul' => 'Juli', 'Aug' => 'Agustus',
              'Sep' => 'September', 'Oct' => 'Oktober', 'Nov' => 'November', 'Dec' => 'Desember',
              default => $label,
            };
            $totalBulan = 0;
          @endphp

          <tr>
            <td style="border:1px solid #000; padding:4px;">{{ $namaBulan }}</td>

            @foreach($orderJenis as $jenis)
              @php
                $nilai = $summaryJenisBelanjaBulanRencana[$jenis][$m] ?? 0;
                $grandTotalJenis[$jenis] += $nilai;
                $totalBulan += $nilai;
              @endphp
              <td style="border:1px solid #000; padding:4px; text-align:right; white-space:nowrap;">
                Rp {{ number_format($nilai, 0, ',', '.') }}
              </td>
            @endforeach

            <td style="border:1px solid #000; padding:4px; text-align:right; font-weight:600; white-space:nowrap;">
              Rp {{ number_format($totalBulan, 0, ',', '.') }}
            </td>

            @php $grandTotalKeseluruhan += $totalBulan; @endphp
          </tr>
        @endforeach
      </tbody>

      <tfoot style="background:#f3f3f3; font-weight:bold;">
        <tr>
          <td style="border:1px solid #000; padding:5px; text-align:center;">Grand Total</td>
          @foreach($orderJenis as $jenis)
            <td style="border:1px solid #000; padding:5px; text-align:right; white-space:nowrap;">
              Rp {{ number_format($grandTotalJenis[$jenis], 0, ',', '.') }}
            </td>
          @endforeach
          <td style="border:1px solid #000; padding:5px; text-align:right; white-space:nowrap;">
            Rp {{ number_format($grandTotalKeseluruhan, 0, ',', '.') }}
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>


</div>

<!-- Charts script (Chart.js v3+) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Donut - Selisih overview (top-right)
  const donutCtx = document.getElementById('statistikChartDonut');
  if (donutCtx) {
    const donut = new Chart(donutCtx.getContext('2d'), {
      type: 'doughnut',
      data: {
        labels: ['Selisih Pagu - RPD','Selisih RPD - Realisasi','Selisih Pagu - Realisasi'],
        datasets: [{
          data: [
            Math.abs({{ (int)$selisihPaguRpd }}),
            Math.abs({{ (int)$selisihRpdRealisasi }}),
            Math.abs({{ (int)$selisihPaguRealisasi }})
          ],
          backgroundColor: ['#60a5fa','#f59e0b','#34d399']
        }]
      },
      options: {
        responsive: true,
        cutout: '60%',
        plugins: {
          legend: { position: 'bottom' },
          tooltip: {
            callbacks: {
              label: function(context) {
                const idx = context.dataIndex;
                const labels = ['Selisih Pagu - RPD','Selisih RPD - Realisasi','Selisih Pagu - Realisasi'];
                const signed = [{{ (int)$selisihPaguRpd }}, {{ (int)$selisihRpdRealisasi }}, {{ (int)$selisihPaguRealisasi }}][idx];
                return labels[idx] + ': Rp ' + signed.toLocaleString('id-ID');
              }
            }
          }
        }
      }
    });
  }

  // Output Bar Chart (under Kegiatan table)
  const outputLabels = {!! json_encode(array_map(fn($r) => (trim((string)($r['kegiatan'] ?? '')) !== '' ? ($r['kegiatan'] . ' - ' . ($r['output'] ?? (explode('|', $r)[0] ?? ''))) : ($r['output'] ?? (is_string($r) ? explode('|', $r)[0] ?? '' : ''))), array_values($summaryOutput))) !!};
  const outputPagu = {!! json_encode(array_values(array_map(fn($r) => (int)($r['total_pagu'] ?? 0), $summaryOutput))) !!};
  const outputRpd = {!! json_encode(array_values(array_map(fn($r) => (int)($r['total_rpd'] ?? 0), $summaryOutput))) !!};
  const outputRealisasi = {!! json_encode(array_values(array_map(fn($r) => (int)($r['total_realisasi'] ?? 0), $summaryOutput))) !!};
  const outputSelisih = {!! json_encode(array_values(array_map(fn($r) => (int)(($r['total_rpd'] ?? 0) - ($r['total_realisasi'] ?? 0)), $summaryOutput))) !!};

  const outEl = document.getElementById('outputChartBar');
  if (outEl && outputLabels.length) {
    new Chart(outEl.getContext('2d'), {
      type: 'bar',
      data: {
        labels: outputLabels,
        datasets: [
          { label: 'Total Pagu', data: outputPagu, backgroundColor: 'rgba(37,99,235,0.8)' },
          { label: 'Total RPD', data: outputRpd, backgroundColor: 'rgba(245,158,11,0.9)' },
          { label: 'Total Realisasi', data: outputRealisasi, backgroundColor: 'rgba(16,185,129,0.9)' },
          { label: 'Selisih (RPD - Realisasi)', data: outputSelisih, backgroundColor: 'rgba(220,53,69,0.8)' }
        ]
      },
      options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: { y: { type: 'logarithmic' } }
      }
    });
  }

  // Unit Kerja Chart (under Bagian table)
  const unitEl = document.getElementById('unitKerjaChart');
  if (unitEl) {
    const unitLabels = {!! json_encode(array_keys($summaryUnitKerja)) !!};
    const unitPagu = {!! json_encode(array_values(array_map(fn($r) => (int)($r['total_pagu'] ?? 0), $summaryUnitKerja))) !!};
    const unitRpd = {!! json_encode(array_values(array_map(fn($r) => (int)($r['total_rpd'] ?? 0), $summaryUnitKerja))) !!};
    const unitReal = {!! json_encode(array_values(array_map(fn($r) => (int)($r['total_realisasi'] ?? 0), $summaryUnitKerja))) !!};
    const unitDev = {!! json_encode(array_values(array_map(fn($r) => (int)($r['deviasi'] ?? 0), $summaryUnitKerja))) !!};

    new Chart(unitEl.getContext('2d'), {
      type: 'bar',
      data: {
        labels: unitLabels,
        datasets: [
          { label: 'Total Pagu', data: unitPagu, backgroundColor: 'rgba(37,99,235,0.8)' },
          { label: 'Total RPD', data: unitRpd, backgroundColor: 'rgba(245,158,11,0.9)' },
          { label: 'Total Realisasi', data: unitReal, backgroundColor: 'rgba(16,185,129,0.9)' },
          { label: 'Deviasi', data: unitDev, backgroundColor: 'rgba(220,53,69,0.8)' }
        ]
      },
      options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: { y: { type: 'logarithmic' } }
      }
    });
  }
});
</script>
<style>
  /* Terapkan ke kolom angka agar tidak terpotong atau turun ke bawah */
  .nowrap-number {
    white-space: nowrap;        /* jangan pecah baris */
    overflow: hidden;           /* sembunyikan jika terlalu panjang */
    text-overflow: ellipsis;    /* tambahkan "..." jika terlalu panjang */
  }
@media (max-width: 640px) {
  .filter-tahun {
    width: 100%;
    }
  }
</style>
@endsection
