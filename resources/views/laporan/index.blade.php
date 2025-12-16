@extends('layouts.app')
@section('content')
<div style="display:flex; justify-content:center;">
  <div style="width:95%; max-width:1200px;">
    <form method="get" style="margin-bottom:18px;display:flex;align-items:center;gap:8px; justify-content:center;">
      <label for="tahun" style="font-size:1rem;">Tahun:</label>
      <input type="number" name="tahun" id="tahun" value="{{ $tahun ?? date('Y') }}" min="2020" max="2100" style="width:90px;padding:4px 8px;border-radius:4px;border:1px solid #ccc;">
@php
  $currentMonth = date('n');
  $selectedTriwulan = request('triwulan', (int) ceil($currentMonth / 3));
  $romawi = ['I', 'II', 'III', 'IV'];
@endphp
      <button type="submit" style="cursor: pointer; padding:4px 14px; border-radius:4px; background:#007bff; color:#fff; border:none; transition:0.2s;"
        onmouseover="this.style.background='#0056b3'"
        onmouseout="this.style.background='#007bff'">Terapkan
      </button>
      <a href="{{ route('laporan.previewPdf', ['tahun' => $tahun, 'triwulan' => $selectedTriwulan]) }}" target="_blank">
        <button type="button" style="cursor: pointer; padding:4px 14px; border-radius:4px; background:#28a745; color:#fff; border:none; font-size:1rem; font-weight:600; margin-left:8px; transition:0.2s;"
          onmouseover="this.style.background='#1e7e34'"
          onmouseout="this.style.background='#28a745'"
          >Unduh PDF
        </button>
      </a>
    </form>
    @php
      $romawi = [1=>'I',2=>'II',3=>'III',4=>'IV'];
      $triwulanRomawi = $romawi[$selectedTriwulan];
      $bulanLabels = [
        'jan' => 'Januari',
        'feb' => 'Februari',
        'mar' => 'Maret',
        'apr' => 'April',
        'mei' => 'Mei',
        'jun' => 'Juni',
        'jul' => 'Juli',
        'agt' => 'Agustus',
        'sep' => 'September',
        'okt' => 'Oktober',
        'nov' => 'November',
        'des' => 'Desember',
      ];
    @endphp
    <h1 style="font-size:2.2rem;font-weight:700;letter-spacing:-1px;margin:0 0 24px 0; text-align:center;">LAPORAN RPD<br>TAHUN ANGGARAN {{ $tahun }}</h1>
    <div style="margin:32px 0 0 0;">
      <div class="table-responsive" style="display:flex; flex-wrap:wrap; gap:32px;">
        @php
          $orderJenis = ['51','52','53'];
        @endphp
        @foreach($orderJenis as $jenis)
          @if(isset($rekap[$jenis]))
            @php
              $bulanData = $rekap[$jenis];
              $totalJenis = array_sum($bulanData);
            @endphp
            <div style="min-width:220px; background:#fff; border-radius:8px; box-shadow:0 2px 8px #007bff11; padding:12px 18px; margin-bottom:12px;">
              <div style="font-weight:600; color:#222; font-size:1.05rem; margin-bottom:8px;">Jenis Belanja: {{ $jenis }}</div>
              <table style="width:100%; font-size:0.97rem; table-layout:fixed;">
                <thead>
                  <tr style="background:#e3f0ff;">
                    <th style="text-align:center; border:1px solid #000;">Bulan</th>
                    <th style="text-align:center; border:1px solid #000;">Total (Rp)</th>
                    @if(in_array($jenis, ['51','52','53']))
                      <th style="text-align:center; border:1px solid #000;">IKPA</th>
                      <th style="text-align:center; border:1px solid #000;">Target</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @foreach($bulanLabels as $m => $label)
                    <tr>
                      <td style="text-align:center; border:1px solid #000;">{{ $label }}</td>
                      <td style="text-align:right; font-weight:600; color:#222; border:1px solid #000;">Rp {{ number_format($bulanData[$m],0,',','.') }}</td>
                      @if(in_array($jenis, ['51','52','53']))
                        @php
                          $ikpaVal = 0;
                          $ikpaKet = '';
                          $targetVal = '';
                          $showTargetInput = false;
                          $tw = 0;
                          // Ganti pengecekan label ke nama bulan panjang
                          if($label == 'Maret') {
                            $tw = 1;
                            $ikpaVal = $totalJenis > 0 ? (($bulanData['jan'] + $bulanData['feb'] + $bulanData['mar']) / $totalJenis) * 100 : 0;
                            $targetVal = $targets[$jenis][$tw] ?? 15;
                            $ikpaKet = $ikpaVal > $targetVal ? 'Melebihi target' : ($ikpaVal < $targetVal ? 'Belum mencapai target' : '');
                            $showTargetInput = true;
                          } elseif($label == 'Juni') {
                            $tw = 2;
                            $ikpaVal = $totalJenis > 0 ? (($bulanData['jan'] + $bulanData['feb'] + $bulanData['mar'] + $bulanData['apr'] + $bulanData['mei'] + $bulanData['jun']) / $totalJenis) * 100 : 0;
                            $targetVal = $targets[$jenis][$tw] ?? 50;
                            $ikpaKet = $ikpaVal > $targetVal ? 'Melebihi target' : ($ikpaVal < $targetVal ? 'Belum mencapai target' : '');
                            $showTargetInput = true;
                          } elseif($label == 'September') {
                            $tw = 3;
                            $ikpaVal = $totalJenis > 0 ? (($bulanData['jan'] + $bulanData['feb'] + $bulanData['mar'] + $bulanData['apr'] + $bulanData['mei'] + $bulanData['jun'] + $bulanData['jul'] + $bulanData['agt'] + $bulanData['sep']) / $totalJenis) * 100 : 0;
                            $targetVal = $targets[$jenis][$tw] ?? 70;
                            $ikpaKet = $ikpaVal > $targetVal ? 'Melebihi target' : ($ikpaVal < $targetVal ? 'Belum mencapai target' : '');
                            $showTargetInput = true;
                          } elseif($label == 'Desember') {
                            $tw = 4;
                            $ikpaVal = $totalJenis > 0 ? (($bulanData['jan'] + $bulanData['feb'] + $bulanData['mar'] + $bulanData['apr'] + $bulanData['mei'] + $bulanData['jun'] + $bulanData['jul'] + $bulanData['agt'] + $bulanData['sep'] + $bulanData['okt'] + $bulanData['nov'] + $bulanData['des']) / $totalJenis) * 100 : 0;
                            $targetVal = $targets[$jenis][$tw] ?? 90;
                            if($ikpaVal >= 100) {
                              $ikpaKet = 'Tercapai';
                            } elseif($ikpaVal > $targetVal) {
                              $ikpaKet = 'Melebihi target ' . $targetVal . '%';
                            } else {
                              $ikpaKet = 'Belum mencapai target ' . $targetVal . '%';
                            }
                            $showTargetInput = true;
                          }
                        @endphp
                        <td style="text-align:center; color:#222; font-weight:600; border:1px solid #000;">
                          @if($ikpaVal)
                            {{ number_format($ikpaVal,2) }}% <span style="font-size:0.95em; color:#444;">{{ $ikpaKet }}</span>
                          @endif
                        </td>
                        <td style="text-align:center; color:#d35400; font-weight:600; border:1px solid #000;">
                          @if($showTargetInput)
                          <form method="POST" action="{{ route('laporan.updateTarget') }}" style="display:inline;">
                            @csrf
                            <input type="hidden" name="tahun" value="{{ $tahun }}">
                            <input type="hidden" name="jenis_belanja" value="{{ $jenis }}">
                            <input type="hidden" name="triwulan" value="{{ $tw }}">
                            <input required type="number" name="target" value="{{ $targetVal }}" min="0" max="100" style="width:50px; text-align:right; font-weight:600; color:#d35400; border:1px solid #ccc; border-radius:4px;">
                            <span style="margin-left:2px;">%</span>
                            <button type="submit" style="cursor:pointer; padding:2px 8px; font-size:0.95em;">Set</button>
                          </form>
                          @endif
                        </td>
                      @endif
                    </tr>
                  @endforeach
                  <tr style="background:#f9f9f9; font-weight:bold;">
                    <td style="text-align:center; color:#222; border:1px solid #000;">Total</td>
                    <td style="text-align:right; color:#222; border:1px solid #000;">Rp {{ number_format($totalJenis,0,',','.') }}</td>
                    @if(in_array($jenis, ['51','52','53']))
                      <td style="border:1px solid #000;"></td>
                      <td style="border:1px solid #000;"></td>
                    @endif
                  </tr>
                </tbody>
              </table>
            </div>
          @endif
        @endforeach
      </div>
    </div>
  </div>
