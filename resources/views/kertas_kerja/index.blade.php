@extends('layouts.app')

@section('content')

    <div style="display:flex; justify-content:center;">
        <div style="width:95%; max-width:1200px;">
            <form method="get" class="flex items-center gap-2">
                <label for="tahun" class="text-base">Tahun:</label>
                <input type="number" name="tahun" id="tahun" value="{{ $tahunAktif ?? date('Y') }}" min="2020"
                    max="2100" class="filter-tahun w-24 px-2 py-1 rounded border border-gray-300">
                <button type="submit" style="cursor: pointer; padding:4px 14px; border-radius:4px; background:#007bff; color:#fff; border:none; transition: 0.2s;"
                    onmouseover="this.style.background='#0056b3'"
                    onmouseout="this.style.background='#007bff'"
                    >Tampilkan
                </button>
            </form>
            <h1 style="margin-bottom:10px;; text-align:center; font-size:2.2rem;font-weight:700;letter-spacing:-1px;">
                Monitoring RPD Tahun
                {{ $tahunAktif }}</h1>
            <div class="card" style="background:#fff; box-shadow:0 2px 8px #007bff11; padding:15px; border-radius:10px;">
                @php
                    // Hitung total RPD, Realisasi, Selisih per bulan hanya dari nilai yang tampil (rowspan), tidak double count
                    $totalRpdPerBulan = [];
                    $totalRealisasiPerBulan = [];
                    $totalSelisihPerBulan = [];
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
                    $rpdRowspanValues = [];
                    $realisasiRowspanValues = [];
                    $selisihRowspanValues = [];
                    $totalPaguAkun = [];
                    foreach (
                        ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'okt', 'nov', 'des']
                        as $m
                    ) {
                        $totalRpdPerBulan[$m] = 0;
                        $totalRealisasiPerBulan[$m] = 0;
                        $totalSelisihPerBulan[$m] = 0;
                        $rpdRowspanValues[$m] = [];
                        $realisasiRowspanValues[$m] = [];
                        $selisihRowspanValues[$m] = [];
                    }
                    foreach ($data as $row) {
                        $parentKey =
                            $row['output'] . '|' . $row['akun_kode'] . '|' . ($row['total_pagu_output_akun'] ?? 0);
                        // Hitung total pagu per akun
                        $akun = $row['akun_kode'];
                        if (!isset($totalPaguAkun[$akun])) {
                            $totalPaguAkun[$akun] = 0;
                        }
                        $totalPaguAkun[$akun] += $row['pagu'] ?? ($row['total_pagu_akun'] ?? 0);
                        foreach (
                            ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'okt', 'nov', 'des']
                            as $m
                        ) {
                            $rpdValue = $row['rpd'][$m] ?? 0;
                            $realisasiValue = $row['realisasi'][$m] ?? 0;
                            $selisihValue = $rpdValue - $realisasiValue;
                            $rpdKey = $parentKey . '|' . $m . '|' . $rpdValue;
                            $realisasiKey = $parentKey . '|' . $m . '|' . $realisasiValue;
                            $selisihKey = $parentKey . '|' . $m . '|' . $selisihValue;
                            if (!isset($rpdRowspanValues[$m][$rpdKey])) {
                                $totalRpdPerBulan[$m] += $rpdValue;
                                $rpdRowspanValues[$m][$rpdKey] = true;
                            }
                            if (!isset($realisasiRowspanValues[$m][$realisasiKey])) {
                                $totalRealisasiPerBulan[$m] += $realisasiValue;
                                $realisasiRowspanValues[$m][$realisasiKey] = true;
                            }
                            if (!isset($selisihRowspanValues[$m][$selisihKey])) {
                                $totalSelisihPerBulan[$m] += $selisihValue;
                                $selisihRowspanValues[$m][$selisihKey] = true;
                            }
                        }
                    }
                    $grandTotalPagu = array_sum($totalPaguAkun);
                    $grandTotalRpd = array_sum($totalRpdPerBulan);
                    $grandTotalRealisasi = array_sum($totalRealisasiPerBulan);
                    $grandTotalSelisih = array_sum($totalSelisihPerBulan);
                @endphp

                <!-- Ringkasan Total Responsive Cards (Inline CSS Only) -->
                @php
                    $selisihPaguRpd = ($grandTotalPagu ?? 0) - ($grandTotalRpd ?? 0);
                    $selisihPaguRealisasi = ($grandTotalPagu ?? 0) - ($grandTotalRealisasi ?? 0);
                @endphp

                <div
                    style="
                        width:100%;
                        max-width:1000px;
                        margin:0 auto 24px auto;
                        display:flex;
                        flex-wrap:wrap;
                        gap:16px;
                        justify-content:center;
                        align-items:stretch;
                    ">
                    <!-- ITEM -->
                    <div
                        style="
                            flex:1 1 calc(33.33% - 16px);
                            min-width:180px;
                            background:#f8f9fa;
                            border-radius:10px;
                            box-shadow:0 2px 8px #bbb3;
                            padding:16px 0;
                            display:flex;
                            flex-direction:column;
                            align-items:center;
                            border:1px solid #000;
                        ">
                        <div style="font-size:1.08rem; font-weight:700; margin-bottom:8px;">Total Pagu</div>
                        <div style="font-size:1.18rem; font-weight:bold;">
                            Rp {{ number_format($grandTotalPagu) }}
                        </div>
                    </div>

                    <div
                        style="
                            flex:1 1 calc(33.33% - 16px);
                            min-width:180px;
                            background:#f8f9fa;
                            border-radius:10px;
                            box-shadow:0 2px 8px #bbb3;
                            padding:16px 0;
                            display:flex;
                            flex-direction:column;
                            align-items:center;
                            border:1px solid #000;
                        ">
                        <div style="font-size:1.08rem; font-weight:700; margin-bottom:8px;">Total RPD</div>
                        <div style="font-size:1.18rem; font-weight:bold;">
                            Rp {{ number_format($grandTotalRpd) }}
                        </div>
                    </div>

                    <div
                        style="
                            flex:1 1 calc(33.33% - 16px);
                            min-width:180px;
                            background:#f8f9fa;
                            border-radius:10px;
                            box-shadow:0 2px 8px #bbb3;
                            padding:16px 0;
                            display:flex;
                            flex-direction:column;
                            align-items:center;
                            border:1px solid #000;
                        ">
                        <div style="font-size:1.08rem; font-weight:700; margin-bottom:8px;">Total Realisasi</div>
                        <div style="font-size:1.18rem; font-weight:bold;">
                            Rp {{ number_format($grandTotalRealisasi) }}
                        </div>
                    </div>

                    <!-- Selisih 1 -->
                    <div
                        style="
                            flex:1 1 calc(33.33% - 16px);
                            min-width:180px;
                            border-radius:10px;
                            box-shadow:0 2px 8px #bbb3;
                            padding:16px 0;
                            display:flex;
                            flex-direction:column;
                            align-items:center;
                            border:1px solid #000;
                        ">
                        <div style="font-size:1.02rem; font-weight:700; color:red; margin-bottom:6px;">Selisih (Pagu - RPD)
                        </div>
                        <div style="font-size:1.16rem; font-weight:bold; color:red;">
                            Rp {{ number_format($selisihPaguRpd) }}
                        </div>
                    </div>

                    <!-- Selisih 2 -->
                    <div
                        style="
                            flex:1 1 calc(33.33% - 16px);
                            min-width:180px;
                            background:#f8f9fa;
                            border-radius:10px;
                            box-shadow:0 2px 8px #bbb3;
                            padding:16px 0;
                            display:flex;
                            flex-direction:column;
                            align-items:center;
                            border:1px solid #000;
                        ">
                        <div style="font-size:1.08rem; font-weight:700; color:red; margin-bottom:8px;">Selisih (RPD -
                            Realisasi)</div>
                        <div style="font-size:1.18rem; font-weight:bold; color:red;">
                            Rp {{ number_format($grandTotalSelisih) }}
                        </div>
                    </div>

                    <!-- Selisih 3 -->
                    <div
                        style="
                            flex:1 1 calc(33.33% - 16px);
                            min-width:180px;
                            border-radius:10px;
                            box-shadow:0 2px 8px #bbb3;
                            padding:16px 0;
                            display:flex;
                            flex-direction:column;
                            align-items:center;
                            border:1px solid #000;
                        ">
                        <div style="font-size:1.02rem; font-weight:700; color:red; margin-bottom:6px;">Selisih (Pagu -
                            Realisasi)</div>
                        <div style="font-size:1.16rem; font-weight:bold; color:red;">
                            Rp {{ number_format($selisihPaguRealisasi) }}
                        </div>
                    </div>
                </div>
                
                <h2 style="text-align:center; font-size:1.1rem; font-weight:600; margin-bottom:10px;">Tabel Monitoring RPD Per Kegiatan, Output & Sub Komponen
                </h2>
                <div class="table-wrap" style="overflow-x:auto; display:block; width:100%;">
                    <table
                        style="width:100%; background:#fff; border-radius:6px; border-collapse:collapse; color:#000; font-size:0.95rem;">
                        <thead>
                            <tr style="background:#007bff; color:#000;">
                                <th style="text-align:center; border:1px solid #000;" rowspan="2">Kegiatan</th>
                                <th style="text-align:center; border:1px solid #000;" rowspan="2">Output/KRO/RO</th>
                                <th style="text-align:center; border:1px solid #000;" rowspan="2">Komponen</th>
                                <th style="text-align:center; border:1px solid #000;" rowspan="2">Jenis Belanja</th>
                                <th style="text-align:center; border:1px solid #000;" rowspan="2">Bagian Kelompok
                                    Substansi</th>
                                <th style="text-align:center; border:1px solid #000;" rowspan="2">Sub Komponen</th>
                                <th style="text-align:center; border:1px solid #000;" rowspan="2">Pagu</th>
                                @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $m)
                                    <th colspan="3" style="text-align:center; border:1px solid #000;">{{ $m }}
                                    </th>
                                @endforeach
                                <th rowspan="2" style="text-align:center; border:1px solid #000;">Total RPD</th>
                            </tr>
                            <tr style="background:#e3f0ff; color:#000; border:1px solid #000;">
                                @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'] as $m)
                                    <th style="text-align:center; border:1px solid #000;">RPD</th>
                                    <th style="text-align:center; border:1px solid #000;">Realisasi</th>
                                    <th
                                        style="text-align:center;@if (!$loop->last) border:1px solid #000;; @endif">
                                        Selisih</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Hitung rowspan untuk output, kegiatan, komponen, jenis belanja, akun, unit kerja
                                $outputCounts = $kegiatanCounts = $komponenCounts = $jenisBelanjaCounts = $akunCounts = $unitKerjaCounts = [];
                                $totalPaguAkun = [];
                                foreach ($data as $row) {
                                    $output = $row['output'];
                                    $kegiatan = $row['kegiatan'];
                                    $komponen = $row['komponen'];
                                    $jenisBelanja = $row['jenis_belanja'] ?? '-';
                                    $akun = $row['akun_kode'];
                                    $unitKerja = $row['unit_kerja'] ?? '-';
                                    if (!isset($outputCounts[$output])) {
                                        $outputCounts[$output] = 0;
                                    }
                                    if (!isset($kegiatanCounts[$kegiatan])) {
                                        $kegiatanCounts[$kegiatan] = 0;
                                    }
                                    if (!isset($komponenCounts[$komponen])) {
                                        $komponenCounts[$komponen] = 0;
                                    }
                                    if (!isset($jenisBelanjaCounts[$jenisBelanja])) {
                                        $jenisBelanjaCounts[$jenisBelanja] = 0;
                                    }
                                    if (!isset($akunCounts[$akun])) {
                                        $akunCounts[$akun] = 0;
                                    }
                                    if (!isset($unitKerjaCounts[$unitKerja])) {
                                        $unitKerjaCounts[$unitKerja] = 0;
                                    }
                                    $outputCounts[$output]++;
                                    $kegiatanCounts[$kegiatan]++;
                                    $komponenCounts[$komponen]++;
                                    $jenisBelanjaCounts[$jenisBelanja]++;
                                    $akunCounts[$akun]++;
                                    $unitKerjaCounts[$unitKerja]++;
                                    if (!isset($totalPaguAkun[$akun])) {
                                        $totalPaguAkun[$akun] = 0;
                                    }
                                    $totalPaguAkun[$akun] += $row['pagu'] ?? ($row['total_pagu_akun'] ?? 0);
                                }
                                $outputRendered = $kegiatanRendered = $komponenRendered = $jenisBelanjaRendered = $akunRendered = $unitKerjaRendered = [];
                            @endphp
                            @php
                                // Sort data by kegiatan then output
                                $sortedData = collect($data)
                                    ->sortBy([['kegiatan', 'asc'], ['output', 'asc']])
                                    ->values();
                                // Hitung kombinasi unik kegiatan+output dan mapping baris
                                $comboCounts = [];
                                $akunByCombo = [];
                                foreach ($sortedData as $row) {
                                    $key = $row['kegiatan'] . '|' . $row['output'];
                                    if (!isset($comboCounts[$key])) {
                                        $comboCounts[$key] = 0;
                                    }
                                    $comboCounts[$key]++;
                                    if (!isset($akunByCombo[$key])) {
                                        $akunByCombo[$key] = [];
                                    }
                                    if (!in_array($row['akun_kode'], $akunByCombo[$key])) {
                                        $akunByCombo[$key][] = $row['akun_kode'];
                                    }
                                }
                                $renderedCombo = [];
                            @endphp
                            @php
                                // Hitung total per unit kerja (pagu, total RPD 12 bulan, total realisasi, selisih = pagu - rpd)
                                // plus per-bulan breakdown untuk RPD/Realisasi/Selisih
                                $unitTotals = [];
                                $unitTotalsByMonth = []; // $unitTotalsByMonth[unit][m] = ['rpd'=>..,'realisasi'=>..,'selisih'=>..]
                                $months = [
                                    'jan',
                                    'feb',
                                    'mar',
                                    'apr',
                                    'mei',
                                    'jun',
                                    'jul',
                                    'agt',
                                    'sep',
                                    'okt',
                                    'nov',
                                    'des',
                                ];
                                foreach ($sortedData as $row) {
                                    $unit = $row['unit_kerja'] ?? 'Umum';
                                    $unitKey = trim($unit) === '' ? 'Umum' : $unit;
                                    if (!isset($unitTotals[$unitKey])) {
                                        $unitTotals[$unitKey] = [
                                            'pagu' => 0,
                                            'rpd' => 0,
                                            'realisasi' => 0,
                                            'selisih' => 0,
                                        ];
                                    }
                                    if (!isset($unitTotalsByMonth[$unitKey])) {
                                        $unitTotalsByMonth[$unitKey] = [];
                                        foreach ($months as $mm) {
                                            $unitTotalsByMonth[$unitKey][$mm] = [
                                                'rpd' => 0,
                                                'realisasi' => 0,
                                                'selisih' => 0,
                                            ];
                                        }
                                    }
                                    $paguVal = $row['total_pagu_output_akun'] ?? ($row['pagu'] ?? 0);
                                    $rpdVal = array_sum($row['rpd'] ?? []);
                                    $realisasiVal = array_sum($row['realisasi'] ?? []);
                                    $selisihVal = $paguVal - $rpdVal; // selisih summary = Pagu - RPD
                                    $unitTotals[$unitKey]['pagu'] += $paguVal;
                                    $unitTotals[$unitKey]['rpd'] += $rpdVal;
                                    $unitTotals[$unitKey]['realisasi'] += $realisasiVal;
                                    $unitTotals[$unitKey]['selisih'] += $selisihVal;

                                    // per-month accumulation (monthly selisih = rpd_month - realisasi_month)
                                    foreach ($months as $m) {
                                        $rpdMonth = $row['rpd'][$m] ?? 0;
                                        $realisasiMonth = $row['realisasi'][$m] ?? 0;
                                        $selisihMonth = $rpdMonth - $realisasiMonth;
                                        $unitTotalsByMonth[$unitKey][$m]['rpd'] += $rpdMonth;
                                        $unitTotalsByMonth[$unitKey][$m]['realisasi'] += $realisasiMonth;
                                        $unitTotalsByMonth[$unitKey][$m]['selisih'] += $selisihMonth;
                                    }
                                }
                            @endphp
                            @if ($sortedData->count() === 0)
                                <tr>
                                    <td colspan="49" style="border:1px solid #000; text-align:center; color:#888; font-style:italic;">Tidak ada data</td>
                                </tr>
                            @else
                                @foreach ($sortedData as $row)
                                    <tr>
                                        @php $key = $row['kegiatan'].'|'.$row['output']; @endphp
                                        @if (empty($renderedCombo[$key]))
                                            <td rowspan="{{ $comboCounts[$key] }}"
                                                style="vertical-align:top; text-align:center; border:1px solid #000;">
                                                {{ $row['kegiatan'] }}</td>
                                            <td rowspan="{{ $comboCounts[$key] }}"`
                                                style="vertical-align:top; text-align:center; border:1px solid #000;">
                                                {{ $row['output'] }}</td>
                                            @php $renderedCombo[$key] = true; @endphp
                                        @endif
                                        <td style="vertical-align:top; text-align:center; border:1px solid #000;">
                                            {{ $row['komponen'] }}</td>
                                        <td style="vertical-align:top; text-align:center; border:1px solid #000;">
                                            {{ $row['jenis_belanja'] ?? '-' }}</td>
                                        <td style="vertical-align:top; text-align:center; border:1px solid #000;">
                                            {{ $row['unit_kerja'] ?? '-' }}</td>
                                        <td style="vertical-align:top; text-align:center; border:1px solid #000;">
                                            {{ $row['akun_kode'] }}</td>
                                        <td class="nominal-cell"
                                            style="vertical-align:top; text-align:right; border:1px solid #000;">
                                            Rp {{ number_format($row['total_pagu_output_akun'] ?? 0) }}</td>
                                        @foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'okt', 'nov', 'des'] as $m)
                                            <td class="nominal-cell"
                                                style="vertical-align:top; text-align:right; border:1px solid #000;">
                                                Rp {{ number_format($row['rpd'][$m] ?? 0) }}
                                            </td>
                                            <td class="nominal-cell"
                                                style="vertical-align:top; text-align:right; border:1px solid #000;">
                                                Rp {{ number_format($row['realisasi'][$m] ?? 0) }}
                                            </td>
                                            <td class="nominal-cell"
                                                style="vertical-align:top; color:red; text-align:right; border:1px solid #000;">
                                                Rp
                                                {{ number_format(($row['rpd'][$m] ?? 0) - ($row['realisasi'][$m] ?? 0)) }}
                                            </td>
                                        @endforeach
                                        {{-- Total RPD untuk baris ini (jumlah 12 bulan) --}}
                                        <td class="nominal-cell"
                                            style="vertical-align:top; font-weight:bold; text-align:right; border:1px solid #000;">
                                            Rp {{ number_format(array_sum($row['rpd'] ?? [])) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                            {{-- Tampilkan baris ringkasan untuk Unit Kerja "Umum" (letakkan sebelum baris Total global) --}}
                            @php
                                $umumTotal = ['pagu' => 0, 'rpd' => 0, 'realisasi' => 0, 'selisih' => 0];
                                $umumKey = null;
                                foreach ($unitTotals as $uk => $vals) {
                                    if (strtolower(trim($uk)) === 'umum') {
                                        $umumTotal = $vals;
                                        $umumKey = $uk;
                                        break;
                                    }
                                }
                                $umumByMonth = [];
                                if ($umumKey && isset($unitTotalsByMonth[$umumKey])) {
                                    $umumByMonth = $unitTotalsByMonth[$umumKey];
                                } else {
                                    // default zeros
                                    $umumByMonth = [];
                                    foreach (
                                        [
                                            'jan',
                                            'feb',
                                            'mar',
                                            'apr',
                                            'mei',
                                            'jun',
                                            'jul',
                                            'agt',
                                            'sep',
                                            'okt',
                                            'nov',
                                            'des',
                                        ]
                                        as $mm
                                    ) {
                                        $umumByMonth[$mm] = ['rpd' => 0, 'realisasi' => 0, 'selisih' => 0];
                                    }
                                }
                            @endphp
                            <tr style="font-weight:bold;">
                                <td colspan="6" style="border:1px solid #000; padding:6px; text-align:center;">Umum</td>
                                <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp
                                    {{ number_format($umumTotal['pagu']) }}</td>
                                @foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'okt', 'nov', 'des'] as $m)
                                    <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp
                                        {{ number_format($umumByMonth[$m]['rpd'] ?? 0) }}</td>
                                    <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp
                                        {{ number_format($umumByMonth[$m]['realisasi'] ?? 0) }}</td>
                                    <td
                                        style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap; color:red;">
                                        Rp {{ number_format($umumByMonth[$m]['selisih'] ?? 0) }}</td>
                                @endforeach
                                <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp
                                    {{ number_format($umumTotal['rpd']) }}</td>
                            </tr>

                            {{-- TOTAL BARIS UNTUK TABEL MONITORING: Total Pagu + Total per bulan (RPD/Realisasi/Selisih) --}}
                            <tr style="background:#f8f9fa; font-weight:bold;">
                                <td colspan="6" style="border:1px solid #000; padding:6px; text-align:center;">Total Pagu
                                </td>
                                {{-- Total Pagu --}}
                                <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp
                                    {{ number_format($grandTotalPagu ?? array_sum($totalPaguAkun ?? [])) }}</td>
                                {{-- Per-bulan totals: gunakan totalRpdPerBulan, totalRealisasiPerBulan, totalSelisihPerBulan yang dihitung di atas --}}
                                @foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'okt', 'nov', 'des'] as $m)
                                    <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp
                                        {{ number_format($totalRpdPerBulan[$m] ?? 0) }}</td>
                                    <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp
                                        {{ number_format($totalRealisasiPerBulan[$m] ?? 0) }}</td>
                                    <td
                                        style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap; color:red;">
                                        Rp
                                        {{ number_format($totalSelisihPerBulan[$m] ?? ($totalRpdPerBulan[$m] ?? 0) - ($totalRealisasiPerBulan[$m] ?? 0)) }}
                                    </td>
                                @endforeach
                                {{-- Total dari Total RPD per baris (jumlah keseluruhan RPD) --}}
                                <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp
                                    {{ number_format($grandTotalRpd ?? array_sum($totalRpdPerBulan ?? [])) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div> <!-- penutup .table-wrap -->

                {{-- Tabel Ringkasan per Kegiatan, Output dan Sub Komponen --}}
                @php
                    $ringkasan = [];
                    $grandPagu = 0;
                    $grandRpd = 0;
                    $grandRealisasi = 0;
                    $grandSelisih = 0;

                    foreach ($data as $row) {
                        // Parent key unik
                        $key = $row['kegiatan'] . '|' . $row['output'] . '|' . $row['akun_kode'];

                        if (!isset($ringkasan[$key])) {
                            $ringkasan[$key] = [
                                'kegiatan' => $row['kegiatan'],
                                'output' => $row['output'],
                                'komponen' => $row['komponen'],
                                'jenis_belanja' => $row['jenis_belanja'],
                                'unit_kerja' => $row['unit_kerja'],
                                'akun' => $row['akun_kode'],
                                'pagu' => 0,
                                'rpd' => 0,
                                'realisasi' => 0,
                                'selisih' => 0,
                            ];
                        }

                        // Ambil pagu
                        $pagu = $row['total_pagu_output_akun'] ?? ($row['pagu'] ?? 0);

                        // Hitung total RPD & Realisasi 12 bulan
                        $totalRpd = array_sum($row['rpd']);
                        $totalRealisasi = array_sum($row['realisasi']);

                        // ❗ Selisih baru = Pagu - RPD
                        $totalSelisih = $pagu - $totalRpd;

                        // Simpan ke ringkasan
                        $ringkasan[$key]['pagu'] += $pagu;
                        $ringkasan[$key]['rpd'] += $totalRpd;
                        $ringkasan[$key]['realisasi'] += $totalRealisasi;
                        $ringkasan[$key]['selisih'] += $totalSelisih;

                        // Hitung grand total
                        $grandPagu += $pagu;
                        $grandRpd += $totalRpd;
                        $grandRealisasi += $totalRealisasi;
                        $grandSelisih += $totalSelisih;
                    }
                    // Hitung rowspan
                    $rowspanData = [];
                    foreach ($ringkasan as $key => $item) {
                        $kegiatan = $item['kegiatan'];
                        $output = $item['output'];
                        $akun = $item['akun'];

                        // ROWSPAN KEGIATAN PER OUTPUT
                        // contoh: "3365|DCF.001"
                        $kgKey = $kegiatan . '|' . $output;
                        if (!isset($rowspanData['kegiatan'][$kgKey])) {
                            $rowspanData['kegiatan'][$kgKey] = 0;
                        }
                        $rowspanData['kegiatan'][$kgKey]++;

                        // ROWSPAN OUTPUT
                        if (!isset($rowspanData['output'][$kgKey])) {
                            $rowspanData['output'][$kgKey] = 0;
                        }
                        $rowspanData['output'][$kgKey]++;

                        // ROWSPAN AKUN
                        $kaKey = $kgKey . '|' . $akun;
                        if (!isset($rowspanData['akun'][$kaKey])) {
                            $rowspanData['akun'][$kaKey] = 0;
                        }
                        $rowspanData['akun'][$kaKey]++;
                    }

                    // Penanda cell yang sudah ditampilkan
                    $printedKegiatan = [];
                    $printedOutput = [];
                    $printedAkun = [];
                @endphp
                <h2 style="margin-bottom:10px; text-align:center; font-weight:600; font-size:1.1rem">
                    Ringkasan Total RPD Per Kegiatan, Output & Sub Komponen
                </h2>

                <div style="width:100%; overflow-x:auto; -webkit-overflow-scrolling: touch; margin-top:15px;">
                    <table
                        style="width:100%;min-width: 900px;border-collapse:collapse;font-size:0.9rem;background:#fff;border:1px solid #000;">
                        <thead style="background:#e3f0ff;">
                            <tr>
                                <th style="text-align:center; border:1px solid #000; padding:6px;">Kegiatan</th>
                                <th style="text-align:center; border:1px solid #000; padding:6px;">Output</th>
                                <th style="text-align:center; border:1px solid #000; padding:6px;">Komponen</th>
                                <th style="text-align:center; border:1px solid #000; padding:6px;">Jenis Belanja</th>
                                <th style="text-align:center; border:1px solid #000; padding:6px;">Bagian Kelompok
                                    Substansi</th>
                                <th style="text-align:center; border:1px solid #000; padding:6px;">Sub Komponen</th>
                                <th style="text-align:center; border:1px solid #000; padding:6px;">Pagu</th>
                                <th style="text-align:center; border:1px solid #000; padding:6px;">RPD</th>
                                <th style="text-align:center; border:1px solid #000; padding:6px;">Realisasi</th>
                                <th style="text-align:center; border:1px solid #000; padding:6px;">Selisih (Pagu - RPD)
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($ringkasan as $key => $item)
                                @php
                                    // Key untuk grouping rowspan
                                    $kgKey = $item['kegiatan'] . '|' . $item['output'];
                                    $outputKey = $kgKey;
                                    $akunKey = $kgKey . '|' . $item['akun'];
                                @endphp

                                <tr>

                                    {{-- =======================
                        KEGIATAN (ROWSPAN PER OUTPUT)
                      ======================= --}}
                                    @if (!isset($printedKegiatan[$kgKey]))
                                        <td rowspan="{{ $rowspanData['kegiatan'][$kgKey] }}"
                                            style="vertical-align:top; text-align:center; border:1px solid #000; padding:6px;">
                                            {{ $item['kegiatan'] }}
                                        </td>
                                        @php $printedKegiatan[$kgKey] = true; @endphp
                                    @endif

                                    {{-- OUTPUT --}}
                                    @if (!isset($printedOutput[$outputKey]))
                                        <td rowspan="{{ $rowspanData['output'][$outputKey] }}"
                                            style="vertical-align:top; text-align:center; border:1px solid #000; padding:6px;">
                                            {{ $item['output'] }}
                                        </td>
                                        @php $printedOutput[$outputKey] = true; @endphp
                                    @endif

                                    {{-- tampilkan field dari $item (bukan $row) --}}
                                    <td style="vertical-align:top; text-align:center; border:1px solid #000;">
                                        {{ $item['komponen'] }}</td>
                                    <td style="vertical-align:top; text-align:center; border:1px solid #000;">
                                        {{ $item['jenis_belanja'] ?? '-' }}</td>
                                    <td style="vertical-align:top; text-align:center; border:1px solid #000;">
                                        {{ $item['unit_kerja'] ?? '-' }}</td>

                                    {{-- AKUN / SUB KOMPONEN --}}
                                    @if (!isset($printedAkun[$akunKey]))
                                        <td rowspan="{{ $rowspanData['akun'][$akunKey] }}"
                                            style="text-align:center; border:1px solid #000; padding:6px;">
                                            {{ $item['akun'] }}
                                        </td>
                                        @php $printedAkun[$akunKey] = true; @endphp
                                    @endif


                                    {{-- PAGU --}}
                                    <td style="text-align:right; border:1px solid #000; padding:6px;">
                                        Rp {{ number_format($item['pagu'], 0, ',', '.') }}
                                    </td>

                                    {{-- RPD --}}
                                    <td style="text-align:right; border:1px solid #000; padding:6px;">
                                        Rp {{ number_format($item['rpd'], 0, ',', '.') }}
                                    </td>

                                    {{-- REALISASI --}}
                                    <td style="text-align:right; border:1px solid #000; padding:6px;">
                                        Rp {{ number_format($item['realisasi'], 0, ',', '.') }}
                                    </td>

                                    {{-- SELISIH --}}
                                    <td style="text-align:right; border:1px solid #000; padding:6px; color:red;">
                                        Rp {{ number_format($item['selisih'], 0, ',', '.') }}
                                    </td>

                                </tr>
                            @endforeach
                            @php
                                // Hitung ringkasan total untuk unit kerja 'Umum' (case-insensitive)
                                $umumRingkasan = ['pagu' => 0, 'rpd' => 0, 'realisasi' => 0, 'selisih' => 0];
                                foreach ($ringkasan as $k => $it) {
                                    $uk = strtolower(trim($it['unit_kerja'] ?? ''));
                                    if ($uk === '' || $uk === 'umum') {
                                        $umumRingkasan['pagu'] += $it['pagu'] ?? 0;
                                        $umumRingkasan['rpd'] += $it['rpd'] ?? 0;
                                        $umumRingkasan['realisasi'] += $it['realisasi'] ?? 0;
                                        $umumRingkasan['selisih'] += $it['selisih'] ?? 0;
                                    }
                                }
                            @endphp

                            {{-- Total Unit Kerja: Umum (ringkasan per kolom) --}}
                            <tr style="font-weight:bold;">
                                <td colspan="6" style="border:1px solid #000; padding:6px; text-align:center;">Umum
                                </td>
                                <td style="border:1px solid #000; padding:6px; text-align:right; white-space: nowrap;">Rp
                                    {{ number_format($umumRingkasan['pagu'] ?? 0) }}</td>
                                <td style="border:1px solid #000; padding:6px; text-align:right; white-space: nowrap;">Rp
                                    {{ number_format($umumRingkasan['rpd'] ?? 0) }}</td>
                                <td style="border:1px solid #000; padding:6px; text-align:right; white-space: nowrap;">Rp
                                    {{ number_format($umumRingkasan['realisasi'] ?? 0) }}</td>
                                <td
                                    style="border:1px solid #000; padding:6px; text-align:right; color:red; white-space: nowrap;">
                                    Rp {{ number_format($umumRingkasan['selisih'] ?? 0) }}</td>
                            </tr>

                            {{-- GRAND TOTAL --}}
                            <tr style="background:#f8f9fa; font-weight:bold;">
                                <td colspan="6" style="border:1px solid #000; padding:6px; text-align:center;">
                                    Total Pagu
                                </td>

                                <td style="border:1px solid #000; padding:6px; text-align:right; white-space: nowrap;">
                                    Rp {{ number_format($grandPagu) }}
                                </td>

                                <td style="border:1px solid #000; padding:6px; text-align:right; white-space: nowrap;">
                                    Rp {{ number_format($grandRpd) }}
                                </td>

                                <td style="border:1px solid #000; padding:6px; text-align:right; white-space: nowrap;">
                                    Rp {{ number_format($grandRealisasi) }}
                                </td>

                                <td
                                    style="border:1px solid #000; padding:6px; text-align:right; color:red; white-space: nowrap;">
                                    Rp {{ number_format($grandSelisih) }}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                {{-- Summary tabel per Kegiatan + Output: Kegiatan | Output | Komponen | Jenis Belanja | Bag. Kelompok Substansi | Pagu | RPD | Realisasi | Selisih (Pagu - RPD) --}}
                @php
                    // Build summary grouped by kegiatan|output
                    $summary = [];
                    foreach ($data as $row) {
                        $keg = $row['kegiatan'] ?? '';
                        $out = $row['output'] ?? '';
                        $key = $keg . '|' . $out;
                        if (!isset($summary[$key])) {
                            $summary[$key] = [
                                'kegiatan' => $keg,
                                'output' => $out,
                                'komponen' => [],
                                'jenis_belanja' => [],
                                'bag_kelompok_substansi' => [],
                                'pagu' => 0,
                                'rpd' => 0,
                                'realisasi' => 0,
                            ];
                        }
                        // collect unique komponen / jenis / unit
                        if (!empty($row['komponen'])) $summary[$key]['komponen'][$row['komponen']] = true;
                        $jb = $row['jenis_belanja'] ?? '-';
                        if (!empty($jb)) $summary[$key]['jenis_belanja'][$jb] = true;
                        $unit = $row['unit_kerja'] ?? '-';
                        if (!empty($unit)) $summary[$key]['bag_kelompok_substansi'][$unit] = true;

                        // pagu: prefer pre-aggregated keys when present
                        $paguVal = $row['total_pagu_output_akun'] ?? $row['total_pagu_akun'] ?? $row['pagu'] ?? 0;
                        $summary[$key]['pagu'] += (int)$paguVal;

                        // rpd and realisasi are arrays per month in $row
                        $rpdVal = is_array($row['rpd'] ?? null) ? array_sum($row['rpd']) : (int)($row['rpd'] ?? 0);
                        $realVal = is_array($row['realisasi'] ?? null) ? array_sum($row['realisasi']) : (int)($row['realisasi'] ?? 0);
                        $summary[$key]['rpd'] += (int)$rpdVal;
                        $summary[$key]['realisasi'] += (int)$realVal;
                    }
                    // Convert sets to readable strings and sort summary by kegiatan/output
                    $summaryList = collect($summary)->map(function($s){
                        $s['komponen'] = empty($s['komponen']) ? '-' : implode(', ', array_keys($s['komponen']));
                        $s['jenis_belanja'] = empty($s['jenis_belanja']) ? '-' : implode(', ', array_keys($s['jenis_belanja']));
                        $s['bag_kelompok_substansi'] = empty($s['bag_kelompok_substansi']) ? '-' : implode(', ', array_keys($s['bag_kelompok_substansi']));
                        $s['selisih'] = $s['pagu'] - $s['rpd'];
                        return $s;
                    })->sortBy([['kegiatan','asc'],['output','asc']])->values();

                    // Compute Umum and Grand totals from original $summary (which still contains arrays for bag_kelompok_substansi)
                    $umumPagu = $umumRpd = $umumRealisasi = 0;
                    $grandPagu = $grandRpd = $grandRealisasi = 0;
                    foreach ($summary as $orig) {
                        $paguVal = (int)($orig['pagu'] ?? 0);
                        $rpdVal = (int)($orig['rpd'] ?? 0);
                        $realVal = (int)($orig['realisasi'] ?? 0);
                        $grandPagu += $paguVal;
                        $grandRpd += $rpdVal;
                        $grandRealisasi += $realVal;
                        // detect 'Umum' unit: either explicit 'Umum' key or empty unit
                        $units = array_keys($orig['bag_kelompok_substansi'] ?? []);
                        $hasUmum = false;
                        foreach ($units as $u) {
                            if (trim($u) === '' || strtolower(trim($u)) === 'umum') { $hasUmum = true; break; }
                        }
                        if ($hasUmum) {
                            $umumPagu += $paguVal;
                            $umumRpd += $rpdVal;
                            $umumRealisasi += $realVal;
                        }
                    }
                @endphp
<h2 style="text-align:center; font-size:1.1rem; font-weight:600; margin-bottom:10px;">Tabel Monitoring RPD per Kegiatan dan Output</h2>

@php
    $months = ['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'];

    // Build aggregation per kegiatan|output with per-month RPD/Realisasi
    $monitor = [];
    foreach ($data as $row) {
        $keg = $row['kegiatan'] ?? '';
        $out = $row['output'] ?? '';
        $key = $keg . '|' . $out;
        if (!isset($monitor[$key])) {
            $monitor[$key] = [
                'kegiatan' => $keg,
                'output' => $out,
                'komponen' => [],
                'jenis_belanja' => [],
                'bag_kelompok_substansi' => [],
                'pagu' => 0,
                'rpd_month' => [],
                'realisasi_month' => [],
            ];
            foreach ($months as $m) {
                $monitor[$key]['rpd_month'][$m] = 0;
                $monitor[$key]['realisasi_month'][$m] = 0;
            }
        }

        if (!empty($row['komponen'])) $monitor[$key]['komponen'][$row['komponen']] = true;
        $jb = $row['jenis_belanja'] ?? '-';
        if (!empty($jb)) $monitor[$key]['jenis_belanja'][$jb] = true;
        $unit = $row['unit_kerja'] ?? '-';
        if (!empty($unit)) $monitor[$key]['bag_kelompok_substansi'][$unit] = true;

        $paguVal = $row['total_pagu_output_akun'] ?? $row['total_pagu_akun'] ?? $row['pagu'] ?? 0;
        $monitor[$key]['pagu'] += (int)$paguVal;

        foreach ($months as $m) {
            $monitor[$key]['rpd_month'][$m] += $row['rpd'][$m] ?? 0;
            $monitor[$key]['realisasi_month'][$m] += $row['realisasi'][$m] ?? 0;
        }
    }

    // Prepare list and compute totals per key
    $monitorList = collect($monitor)->map(function($s) use ($months) {
        $s['komponen'] = empty($s['komponen']) ? '-' : implode(', ', array_keys($s['komponen']));
        $s['jenis_belanja'] = empty($s['jenis_belanja']) ? '-' : implode(', ', array_keys($s['jenis_belanja']));
        $s['bag_kelompok_substansi'] = empty($s['bag_kelompok_substansi']) ? '-' : implode(', ', array_keys($s['bag_kelompok_substansi']));
        $s['rpd_total'] = array_sum($s['rpd_month'] ?? []);
        $s['realisasi_total'] = array_sum($s['realisasi_month'] ?? []);
        $s['selisih_total'] = $s['pagu'] - $s['rpd_total'];
        return $s;
    })->sortBy([['kegiatan','asc'],['output','asc']])->values();

    // Compute Umum totals (unit_kerja empty or 'Umum') and grand totals
    $umum = ['pagu' => 0, 'rpd_month' => [], 'realisasi_month' => [], 'rpd_total' => 0, 'realisasi_total' => 0];
    foreach ($months as $m) { $umum['rpd_month'][$m] = 0; $umum['realisasi_month'][$m] = 0; }
    $grand = ['pagu' => 0, 'rpd_month' => [], 'realisasi_month' => [], 'rpd_total' => 0, 'realisasi_total' => 0];
    foreach ($months as $m) { $grand['rpd_month'][$m] = 0; $grand['realisasi_month'][$m] = 0; }

    foreach ($data as $row) {
        $unit = strtolower(trim($row['unit_kerja'] ?? ''));
        $isUmum = ($unit === '' || $unit === 'umum');
        $paguVal = $row['total_pagu_output_akun'] ?? $row['total_pagu_akun'] ?? $row['pagu'] ?? 0;
        if ($isUmum) {
            $umum['pagu'] += (int)$paguVal;
        }
        $grand['pagu'] += (int)$paguVal;
        foreach ($months as $m) {
            $r = $row['rpd'][$m] ?? 0;
            $re = $row['realisasi'][$m] ?? 0;
            if ($isUmum) {
                $umum['rpd_month'][$m] += $r;
                $umum['realisasi_month'][$m] += $re;
            }
            $grand['rpd_month'][$m] += $r;
            $grand['realisasi_month'][$m] += $re;
        }
    }
    $umum['rpd_total'] = array_sum($umum['rpd_month']);
    $umum['realisasi_total'] = array_sum($umum['realisasi_month']);
    $umum['selisih_total'] = $umum['pagu'] - $umum['rpd_total'];

    $grand['rpd_total'] = array_sum($grand['rpd_month']);
    $grand['realisasi_total'] = array_sum($grand['realisasi_month']);
    $grand['selisih_total'] = $grand['pagu'] - $grand['rpd_total'];
@endphp

<div style="overflow-x:auto; margin-bottom:12px;">
    <table style="width:100%; border-collapse:collapse; font-size:0.9rem; background:#fff; border:1px solid #000; min-width:1100px;">
        <thead style="background:#e9f5ff;">
            <tr>
                <th rowspan="2" style="border:1px solid #000; padding:6px; text-align:center;">Kegiatan</th>
                <th rowspan="2" style="border:1px solid #000; padding:6px; text-align:center;">Output</th>
                <th rowspan="2" style="border:1px solid #000; padding:6px; text-align:center;">Komponen</th>
                <th rowspan="2" style="border:1px solid #000; padding:6px; text-align:center;">Jenis Belanja</th>
                <th rowspan="2" style="border:1px solid #000; padding:6px; text-align:center;">Bagian Kelompok Substansi</th>
                <th rowspan="2" style="border:1px solid #000; padding:6px; text-align:center;">Pagu</th>
                @foreach (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $month)
                    <th colspan="3" style="text-align:center; border:1px solid #000; padding:6px;">{{ $month }}</th>
                @endforeach
                <th rowspan="2" style="border:1px solid #000; padding:6px; text-align:center;">Total RPD</th>
            </tr>
            <tr style="background:#f0fbff;">
                @foreach ($months as $m)
                    <th style="border:1px solid #000; padding:6px; text-align:center;">RPD</th>
                    <th style="border:1px solid #000; padding:6px; text-align:center;">Realisasi</th>
                    <th style="border:1px solid #000; padding:6px; text-align:center;">Selisih</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($monitorList as $s)
                <tr>
                    <td style="text-align:center; border:1px solid #000; padding:6px;">{{ $s['kegiatan'] }}</td>
                    <td style="border:1px solid #000; padding:6px;">{{ $s['output'] }}</td>
                    <td style="text-align:center; border:1px solid #000; padding:6px;">{{ $s['komponen'] }}</td>
                    <td style="text-align:center; border:1px solid #000; padding:6px;">{{ $s['jenis_belanja'] }}</td>
                    <td style="text-align:center; border:1px solid #000; padding:6px;">{{ $s['bag_kelompok_substansi'] }}</td>
                    <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp {{ number_format($s['pagu']) }}</td>
                    @foreach ($months as $m)
                        @php $rpd = $s['rpd_month'][$m] ?? 0; $re = $s['realisasi_month'][$m] ?? 0; $sel = $rpd - $re; @endphp
                        <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp {{ number_format($rpd) }}</td>
                        <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp {{ number_format($re) }}</td>
                        <td style="border:1px solid #000; padding:6px; text-align:right; color:red; white-space:nowrap;">Rp {{ number_format($sel) }}</td>
                    @endforeach
                    <td style="border:1px solid #000; padding:6px; text-align:right; font-weight:bold; white-space:nowrap;">Rp {{ number_format($s['rpd_total']) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ 6 + (count($months)*3) + 1 }}" style="border:1px solid #000; text-align:center; padding:8px; color:#666;">Tidak ada data</td>
                </tr>
            @endforelse

            {{-- Baris Umum --}}
            <tr style="font-weight:bold;">
                <td colspan="5" style="text-align:center; border:1px solid #000; padding:6px;">Umum</td>
                <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp {{ number_format($umum['pagu']) }}</td>
                @foreach ($months as $m)
                    <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp {{ number_format($umum['rpd_month'][$m] ?? 0) }}</td>
                    <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp {{ number_format($umum['realisasi_month'][$m] ?? 0) }}</td>
                    <td style="border:1px solid #000; padding:6px; text-align:right; color:red; white-space:nowrap;">Rp {{ number_format(($umum['rpd_month'][$m] ?? 0) - ($umum['realisasi_month'][$m] ?? 0)) }}</td>
                @endforeach
                <td style="border:1px solid #000; padding:6px; text-align:right; font-weight:bold;">Rp {{ number_format($umum['rpd_total']) }}</td>
            </tr>

            {{-- Grand Total --}}
            <tr style="font-weight:bold;">
                <td colspan="5" style="text-align:center; border:1px solid #000;">Total</td>
                <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp {{ number_format($grand['pagu']) }}</td>
                @foreach ($months as $m)
                    <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp {{ number_format($grand['rpd_month'][$m] ?? 0) }}</td>
                    <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp {{ number_format($grand['realisasi_month'][$m] ?? 0) }}</td>
                    <td style="border:1px solid #000; padding:6px; text-align:right; color:red; white-space:nowrap;">Rp {{ number_format(($grand['rpd_month'][$m] ?? 0) - ($grand['realisasi_month'][$m] ?? 0)) }}</td>
                @endforeach
                <td style="border:1px solid #000; padding:6px; text-align:right; font-weight:bold; white-space:nowrap;">Rp {{ number_format($grand['rpd_total']) }}</td>
            </tr>
        </tbody>
    </table>
</div>

                <h3 style="text-align:center; font-size:1.05rem; font-weight:600; margin-bottom:8px;">Ringkasan Total RPD per Kegiatan & Output</h3>
                <div style="overflow-x:auto; margin-bottom:12px;">
                    <table style="width:100%; border-collapse:collapse; font-size:0.95rem;">
                        <thead>
                            <tr style="background:#e9f5ff;">
                                <th style="border:1px solid #000; padding:6px; text-align:center;">Kegiatan</th>
                                <th style="border:1px solid #000; padding:6px; text-align:center;">Output</th>
                                <th style="border:1px solid #000; padding:6px; text-align:center;">Komponen</th>
                                <th style="border:1px solid #000; padding:6px; text-align:center;">Jenis Belanja</th>
                                <th style="border:1px solid #000; padding:6px; text-align:center;">Bagian Kelompok Substansi</th>
                                <th style="border:1px solid #000; padding:6px; text-align:center;">Pagu</th>
                                <th style="border:1px solid #000; padding:6px; text-align:center;">RPD</th>
                                <th style="border:1px solid #000; padding:6px; text-align:center;">Realisasi</th>
                                <th style="border:1px solid #000; padding:6px; text-align:center;">Selisih (Pagu - RPD)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($summaryList as $s)
                                <tr>
                                    <td style="text-align:center; border:1px solid #000; padding:6px;">{{ $s['kegiatan'] }}</td>
                                    <td style="border:1px solid #000; padding:6px;">{{ $s['output'] }}</td>
                                    <td style="text-align:center; border:1px solid #000; padding:6px;">{{ $s['komponen'] }}</td>
                                    <td style="text-align:center; border:1px solid #000; padding:6px;">{{ $s['jenis_belanja'] }}</td>
                                    <td style="text-align:center; border:1px solid #000; padding:6px;">{{ $s['bag_kelompok_substansi'] }}</td>
                                    <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp {{ number_format($s['pagu']) }}</td>
                                    <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp {{ number_format($s['rpd']) }}</td>
                                    <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp {{ number_format($s['realisasi']) }}</td>
                                    <td style="border:1px solid #000; padding:6px; text-align:right; color:red; white-space:nowrap;">Rp {{ number_format($s['selisih']) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" style="border:1px solid #000; text-align:center; padding:8px; color:#666;">Tidak ada data</td>
                                </tr>
                            @endforelse
                            {{-- Baris khusus: Umum (gabungan untuk unit kosong/Umum) --}}
                            <tr style="background:#f8f9fa; font-weight:700;">
                                <td style="border:1px solid #000; padding:6px; text-align:center;" colspan="5">Umum</td>
                                <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp {{ number_format($umumPagu) }}</td>
                                <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp {{ number_format($umumRpd) }}</td>
                                <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp {{ number_format($umumRealisasi) }}</td>
                                <td style="border:1px solid #000; padding:6px; text-align:right; color:red; white-space:nowrap;">Rp {{ number_format($umumPagu - $umumRpd) }}</td>
                            </tr>
                            {{-- Baris total keseluruhan ringkasan --}}
                            <tr style="background:#f8f9fa; font-weight:bold;">
                                <td style="border:1px solid #000; padding:6px; text-align:center;" colspan="5">Total Pagu</td>
                                <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp {{ number_format($grandPagu) }}</td>
                                <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp {{ number_format($grandRpd) }}</td>
                                <td style="border:1px solid #000; padding:6px; text-align:right; white-space:nowrap;">Rp {{ number_format($grandRealisasi) }}</td>
                                <td style="border:1px solid #000; padding:6px; text-align:right; color:red; white-space:nowrap;">Rp {{ number_format($grandPagu - $grandRpd) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                {{-- Ringkasan Tabel RPD, Realisasi & Selisih per Bulan --}}
                @php
                    // Hitung total RPD, Realisasi, Selisih per bulan hanya dari nilai yang tampil (rowspan), tidak double count
                    $totalRpdPerBulan = [];
                    $totalRealisasiPerBulan = [];
                    $totalSelisihPerBulan = [];
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
                    $rpdRowspanValues = [];
                    $realisasiRowspanValues = [];
                    $selisihRowspanValues = [];
                    foreach (
                        ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'okt', 'nov', 'des']
                        as $m
                    ) {
                        $totalRpdPerBulan[$m] = 0;
                        $totalRealisasiPerBulan[$m] = 0;
                        $totalSelisihPerBulan[$m] = 0;
                        $rpdRowspanValues[$m] = [];
                        $realisasiRowspanValues[$m] = [];
                        $selisihRowspanValues[$m] = [];
                    }
                    foreach ($data as $row) {
                        $parentKey =
                            $row['output'] . '|' . $row['akun_kode'] . '|' . ($row['total_pagu_output_akun'] ?? 0);
                        foreach (
                            ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'okt', 'nov', 'des']
                            as $m
                        ) {
                            $rpdValue = $row['rpd'][$m] ?? 0;
                            $realisasiValue = $row['realisasi'][$m] ?? 0;
                            $selisihValue = $rpdValue - $realisasiValue;
                            $rpdKey = $parentKey . '|' . $m . '|' . $rpdValue;
                            $realisasiKey = $parentKey . '|' . $m . '|' . $realisasiValue;
                            $selisihKey = $parentKey . '|' . $m . '|' . $selisihValue;
                            if (!isset($rpdRowspanValues[$m][$rpdKey])) {
                                $totalRpdPerBulan[$m] += $rpdValue;
                                $rpdRowspanValues[$m][$rpdKey] = true;
                            }
                            if (!isset($realisasiRowspanValues[$m][$realisasiKey])) {
                                $totalRealisasiPerBulan[$m] += $realisasiValue;
                                $realisasiRowspanValues[$m][$realisasiKey] = true;
                            }
                            if (!isset($selisihRowspanValues[$m][$selisihKey])) {
                                $totalSelisihPerBulan[$m] += $selisihValue;
                                $selisihRowspanValues[$m][$selisihKey] = true;
                            }
                        }
                    }
                @endphp
                <h2 style="text-align:center; font-size:1.1rem; font-weight:600; margin-bottom:10px;">
                    Ringkasan Tabel RPD, Realisasi & Selisih Per Bulan
                </h2>
                <div class="responsive-table" style="width:100%; overflow-x:auto; -webkit-overflow-scrolling: touch;">
                    <table
                        style="width: 100%;min-width: 650px;background: #fff;border-radius: 8px;border-collapse: collapse;color: #000;
        font-size: 0.9rem;box-shadow: 0 2px 8px rgba(0,0,0,0.1);border:1px solid #000;">
                        <thead style="background: #eaf6ff;">
                            <tr>
                                <th
                                    style="text-align: center; padding: 6px 10px; border:1px solid #000; white-space: nowrap;">
                                    Bulan</th>
                                <th
                                    style="text-align: center; padding: 6px 10px; border:1px solid #000; white-space: nowrap;">
                                    Total RPD</th>
                                <th
                                    style="text-align: center; padding: 6px 10px; border:1px solid #000; white-space: nowrap;">
                                    Total Realisasi</th>
                                <th
                                    style="text-align: center; padding: 6px 10px; border:1px solid #000; white-space: nowrap;">
                                    Selisih (RPD - Realisasi)</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'okt', 'nov', 'des'] as $m)
                                @php
                                    $rpd = $totalRpdPerBulan[$m] ?? 0;
                                    $realisasi = $totalRealisasiPerBulan[$m] ?? 0;
                                    $selisih = $rpd - $realisasi;
                                @endphp

                                <tr>
                                    <td
                                        style="padding: 5px 10px; border:1px solid #000; background:#f9f9f9; white-space: nowrap;">
                                        {{ $bulanLabels[$m] }}
                                    </td>
                                    <td style="text-align:right; padding: 5px 10px; border:1px solid #000;">Rp
                                        {{ number_format($rpd) }}</td>
                                    <td style="text-align:right; padding: 5px 10px; border:1px solid #000;">Rp
                                        {{ number_format($realisasi) }}</td>
                                    <td style="text-align:right; padding: 5px 10px; border:1px solid #000; color: red;">
                                        Rp {{ number_format($selisih) }}</td>
                                </tr>
                            @endforeach

                            <tr style="background:#f8f9fa; font-weight: bold;">
                                <td
                                    style="text-align:center; padding: 5px 10px; border:1px solid #000; white-space: nowrap;">
                                    Grand Total</td>
                                <td style="text-align:right; padding: 5px 10px; border:1px solid #000;">Rp
                                    {{ number_format(array_sum($totalRpdPerBulan)) }}</td>
                                <td style="text-align:right; padding: 5px 10px; border:1px solid #000;">Rp
                                    {{ number_format(array_sum($totalRealisasiPerBulan)) }}</td>
                                <td style="text-align:right; padding: 5px 10px; border:1px solid #000; color:red;">
                                    Rp {{ number_format(array_sum($totalSelisihPerBulan)) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="font-size: 0.85rem; color: #444; margin-top: 6px;">
                    Keterangan: Data menampilkan total RPD, Realisasi, dan Selisih per bulan beserta grand total.
                </div>
            </div>

            <style>
                /* Kolom nominal angka: tetap Segoe UI, rata kanan, lebar dinamis */
                .nominal-cell {
                    font-family: 'Segoe UI', Arial, sans-serif;
                    text-align: right;
                    /* rapikan ke kanan */
                    min-width: 90px;
                    white-space: nowrap;
                }

                /* Tambahkan jarak atas pada baris total pagu */
                tr.total-pagu-row {
                    margin-top: 10px !important;
                }

                @media (max-width: 768px) {
                    .filter-tahun {
                        width: 100%;
                    }

                    /* summary-cards: stack pada layar kecil */
                    .summary-cards {
                        flex-direction: column !important;
                        align-items: stretch !important;
                    }
                }
            </style>
        @endsection
