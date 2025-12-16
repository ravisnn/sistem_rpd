<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>LAPORAN RPD TAHUN ANGGARAN
        {{ $tahun }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 0.85rem;
        }

        h1 {
            font-size: 1.3rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px 10px;
            font-size: 0.85rem;
        }

        th {
            background: #e3f0ff;
        }

        .jenis-title {
            font-weight: bold;
            color: #222;
            font-size: 1rem;
            margin-top: 18px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    @php
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
        $hariIndo = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $now->locale('id');
        $hari = $hariIndo[$now->format('l')] ?? $now->format('l');
        $tanggalCetak =
            $hari . ', ' . $now->format('d') . ' ' . $now->translatedFormat('F Y') . ' ' . $now->format('H:i') . ' WIB';
    @endphp
    @foreach ($orderJenis as $jenis)
        @if ($loop->first)
            <h1>LAPORAN RPD<br>TAHUN ANGGARAN
                {{ $tahun }}</h1>
            <div style="font-size:0.75rem; color:#444; margin-bottom:16px; text-align:center;">Dicetak:
                {{ $tanggalCetak }}</div>
        @else
            <div class="page-break"></div>
        @endif
        <div>
            <div class="jenis-title">Jenis Belanja: {{ $jenis }}</div>
            <table>
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Total (Rp)</th>
                        <th>IKPA</th>
                        <th>Target</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bulanLabels as $m => $label)
                        @php
                            $hasData = isset($rekap[$jenis]);
                            $totalJenis = $hasData ? array_sum($rekap[$jenis]) : 0;
                            $ikpaVal = 0;
                            $targetVal = '';
                            $tw = 0;
                            if ($label == 'Maret') {
                                $tw = 1;
                                $ikpaVal =
                                    $totalJenis > 0
                                        ? (($hasData
                                                ? $rekap[$jenis]['jan'] + $rekap[$jenis]['feb'] + $rekap[$jenis]['mar']
                                                : 0) /
                                                $totalJenis) *
                                            100
                                        : 0;
                                $targetVal = $targets[$jenis][$tw] ?? 15;
                            } elseif ($label == 'Juni') {
                                $tw = 2;
                                $ikpaVal =
                                    $totalJenis > 0
                                        ? (($hasData
                                                ? $rekap[$jenis]['jan'] +
                                                    $rekap[$jenis]['feb'] +
                                                    $rekap[$jenis]['mar'] +
                                                    $rekap[$jenis]['apr'] +
                                                    $rekap[$jenis]['mei'] +
                                                    $rekap[$jenis]['jun']
                                                : 0) /
                                                $totalJenis) *
                                            100
                                        : 0;
                                $targetVal = $targets[$jenis][$tw] ?? 50;
                            } elseif ($label == 'September') {
                                $tw = 3;
                                $ikpaVal =
                                    $totalJenis > 0
                                        ? (($hasData
                                                ? $rekap[$jenis]['jan'] +
                                                    $rekap[$jenis]['feb'] +
                                                    $rekap[$jenis]['mar'] +
                                                    $rekap[$jenis]['apr'] +
                                                    $rekap[$jenis]['mei'] +
                                                    $rekap[$jenis]['jun'] +
                                                    $rekap[$jenis]['jul'] +
                                                    $rekap[$jenis]['agt'] +
                                                    $rekap[$jenis]['sep']
                                                : 0) /
                                                $totalJenis) *
                                            100
                                        : 0;
                                $targetVal = $targets[$jenis][$tw] ?? 70;
                            } elseif ($label == 'Desember') {
                                $tw = 4;
                                $ikpaVal =
                                    $totalJenis > 0
                                        ? (($hasData
                                                ? $rekap[$jenis]['jan'] +
                                                    $rekap[$jenis]['feb'] +
                                                    $rekap[$jenis]['mar'] +
                                                    $rekap[$jenis]['apr'] +
                                                    $rekap[$jenis]['mei'] +
                                                    $rekap[$jenis]['jun'] +
                                                    $rekap[$jenis]['jul'] +
                                                    $rekap[$jenis]['agt'] +
                                                    $rekap[$jenis]['sep'] +
                                                    $rekap[$jenis]['okt'] +
                                                    $rekap[$jenis]['nov'] +
                                                    $rekap[$jenis]['des']
                                                : 0) /
                                                $totalJenis) *
                                            100
                                        : 0;
                                $targetVal = $targets[$jenis][$tw] ?? 90;
                            }
                        @endphp
                        <tr>
                            <td style="text-align:center;">{{ $label }}</td>
                            <td style="text-align:right; color:#222;">Rp
                                {{ number_format($hasData ? $rekap[$jenis][$m] : 0, 0, ',', '.') }}</td>
                            <td style="text-align:center; color:#222;">
                                @if ($ikpaVal)
                                    {{ number_format($ikpaVal, 2) }}%
                                    <br>
                                    @php
                                        $ikpaKet = '';
                                        if ($label == 'Desember' && $ikpaVal >= 100) {
                                            $ikpaKet = 'Tercapai';
                                        } elseif ($ikpaVal > $targetVal) {
                                            $ikpaKet = 'Melebihi target';
                                        } elseif ($ikpaVal < $targetVal) {
                                            $ikpaKet = 'Belum mencapai target';
                                        }
                                    @endphp
                                    <span
                                        style="font-size:0.95em; color:#222; font-family:Arial, sans-serif; font-weight:normal;">{{ $ikpaKet }}</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                @if ($targetVal !== '')
                                    {{ $targetVal }}%
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr style="background:#f9f9f9; font-weight:bold;">
                        <td style="text-align:center; color:#222;">Total</td>
                        <td style="text-align:right;">Rp
                            {{ number_format($hasData ? array_sum($rekap[$jenis]) : 0, 0, ',', '.') }}</td>
                        <td style="color:#222;"></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endforeach
</body>

</html>