</div>

<style>
  /* ===== RESPONSIVE MOBILE START ===== */
@media(max-width: 768px) {

  /* Container utama biar tidak terlalu mepet */
  .konten > div > div {
      width: 100% !important;
      padding: 0 8px !important;
      box-sizing: border-box;
  }

  /* Heading agar lebih pas di layar kecil */
  h1 {
      font-size: 1.4rem !important;
      line-height: 1.4 !important;
      text-align: center;
  }

  /* Form filter tahun & triwulan */
  form[method="get"] {
      flex-wrap: wrap;
      justify-content: center;
  }

  form[method="get"] label {
      font-size: 0.9rem;
  }

  form[method="get"] input,
  form[method="get"] select,
  form[method="get"] button {
      font-size: 0.9rem;
      padding: 6px 10px !important;
  }

  /* Card Jenis Belanja */
  .table-responsive > div {
      flex: 1 1 100% !important; /* dari 3 kolom → 1 kolom */
      min-width: 100% !important;
  }

  /* Table agar tidak meledak */
  table {
      font-size: 0.85rem !important;
      width: 100% !important;
      display: block;
      overflow-x: auto;
      white-space: nowrap;
  }

  th, td {
      padding: 4px !important;
  }
}
/* ===== RESPONSIVE MOBILE END ===== */
</style>
@endsection
