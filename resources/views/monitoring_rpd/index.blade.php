@extends('layouts.app')

@section('content')
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

<h1 style="text-align:center; font-size:2.2rem;font-weight:700;letter-spacing:-1px;">Monitoring RPD Per Bagian Kelompok Substansi</h1>
<div style="width:100%; max-width:100%; padding:0; margin:0;">
  <div style="width:100%; background:#fff; border-radius:6px;">
    

    {{-- ================= RINGKASAN TOTAL ================= --}}
    <div class="card" style="background:#fff; box-shadow:0 2px 8px #007bff11; padding:15px; border-radius:10px;">
      <h2 style="text-align:center; font-size:1.1rem; font-weight:600; margin-bottom:10px;">Ringkasan Total RPD per Bagian Kelompok Substansi</h2>
      <div style="overflow-x:auto;">
        <table style="width:100%; background:#f8faff; border-radius:6px; border-collapse:collapse; font-size:0.97rem;">
          <thead>
            <tr>
              <th style="text-align:center; border:1px solid #000; padding:3px;">Bagian Kelompok Substansi</th>
              <th style="text-align:center; border:1px solid #000; padding:3px;">Pagu</th>
              <th style="text-align:center; border:1px solid #000; padding:3px;">RPD</th>
              <th style="text-align:center; border:1px solid #000; padding:3px;">Realisasi</th>
              <th style="text-align:center; border:1px solid #000; padding:3px;">Selisih (Pagu - RPD)</th>
              <th style="text-align:center; border:1px solid #000; padding:3px;">Deviasi</th>
              <th style="text-align:center; border:1px solid #000; padding:3px;">%Dev</th>
            </tr>
          </thead>
          <tbody>
            @foreach($rekap as $uk => $bulanData)
              @php
                $totalRpd = $totalRealisasi = $totalDeviasi = 0;
                foreach($bulanLabels as $m => $label) {
                  $totalRpd += $bulanData[$m]['rpd'] ?? 0;
                  $totalRealisasi += $bulanData[$m]['realisasi'] ?? 0;
                  $totalDeviasi += $bulanData[$m]['deviasi'] ?? 0;
                }
                $totalPagu = $totalPaguPerUnitKerja[$uk] ?? 0;
                $selisih = $totalPagu - $totalRpd;
                $percentDev = ($totalRpd != 0) ? ($totalDeviasi / $totalRpd * 100) : 0;
              @endphp
              <tr>
                <td style="font-weight:bold; text-align:center; border:1px solid #000;">{{ $uk }}</td>
                <td style="text-align:right; border:1px solid #000; white-space:nowrap;">Rp {{ number_format($totalPagu,0,',','.') }}</td>
                <td style="text-align:right; border:1px solid #000; white-space:nowrap;">Rp {{ number_format($totalRpd,0,',','.') }}</td>
                <td style="text-align:right; border:1px solid #000; white-space:nowrap;">Rp {{ number_format($totalRealisasi,0,',','.') }}</td>
                <td style="text-align:right; border:1px solid #000; color: red; white-space:nowrap;">Rp {{ number_format($selisih,0,',','.') }}</td>
                <td style="text-align:right; border:1px solid #000; color:red; white-space:nowrap;">Rp {{ number_format($totalDeviasi,0,',','.') }}</td>
                <td style="text-align:center; border:1px solid #000;">{{ number_format($percentDev,2) }}%</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    {{-- ================= TABEL PER BULAN DAN TRIWULAN ================= --}}
    <div class="card" style="background:#fff; box-shadow:0 2px 8px #007bff11; padding:15px; border-radius:10px;">
      <h2 style="text-align:center; font-size:1.1rem; font-weight:600; margin-bottom:10px;">Tabel per Bulan Bagian Kelompok Substansi</h2>
      <div class="table-wrap" style="overflow-x:auto;">

        @php
          $bulanLabels = [
            'jan' => 'Januari', 'feb' => 'Februari', 'mar' => 'Maret',
            'apr' => 'April', 'mei' => 'Mei', 'jun' => 'Juni',
            'jul' => 'Juli', 'agt' => 'Agustus', 'sep' => 'September',
            'okt' => 'Oktober', 'nov' => 'November', 'des' => 'Desember'
          ];
          $bulanKeys = array_keys($bulanLabels);
          $triwulanList = [
            'I' => ['jan','feb','mar'],
            'II' => ['apr','mei','jun'],
            'III' => ['jul','agt','sep'],
            'IV' => ['okt','nov','des']
          ];
          $kumulatifRealisasi = [];
        @endphp

        <table style="width:100%; border-collapse:collapse; background:#f8faff; font-size:0.95rem;">
          <thead>
          <tr>
            <th rowspan="2"
                style="border:1px solid #000; text-align:center;
                      position:sticky; left:0; z-index:10;
                      background:#fff;">Bulan</th>
              @foreach($rekap as $uk => $bulanData)
                <th colspan="4" style="border:1px solid #000; text-align:center;">{{ $uk }}</th>
              @endforeach
            </tr>
            <tr>
              @foreach($rekap as $uk => $bulanData)
                <th style="border:1px solid #000; text-align:center;">RPD</th>
                <th style="border:1px solid #000; text-align:center;">Realisasi</th>
                <th style="border:1px solid #000; text-align:center;">Deviasi</th>
                <th style="border:1px solid #000; text-align:center;">%Dev</th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            @foreach($bulanLabels as $m => $label)
              <tr>
                <td style="text-align:center; border:1px solid #000; padding:4px;
                    position:sticky; left:0; background:#fff; z-index:5;">
                  {{ $label }}
                </td>
                @foreach($rekap as $uk => $data)
                  @php
                    $rpd = $data[$m]['rpd'] ?? 0;
                    $realisasi = $data[$m]['realisasi'] ?? 0;
                    $deviasi = $data[$m]['deviasi'] ?? 0;
                    $percent = ($rpd != 0) ? ($deviasi / $rpd * 100) : 0;
                  @endphp
                  <td style="text-align:right; border:1px solid #000; white-space: nowrap;">Rp {{ number_format($rpd,0,',','.') }}</td>
                  <td style="text-align:right; border:1px solid #000; white-space: nowrap;">Rp {{ number_format($realisasi,0,',','.') }}</td>
                  <td style="text-align:right; border:1px solid #000; color:red; white-space: nowrap;">Rp {{ number_format($deviasi,0,',','.') }}</td>
                  <td style="text-align:center; border:1px solid #000;">{{ number_format($percent,2) }}%</td>
                @endforeach
              </tr>
              
              {{-- ===== BARIS TRIWULAN ===== --}}
              @foreach($triwulanList as $twName => $months)
                @if(end($months) === $m)
                  <tr style="background:#f4faff; font-weight:600;">
                    <td style="border:1px solid #000; white-space: nowrap;
                        position:sticky; left:0; background:#f4faff; z-index:6;">
                      Triwulan {{ $twName }}
                    </td>
                    @foreach($rekap as $uk => $data)
                      @php
                        // Hitung total RPD per triwulan
                        $rpdT = 0;
                        foreach($months as $bm) {
                          $rpdT += $data[$bm]['rpd'] ?? 0;
                        }

                        // Simpan kumulatif RPD untuk perhitungan persen kumulatif
                        $kumulatifRpd[$uk] = ($kumulatifRpd[$uk] ?? 0) + $rpdT;

                        // Ambil total pagu berdasarkan unit kerja
                        $totalPagu = $totalPaguPerUnitKerja[$uk] ?? 0;

                        // Hitung persentase kumulatif berdasarkan total RPD kumulatif
                        $persenKumulatif = ($totalPagu != 0)
                            ? (($kumulatifRpd[$uk] / $totalPagu) * 100)
                            : 0;
                      @endphp

                      {{-- Tampilkan total RPD dan % kumulatif --}}
                      <td style="text-align:right; border:1px solid #000; white-space: nowrap;">
                        Rp {{ number_format($rpdT,0,',','.') }}
                      </td>
                      <td style="text-align:center; border:1px solid #000;">
                        {{ number_format($persenKumulatif,2) }}%
                      </td>
                      <td style="border:1px solid #000;"></td>
                      <td style="border:1px solid #000;"></td>
                    @endforeach
                  </tr>
                @endif
              @endforeach
            @endforeach

            {{-- BARIS TOTAL RPD PER UNIT KERJA (setelah Triwulan IV) --}}
            @php
              $monthsList = array_keys($bulanLabels);
              $totalsPerUnit = [];
              foreach($rekap as $uk => $bulanData) {
                $totalsPerUnit[$uk] = ['rpd' => 0, 'realisasi' => 0, 'deviasi' => 0];
                foreach($monthsList as $bm) {
                  $totalsPerUnit[$uk]['rpd'] += $bulanData[$bm]['rpd'] ?? 0;
                  $totalsPerUnit[$uk]['realisasi'] += $bulanData[$bm]['realisasi'] ?? 0;
                  $totalsPerUnit[$uk]['deviasi'] += $bulanData[$bm]['deviasi'] ?? 0;
                }
              }
            @endphp

            <tr style="font-weight:700; background:#e8f6ff;">
              <td style="position:sticky; left:0; background:#e8f6ff; z-index:7; text-align:center; border:1px solid #000;">Total RPD</td>
              @foreach($rekap as $uk => $data)
                @php $t = $totalsPerUnit[$uk]; @endphp
                <td style="text-align:right; border:1px solid #000; white-space:nowrap;">Rp {{ number_format($t['rpd'],0,',','.') }}</td>
                <td style="border:1px solid #000;"></td>
                <td style="border:1px solid #000;"></td>
                <td style="border:1px solid #000;"></td>
              @endforeach
            </tr>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<style>
@media (max-width: 640px) {
  .filter-tahun {
    width: 100%;
    }
  }
</style>
@endsection
