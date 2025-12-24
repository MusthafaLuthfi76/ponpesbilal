<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Rapor Santri - {{ $santri->nama ?? '' }}</title>

    <style>
        /* RESET & BASE */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.3;
            margin: 0;
            padding: 20px;
        }

        @page {
            margin: 15mm 10mm;
        }

        /* HEADER SECTION */
        .header-section {
            text-align: center;
            margin-bottom: 15px;
            padding: 15px 0;
        }

        .logo-container {
            margin-bottom: 10px;
        }

        .header-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        .header-title h2 {
            font-size: 14px;
            font-weight: bold;
            color: #000;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .header-title h3 {
            font-size: 12px;
            font-weight: bold;
            color: #000;
            margin-bottom: 3px;
        }

        .header-title h4 {
            font-size: 12px;
            font-weight: bold;
            color: #000;
            margin-bottom: 3px;
        }

        /* IDENTITAS SANTRI */
        .identity-wrapper {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            padding: 8px 0;
            margin-bottom: 15px;
            font-size: 13px;
        }

        .identity-table {
            width: 100%;
            border-collapse: collapse;
        }

        .identity-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .identity-table .left {
            width: 50%;
        }

        .identity-table .right {
            width: 50%;
            text-align: left;
        }

        .label {
            display: inline-block;
            width: 120px;
        }

        .colon {
            display: inline-block;
            width: 10px;
        }

        .value {
            font-weight: bold;
        }

        /* SECTION TITLE */
        .section-title {
            font-weight: bold;
            background: white;
            padding: 8px 0;
            margin-top: 20px;
            margin-bottom: 5px;
            font-size: 12px;
        }

        /* TABEL UTAMA - TAHFIZH & AKADEMIK */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 2px solid #000;
            page-break-inside: auto;
        }

        table.data-table thead {
            display: table-header-group;
        }

        table.data-table th {
            background: #056400;
            color: white;
            padding: 8px 6px;
            font-size: 11px;
            text-align: center;
            border: 1px solid #000;
            font-weight: bold;
        }

        table.data-table td {
            border: 1px solid #000;
            padding: 8px 6px;
            font-size: 10px;
            vertical-align: top;
            page-break-inside: avoid;
            page-break-before: auto;
        }

        /* ROW STYLING */
        table.data-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        table.data-table tr.parent-row {
            page-break-inside: avoid;
            page-break-after: avoid;
        }

        table.data-table td.no-cell {
            text-align: center;
            width: 30px;
            font-weight: bold;
        }

        table.data-table td.subject-cell {
            font-weight: bold;
            text-align: left;
            vertical-align: middle;
            padding-left: 10px;
        }

        table.data-table td.text-center {
            text-align: center;
            font-weight: bold;
            vertical-align: middle;
        }

        /* Kolom Mata Pelajaran (kolom ke-2) - center vertikal saja */
        table.data-table td:nth-child(2),
        table.data-table th:nth-child(2) {
            text-align: left;
            vertical-align: middle;
        }

        /* Kolom Nilai Angka (kolom ke-3) */
        table.data-table td:nth-child(3),
        table.data-table th:nth-child(3) {
            text-align: center;
            vertical-align: middle;
        }

        /* Kolom Nilai Huruf (kolom ke-4) */
        table.data-table td:nth-child(4),
        table.data-table th:nth-child(4) {
            text-align: center;
            vertical-align: middle;
        }

        /* SUB ROWS */
        table.data-table tr.sub-row td:first-child {
            border-top: none;
            border-bottom: none;
        }

        table.data-table tr.sub-row td:nth-child(2) {
            text-align: left;
            vertical-align: middle;
            padding-left: 30px;
        }

        /* KOLOM KETERANGAN */
        table.data-table td.keterangan-cell {
            width: 50%;
            word-wrap: break-word;
            word-break: break-word;
            overflow-wrap: break-word;
            padding: 8px 6px;
            font-size: 10px;
            line-height: 1.3;
            vertical-align: top;
        }

        .keterangan-cell .detail-text {
            margin: 0;
            padding: 0;
            font-size: inherit;
            line-height: inherit;
        }

        .detail-text {
            font-size: 9px;
            line-height: 1.5;
        }

        /* BULLET LIST */
        .bullet-list {
            padding-left: 20px;
            margin: 5px 0;
            list-style-type: none;
        }

        .bullet-list li {
            position: relative;
            padding-left: 15px;
            margin-bottom: 3px;
        }

        .bullet-list li::before {
            content: "•";
            position: absolute;
            left: 0;
            font-weight: bold;
        }

        .detail-header {
            font-weight: bold;
            margin-top: 5px;
            margin-bottom: 3px;
        }

        .centered-text {
            text-align: center;
            margin: 4px 0;
            font-weight: bold;
            line-height: 1.3;
        }

        /* KEHADIRAN */
        .attendance-box {
            width: 100%;
            border: 2px solid #000;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 13px;
            page-break-inside: avoid;
        }

        .attendance-box td {
            border: 1px solid #000;
            vertical-align: middle;
        }

        .attendance-label {
            width: 25%;
            background-color: #dbe7c3;
            text-align: center;
            font-weight: bold;
            padding: 10px;
        }

        .attendance-content {
            width: 75%;
            padding: 5px 10px;
        }

        .attendance-table {
            width: 100%;
            border-collapse: collapse;
        }

        .attendance-table td {
            border: none !important;
            padding: 2px 6px;
        }

        /* TABEL KESANTRIAN */
        .kesantrian-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
            font-size: 10px;
            page-break-inside: auto;
        }

        .kesantrian-table thead {
            display: table-header-group;
        }

        .kesantrian-table tfoot {
            display: table-footer-group;
        }

        .kesantrian-table thead th {
            background: #0b6b1a;
            color: #fff;
            text-align: center;
            font-weight: bold;
            padding: 6px;
            border: 1px solid #000;
        }

        .kesantrian-table td {
            padding: 5px 8px;
            vertical-align: middle;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            page-break-inside: avoid;
        }

        .kesantrian-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        /* SECTION ROW (1,2,3) */
        .kesantrian-table tr.section-row td {
            background: #c1d59a;
            font-weight: bold;
            border-top: 2px solid #000;
            border-bottom: 1px solid #000;
            page-break-inside: avoid;
        }

        /* KOLOM NO */
        .kesantrian-table th:first-child,
        .kesantrian-table td:first-child {
            width: 5%;
            text-align: center;
            vertical-align: middle;
        }

        .kesantrian-table tr.sub-item td:first-child {
            border-top: none;
            border-bottom: none;
        }

        .kesantrian-table tr.section-row td:first-child {
            border-top: 2px solid #000;
        }

        .kesantrian-table tr.sub-item:last-of-type td:first-child {
            border-bottom: 2px solid #000;
        }

        /* KOLOM NILAI */
        .kesantrian-table td:nth-child(3) {
            text-align: center;
            font-weight: bold;
            width: 12%;
        }

        /* SUB ITEM (a,b,c,d) */
        .kesantrian-table tr.sub-item td {
            background: #fff;
            font-weight: normal;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .kesantrian-table tr.sub-item td:nth-child(2) {
            padding-left: 18px;
        }

        .kesantrian-table tr.sub-item:last-of-type td {
            border-bottom: 2px solid #000;
        }

        /* PARENT ROW STYLING */
        .parent-row td {
            background-color: #c1d59a;
            font-weight: bold;
        }

        /* SIGNATURE SECTION */
        .signature-wrapper {
            margin-top: 30px;
            display: table;
            width: 100%;
            page-break-inside: avoid;
        }

        .signature-left {
            display: table-cell;
            width: 50%;
            vertical-align: bottom;
            text-align: center;
            padding: 20px;
        }

        .signature-right {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 20px;
        }

        .signature-content {
            text-align: right;
            display: inline-block;
        }

        .signature-place {
            margin-bottom: 10px;
        }

        .signature-title {
            font-weight: bold;
            margin-bottom: 60px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .logo-stamp {
            max-width: 120px;
            margin-top: 20px;
        }

        /* PAGE BREAK CONTROL */
        .page-break-control {
            page-break-before: always;
        }

        .keep-together {
            page-break-inside: avoid;
        }

        .allow-break {
            page-break-inside: auto;
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <div class="header-section">
        <div class="logo-container">
            <img src="{{ public_path('img/logo.png') }}" class="header-logo">
        </div>
        <div class="header-title">
            <h2>LAPORAN PENILAIAN AKHIR TAHUN</h2>
            <h3>PONDOK PESANTREN TAHFIZHUL QUR'AN BILAL BIN RABAH</h3>
            <h4>SUKOHARJO</h4>
        </div>
    </div>

    <!-- IDENTITAS SANTRI -->
    <div class="identity-wrapper">
        <table class="identity-table">
            <tr>
                <td class="left">
                    <span class="label">Nama</span>
                    <span class="colon">:</span>
                    <span class="value">{{ $santri->nama ?? '-' }}</span>
                </td>
                <td class="right">
                    <span class="label">Kelas / Semester</span>
                    <span class="colon">:</span>
                    <span class="value">
                        {{ $kelasTampil ?? '-' }} / {{ $semesterTampil ?? '-' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="left">
                    <span class="label">No. Induk</span>
                    <span class="colon">:</span>
                    <span class="value">{{ $santri->nis ?? '-' }}</span>
                </td>
                <td class="right">
                    <span class="label">Tahun Pelajaran</span>
                    <span class="colon">:</span>
                    <span class="value">{{ $santri->tahunAjaran->tahun ?? '-' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <!-- BAGIAN A: TAHFIZH DAN AKADEMIK -->
    <div class="section-title">A. TAHFIZH DAN AKADEMIK</div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width:4%">No</th>
                <th style="width:28%">Mata Pelajaran</th>
                <th style="width:10%">Nilai<br>Angka</th>
                <th style="width:8%">Nilai<br>Huruf</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <!-- 1. Al-Qur'an -->
            <tr class="parent-row">
                <td class="no-cell">1</td>
                <td class="subject-cell">Al-Qur'an</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td></td>
            </tr>

            <!-- a. Tahfizh -->
            <tr class="sub-row">
                <td></td>
                <td>a. Tahfizh</td>
                <td class="text-center">{{ $nilaiTahfidz ?? '-' }}</td>
                <td class="text-center">{{ $nilaiHurufTahfidz ?? '-' }}</td>
                <td class="keterangan-cell">
                    <div class="detail-text">
                        <div class="detail-header">Jumlah Hafalan:</div>
                        <b>{{ count(explode(',', $daftarJuz)) }} Juz - Halaman<br />(Juz {{ $daftarJuz }})</b>

                        <div class="detail-header">Jumlah Hafalan yang Diujikan:</div>
                        <b>{{ $totalJuzDiuji ?? 0 }} Juz<br />
                            @if (!empty($daftarJuzDiuji))
                                (Juz {{ $daftarJuzDiuji }})
                            @endif
                        </b><br>
                        <div class="centered-text">Sekali duduk: {{ $sekaliDuduk ?? '-' }}</div>
                    </div>
                </td>
            </tr>

            <!-- b. Tahsin -->
            <tr class="sub-row">
                <td></td>
                <td>b. Tahsin</td>

                @php
                    $nilaiTahsin = $nilaiAkademik->first(function ($item) {
                        return $item->mataPelajaran &&
                            stripos($item->mataPelajaran->nama_matapelajaran ?? '', 'tahsin') !== false;
                    });
                @endphp

                <td class="text-center">{{ $nilaiTahsin->nilai ?? '-' }}</td>
                <td class="text-center">{{ $nilaiTahsin->predikat ?? '-' }}</td>
                <td class="keterangan-cell">
                    <div class="detail-text">
                        @if ($nilaiTahsin && $nilaiTahsin->materi_pelajaran)
                            @php
                                $predikat = strtoupper(trim($nilaiTahsin->predikat ?? ''));
                                $keteranganMap = [
                                    'A' => 'Mumtaz',
                                    'A-' => 'Mumtaz',
                                    'B+' => 'Jayyid Jiddan',
                                    'B' => 'Jayyid Jiddan',
                                    'B-' => 'Jayyid Jiddan',
                                    'C+' => 'Jayyid',
                                    'C' => 'Jayyid',
                                    'C-' => 'Jayyid',
                                    'D' => 'Maqbul',
                                    'E' => 'Dha\'if',
                                ];
                                $predikatArab = $keteranganMap[$predikat] ?? '-';
                            @endphp

                            <!-- Tampilkan Predikat Arab di atas -->
                            <div class="detail-header centered-text">{{ $predikatArab }}</div>

                            <!-- Header "Materi Pelajaran:" -->
                            <div class="detail-header">Materi Pelajaran:</div>

                            <!-- Daftar materi dengan bullet -->
                            <ul class="bullet-list">
                                @foreach (explode("\n", trim($nilaiTahsin->materi_pelajaran)) as $materi)
                                    @if (trim($materi))
                                        <li>{{ trim($materi) }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            -
                        @endif
                    </div>
                </td>
            </tr>

            <!-- 2. Dirasah Islamiyah -->
            <tr class="parent-row">
                <td class="no-cell">2</td>
                <td class="subject-cell" colspan="4">Dirasah Islamiyah</td>
            </tr>

            @php
                // Filter nilai akademik kecuali Tahsin
                $dirasahItems = $nilaiAkademik->filter(function ($item) {
                    return !$item->mataPelajaran ||
                        stripos($item->mataPelajaran->nama_matapelajaran ?? '', 'tahsin') === false;
                });
            @endphp

            @forelse ($dirasahItems as $index => $a)
                <tr class="sub-row">
                    <td></td>
                    <td>
                        {{ chr(97 + $index) }}. {{ $a->mataPelajaran->nama_matapelajaran ?? '-' }}
                    </td>
                    <td class="text-center">{{ $a->nilai ?? '-' }}</td>
                    <td class="text-center">{{ $a->predikat ?? '-' }}</td>
                    <td class="keterangan-cell">
                        <div class="detail-text">
                            @if ($a->materi_pelajaran)
                                @php
                                    $predikat = strtoupper(trim($a->predikat ?? ''));
                                    $keteranganMap = [
                                        'A' => 'Sangat memahami dengan baik materi yang dipelajari:',
                                        'B' => 'Memahami dengan baik materi yang dipelajari:',
                                        'C' => 'Cukup memahami materi yang dipelajari:',
                                        'D' => 'Kurang memahami materi yang dipelajari:',
                                    ];
                                    $keterangan = $keteranganMap[$predikat] ?? 'Memahami materi yang dipelajari:';
                                @endphp
                                <div class="detail-header">{{ $keterangan }}</div>
                                <ul class="bullet-list">
                                    @foreach (explode("\n", trim($a->materi_pelajaran)) as $materi)
                                        @if (trim($materi))
                                            <li>{{ trim($materi) }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            @else
                                -
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="sub-row">
                    <td></td>
                    <td style="padding-left: 30px;" colspan="4">
                        <i>Belum ada data nilai akademik</i>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- KEHADIRAN -->
    <div class="attendance-section keep-together">
        <table class="attendance-box">
            <tr>
                <td class="attendance-label">Ketidakhadiran<br>(Dirasah)</td>
                <td class="attendance-content">
                    <table class="attendance-table">
                        <tr>
                            <td class="num">1.</td>
                            <td class="item">Sakit</td>
                            <td class="colon">:</td>
                            <td class="value">{{ $totalSakit }}</td>
                            <td class="unit">Hari</td>
                        </tr>
                        <tr>
                            <td class="num">2.</td>
                            <td class="item">Izin</td>
                            <td class="colon">:</td>
                            <td class="value">{{ $totalIzin }}</td>
                            <td class="unit">Hari</td>
                        </tr>
                        <tr>
                            <td class="num">3.</td>
                            <td class="item">Ghaib</td>
                            <td class="colon">:</td>
                            <td class="value">{{ $totalGhaib }}</td>
                            <td class="unit">Hari</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <!-- BAGIAN B: KESANTRIAN -->
    <div class="section-title">B. KESANTRIAN</div>

    <table class="kesantrian-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Nilai</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr class="section-row">
                <td>1</td>
                <td><b>Penilaian Akhlak Santri</b></td>
                <td></td>
                <td></td>
            </tr>

            @php
                $nilaiKesantrianSub = $nilaiKesantrian
                    ? $nilaiKesantrian->filter(function ($item) {
                        return in_array($item['aspek'], ['Ibadah', 'Akhlak', 'Kerapian', 'Kedisiplinan']);
                    })
                    : collect();
            @endphp

            @foreach (range(0, 3) as $i)
                @php
                    $aspek = ['Ibadah', 'Akhlak', 'Kerapian', 'Kedisiplinan'][$i];
                    $item = $nilaiKesantrianSub->firstWhere('aspek', $aspek);
                @endphp
                <tr class="sub-item">
                    <td></td>
                    <td>{{ chr(97 + $i) }}. {{ $aspek }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $item['nilai'] ?? '-' }}</td>
                    <td style="text-align: center;">
                        {{ $item['keterangan'] ?? '-' }}
                    </td>

                </tr>
            @endforeach

            @php
                $ekstra = $nilaiKesantrian ? $nilaiKesantrian->firstWhere('aspek', 'Ekstrakulikuler') : null;
                $buku = $nilaiKesantrian ? $nilaiKesantrian->firstWhere('aspek', 'Buku Pegangan') : null;
            @endphp

            <tr class="section-row">
                <td>2</td>
                <td><b>Ekstrakurikuler</b></td>
                <td style="text-align: center; font-weight: bold;">{{ $ekstra['nilai'] ?? '-' }}</td>
                <td style="text-align: center;">
                    {{ $ekstra['keterangan'] ?? '-' }}
                </td>
            </tr>

            <tr class="section-row">
                <td>3</td>
                <td><b>Buku Pegangan</b></td>
                <td style="text-align: center; font-weight: bold;">{{ $buku['nilai'] ?? '-' }}</td>
                <td style="text-align: center;">
                    {{ $buku['keterangan'] ?? '-' }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- TANDA TANGAN -->
    <div class="signature-wrapper keep-together">
        <div class="signature-left">
            @php
                $stempelPath = public_path('images/stempel-pesantren.png');
            @endphp
            @if (file_exists($stempelPath))
                <img src="{{ $stempelPath }}" alt="Stempel Pesantren" class="logo-stamp">
            @endif
            <div style="margin-top: 10px; font-size: 10px;">
                <b>Direktur Pesantren</b><br><br><br><br>
                <u><b>Marwanto Abdussalam, Lc</b></u>
            </div>
        </div>
        <div class="signature-right">
            <div class="signature-content">
                <div class="signature-place">Diberikan di &nbsp;&nbsp;&nbsp;: <b>Sukoharjo</b></div>
                <div class="signature-place">Pada
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                    <b>{{ now()->format('d F Y') }}</b>
                </div>
                <div style="margin-top: 30px;">
                    <div class="signature-title">Musyrif</div>
                    <div class="signature-name">Ust. Deka Sumitra</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
