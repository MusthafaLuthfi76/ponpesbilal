<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rapor Santri - {{ $santri->nama ?? '' }}</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            margin: 20px;
            line-height: 1.3;
            page-break-inside: avoid;
        }

        /* Header Section dengan Logo */
        .header-section {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px 0;
            border-bottom: 3px solid #2d5016;
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
            font-size: 11px;
            font-weight: normal;
            color: #333;
        }

        /* Identitas Santri */
        .identity-section {
            margin: 20px 0;
            border: 2px solid #333;
        }

        .identity-table {
            width: 100%;
            border-collapse: collapse;
        }

        .identity-table td {
            padding: 6px 10px;
            font-size: 11px;
        }

        .identity-table tr:first-child td {
            border-bottom: 1px solid #333;
        }

        .identity-table td:nth-child(2),
        .identity-table td:nth-child(4) {
            border-left: 1px solid #333;
        }

        .identity-label {
            display: inline-block;
            width: 130px;
        }

        /* Section Title */
        .section-title {
            font-weight: bold;
            background: white;
            padding: 8px 0;
            margin-top: 20px;
            margin-bottom: 5px;
            font-size: 12px;
        }

        /* Tables */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 2px solid #000;
        }

        table.data-table th {
            background: #2d5016;
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
        }

        table.data-table td.no-cell {
            text-align: center;
            width: 30px;
            font-weight: bold;
        }

        table.data-table td.subject-cell {
            font-weight: bold;
            padding-left: 10px;
        }

        table.data-table td.text-center {
            text-align: center;
            font-weight: bold;
        }

        /* Sub rows untuk sub-item */
        table.data-table tr.sub-row td:first-child {
            text-align: center;
            font-weight: normal;
        }
        
        table.data-table tr.sub-row td:nth-child(2) {
            padding-left: 30px;
        }

        /* Highlight row */
        table.data-table tr.highlight-row {
            background: #e8f5e9;
        }

        /* Keterangan dalam tabel */
        .detail-text {
            font-size: 9px;
            line-height: 1.5;
        }

        .detail-text ul {
            margin: 3px 0 3px 15px;
            padding: 0;
        }

        .detail-text li {
            margin-bottom: 2px;
        }

        .detail-header {
            font-weight: bold;
            margin-top: 5px;
            margin-bottom: 3px;
        }

        /* Kehadiran Section */
        .attendance-wrapper {
            border: 2px solid #000;
            margin-bottom: 20px;
        }

        .attendance-title {
            background: #c8e6c9;
            padding: 8px 10px;
            font-weight: bold;
            border-bottom: 1px solid #000;
        }

        .attendance-table {
            width: 100%;
            border-collapse: collapse;
        }

        .attendance-table td {
            padding: 8px 10px;
            font-size: 10px;
            border: 1px solid #000;
        }

        /* Kesantrian Table */
        .kesantrian-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
        }

        .kesantrian-table th {
            background: #2d5016;
            color: white;
            padding: 8px;
            border: 1px solid #000;
            font-weight: bold;
        }

        .kesantrian-table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 10px;
        }

        .kesantrian-table tr.section-row td {
            background: #c8e6c9;
            font-weight: bold;
            border-bottom: 2px solid #000;
        }

        .kesantrian-table tr.sub-item td:first-child {
            padding-left: 30px;
        }

        /* Signature Section */
        .signature-wrapper {
            margin-top: 30px;
            display: table;
            width: 100%;
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

        /* Page break untuk bulk print */
        @media print {
            .page-break {
                page-break-after: always;
                page-break-inside: avoid;
            }
            
            body {
                page-break-inside: avoid;
            }
        }

        @page {
            margin: 20px;
        }
    </style>
</head>

<body>
    <!-- HEADER dengan Logo -->
    <div class="header-section">
        <div class="logo-container">
            @php
                $logoPath = public_path('images/logo-pesantren.png');
            @endphp
            @if(file_exists($logoPath))
                <img src="{{ $logoPath }}" alt="Logo Pesantren" class="header-logo">
            @endif
        </div>
        <div class="header-title">
            <h2>LAPORAN PENILAIAN AKHIR TAHUN</h2>
            <h3>PONDOK PESANTREN TAHFIZHUL QUR'AN BILAL BIN RABAH</h3>
            <h4>SUKOHARJO</h4>
        </div>
    </div>

    <!-- IDENTITAS SANTRI -->
    <div class="identity-section">
        <table class="identity-table">
            <tr>
                <td>
                    <span class="identity-label">Nama</span>: {{ $santri->nama ?? '-' }}
                </td>
                <td>
                    <span class="identity-label">Kelas / Semester</span>: {{ $santri->kelas ?? '-' }} / {{ $santri->tahunAjaran->semester ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="identity-label">No. Induk</span>: {{ $santri->nis ?? '-' }}
                </td>
                <td>
                    <span class="identity-label">Tahun Pelajaran</span>: {{ $santri->tahunAjaran->tahun ?? '-' }}
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
            <!-- 1. Al-Qur'an (PARENT - TANPA NILAI) -->
            <tr>
                <td class="no-cell">1</td>
                <td class="subject-cell">Al-Qur'an</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td></td>
            </tr>

            <!-- a. Tahfizh (SUB-ITEM) -->
            <tr class="sub-row">
                <td></td>
                <td style="padding-left: 30px;">a. Tahfizh</td>

                {{-- Nilai Angka Tahfidz --}}
                <td class="text-center">
                    {{ $nilaiTahfidz ?? '-' }}
                </td>

                {{-- Nilai Huruf Tahfidz --}}
                <td class="text-center">
                    {{ $nilaiHurufTahfidz ?? '-' }}
                </td>

                {{-- Keterangan Tahfidz --}}
                <td>
                    <div class="detail-text">
                        {{-- Target & Pencapaian --}}
                        <div class="detail-header">Target Hafalan:</div>
                        <b>{{ $targetJuz ?? 0 }} Juz</b><br>

                        <div class="detail-header">Jumlah Hafalan yang Diujikan:</div>
                        <b>{{ $totalJuzDiuji ?? 0 }} Juz 
                        @if(!empty($daftarJuzDiuji))
                            ({{ $daftarJuzDiuji }})
                        @endif
                        </b><br>

                        <div class="detail-header">Total Kesalahan:</div>
                        <b>{{ $totalKesalahan ?? 0 }}</b><br>

                        {{-- Setoran --}}
                        <div class="detail-header" style="margin-top: 8px;">Setoran:</div>
                        <ul>
                            @forelse($santri->setoran as $s)
                                <li>
                                    {{ \Carbon\Carbon::parse($s->tanggal_setoran)->format('d F Y') }}
                                    (Hal. {{ $s->halaman_awal }}–{{ $s->halaman_akhir }})
                                </li>
                            @empty
                                <li>Belum ada setoran</li>
                            @endforelse
                        </ul>

                        <div class="detail-header">Daftar Halaman:</div>
                        <b>{{ $daftarHalaman ?: '-' }}</b><br>

                        <div class="detail-header">Total Halaman:</div>
                        <b>{{ $totalHalaman ?? 0 }} Halaman</b><br>

                        <div class="detail-header">Juz yang Disetorkan:</div>
                        <b>{{ $daftarJuz ?: '-' }}</b>
                    </div>
                </td>
            </tr>

            <!-- b. Tahsin (SUB-ITEM - NILAI DARI AKADEMIK) -->
            <tr class="sub-row">
                <td></td>
                <td style="padding-left: 30px;">b. Tahsin</td>
                
                {{-- Nilai Angka Tahsin dari Nilai Akademik --}}
                <td class="text-center">
                    @php
                        // Cari nilai tahsin dari nilaiAkademik
                        $nilaiTahsin = $santri->nilaiAkademik->first(function($nilai) {
                            return stripos($nilai->mataPelajaran->nama_matapelajaran ?? '', 'tahsin') !== false;
                        });
                    @endphp
                    {{ $nilaiTahsin->nilai_rata_rata ?? '-' }}
                </td>
                
                {{-- Nilai Huruf Tahsin dari Nilai Akademik --}}
                <td class="text-center">
                    {{ $nilaiTahsin->predikat ?? '-' }}
                </td>
                
                {{-- Keterangan Tahsin --}}
                <td>
                    <div class="detail-text">
                        @if($nilaiTahsin && $nilaiTahsin->keterangan)
                            {!! nl2br(e($nilaiTahsin->keterangan)) !!}
                        @else
                            -
                        @endif
                    </div>
                </td>
            </tr>

            <!-- 2. Dirasah Islamiyah (PARENT - TANPA NILAI) -->
            <tr class="highlight-row">
                <td class="no-cell">2</td>
                <td class="subject-cell" colspan="4">Dirasah Islamiyah</td>
            </tr>

            <!-- Sub-item Dirasah Islamiyah -->
            @forelse ($santri->nilaiAkademik as $index => $a)
                <tr class="sub-row">
                    <td></td>
                    <td style="padding-left: 30px;">
                        {{ chr(97 + $index) }}. {{ $a->mataPelajaran->nama_matapelajaran ?? '-' }}
                    </td>
                    <td class="text-center">{{ $a->nilai_rata_rata ?? '-' }}</td>
                    <td class="text-center">{{ $a->predikat ?? '-' }}</td>
                    <td>
                        <div class="detail-text">
                            @if($a->keterangan)
                                {!! nl2br(e($a->keterangan)) !!}
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
    <div class="section-title">Ketidakhadiran (Dirasah)</div>
    <div class="attendance-wrapper">
        <div class="attendance-title">Ketidakhadiran (Dirasah)</div>
        <table class="attendance-table">
            <tr>
                <td style="width: 20%;">1. Sakit</td>
                <td style="width: 5%; text-align: center;">:</td>
                <td style="width: 15%; text-align: center; font-weight: bold;">
                    {{ $santri->nilaiAkademik->sum('jumlah_sakit') }}
                </td>
                <td style="width: 60%;">Hari</td>
            </tr>
            <tr>
                <td>2. Izin</td>
                <td style="text-align: center;">:</td>
                <td style="text-align: center; font-weight: bold;">
                    {{ $santri->nilaiAkademik->sum('jumlah_izin') }}
                </td>
                <td>Hari</td>
            </tr>
            <tr>
                <td>3. Ghaib</td>
                <td style="text-align: center;">:</td>
                <td style="text-align: center; font-weight: bold;">
                    {{ $santri->nilaiAkademik->sum('jumlah_ghaib') }}
                </td>
                <td>Hari</td>
            </tr>
        </table>
    </div>

    <!-- BAGIAN B: KESANTRIAN -->
    <div class="section-title">B. KESANTRIAN</div>

    <table class="kesantrian-table">
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th style="width:35%">Mata Pelajaran</th>
                <th style="width:12%">Nilai</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr class="section-row" style="border-top: 3px solid #000;">
                <td style="width:5%">1</td>
                <td style="width:35%"><b>Penilaian Akhlak Santri</b></td>
                <td style="width:12%"></td>
                <td></td>
            </tr>

            {{-- BAGIAN NILAI KESANTRIAN --}}
            @if($nilaiKesantrian && $nilaiKesantrian->count() > 0)
                @foreach($nilaiKesantrian as $index => $item)
                    <tr class="sub-item">
                        <td></td>
                        <td>{{ chr(97 + $index) }}. {{ $item['aspek'] ?? '-' }}</td>
                        <td style="text-align: center; font-weight: bold;">{{ $item['nilai'] ?? '-' }}</td>
                        <td>{{ $item['keterangan'] ?? '-' }}</td>
                    </tr>
                @endforeach
            @else
                <tr class="sub-item">
                    <td></td>
                    <td>a. Ibadah</td>
                    <td style="text-align: center; font-weight: bold;">-</td>
                    <td>-</td>
                </tr>
                <tr class="sub-item">
                    <td></td>
                    <td>b. Akhlak</td>
                    <td style="text-align: center; font-weight: bold;">-</td>
                    <td>-</td>
                </tr>
                <tr class="sub-item">
                    <td></td>
                    <td>c. Kerapian</td>
                    <td style="text-align: center; font-weight: bold;">-</td>
                    <td>-</td>
                </tr>
                <tr class="sub-item">
                    <td></td>
                    <td>d. Kedisiplinan</td>
                    <td style="text-align: center; font-weight: bold;">-</td>
                    <td>-</td>
                </tr>
            @endif
     
            <tr class="section-row">
                <td>2</td>
                <td><b>Ekstrakurikuler</b></td>
                <td style="text-align: center; font-weight: bold;">
                    @if($nilaiKesantrian && $nilaiKesantrian->count() > 0)
                        {{ $santri->nilaiKesantrian->first()->nilai_ekstrakulikuler ?? '-' }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($nilaiKesantrian && $nilaiKesantrian->count() > 0)
                        @php
                            $nilaiEkskul = $santri->nilaiKesantrian->first()->nilai_ekstrakulikuler ?? null;
                        @endphp
                        @if($nilaiEkskul)
                            @php
                                $nilaiEkskulUpper = strtoupper(trim($nilaiEkskul));
                                $keteranganEkskul = [
                                    'A' => 'Mumtaz',
                                    'B' => 'Jayyid Jiddan',
                                    'C' => 'Jayyid',
                                    'D' => 'Maqbul',
                                    'E' => 'Rasib',
                                ][$nilaiEkskulUpper] ?? $nilaiEkskul;
                            @endphp
                            {{ $keteranganEkskul }}
                        @else
                            -
                        @endif
                    @else
                        -
                    @endif
                </td>
            </tr>

            <tr class="section-row">
                <td>3</td>
                <td><b>Buku Pegangan</b></td>
                <td style="text-align: center; font-weight: bold;">
                    @if($nilaiKesantrian && $nilaiKesantrian->count() > 0)
                        {{ $santri->nilaiKesantrian->first()->nilai_buku_pegangan ?? '-' }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($nilaiKesantrian && $nilaiKesantrian->count() > 0)
                        @php
                            $nilaiBukuPegangan = $santri->nilaiKesantrian->first()->nilai_buku_pegangan ?? null;
                        @endphp
                        @if($nilaiBukuPegangan)
                            @php
                                $nilaiBukuUpper = strtoupper(trim($nilaiBukuPegangan));
                                $keteranganBuku = [
                                    'A' => 'Sangat memahami dengan baik buku pegangan santri',
                                    'B' => 'Memahami dengan baik buku pegangan santri',
                                    'C' => 'Cukup memahami buku pegangan santri',
                                    'D' => 'Kurang memahami buku pegangan santri',
                                    'E' => 'Tidak memahami buku pegangan santri',
                                ][$nilaiBukuUpper] ?? 'Memahami buku pegangan santri';
                            @endphp
                            {{ $keteranganBuku }}
                        @else
                            -
                        @endif
                    @else
                        -
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <!-- TANDA TANGAN -->
    <div class="signature-wrapper">
        <div class="signature-left">
            @php
                $stempelPath = public_path('images/stempel-pesantren.png');
            @endphp
            @if(file_exists($stempelPath))
                <img src="{{ $stempelPath }}" alt="Logo & Stempel" class="logo-stamp">
            @endif
            <div style="margin-top: 10px; font-size: 10px;">
                <b>Direktur Pesantren</b><br><br><br><br>
                <u><b>Marwanto Abdussalam, Lc</b></u>
            </div>
        </div>
        <div class="signature-right">
            <div class="signature-content">
                <div class="signature-place">
                    Diberikan di &nbsp;&nbsp;&nbsp;: <b>Sukoharjo</b>
                </div>
                <div class="signature-place">
                    Pada &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <b>{{ now()->format('d F Y') }}</b>
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