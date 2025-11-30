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
            margin-bottom: 0;
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

        /* Sub rows untuk Tahfizh/Tahsin */
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
            <!-- Al-Qur'an Section -->
            <tr>
                <td class="no-cell">1</td>
                <td class="subject-cell">Al-Qur'an</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td></td>
            </tr>

            @forelse ($santri->ujianTahfidz as $index => $t)
                <tr class="sub-row">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td style="padding-left: 30px;">
                        {{ $index == 0 ? 'a. Tahfizh' : 'b. Tahsin' }}
                    </td>

                    {{-- Nilai Angka --}}
                    <td class="text-center">{{ $t->nilai_angka ?? '-' }}</td>

                    {{-- Nilai Huruf --}}
                    <td class="text-center">
                        @php
                            $kesalahan = $t->total_kesalahan ?? 999;
                            if($kesalahan <= 5) echo 'A';
                            elseif($kesalahan <= 10) echo 'B';
                            else echo 'C';
                        @endphp
                    </td>

                    {{-- Keterangan --}}
                    <td>
                        <div class="detail-text">
                            {{-- === IF TAHFIZH === --}}
                            @if($index == 0)
                                {{-- Tanggal Setoran --}}
                                <div class="detail-header">Setoran:</div>
                                <ul style="margin: 3px 0 3px 15px; padding:0;">
                                    @forelse($santri->setoran as $s)
                                        <li>
                                            {{ \Carbon\Carbon::parse($s->tanggal_setoran)->format('d F Y') }}
                                            ({{ $s->halaman_awal }}–{{ $s->halaman_akhir }})
                                        </li>
                                    @empty
                                        <li>-</li>
                                    @endforelse
                                </ul>

                                {{-- Daftar Halaman --}}
                                <div class="detail-header">Daftar Halaman:</div>
                                <b>{{ $daftarHalaman ?: '-' }}</b><br>

                                {{-- Total Halaman --}}
                                <div class="detail-header">Total Halaman:</div>
                                <b>{{ $totalHalaman }} Halaman</b><br>

                                {{-- Juz yang Disetorkan --}}
                                <div class="detail-header">Juz yang Disetorkan:</div>
                                <b>{{ $daftarJuz ?: '-' }}</b><br>

                                {{-- Juz yang Diujikan --}}
                                <div class="detail-header">Jumlah Hafalan yang Diujikan:</div>
                                <b>Juz {{ $t->juz ?? '-' }}</b><br>

                                {{-- Sekali Duduk --}}
                                <div class="detail-header" style="margin-top: 8px;">Sekali Duduk</div>
                                <b>{{ ucfirst($t->sekali_duduk ?? '-') }}</b>
                            @else
                                {{-- === IF TAHSIN === --}}
                                Materi yang dipelajari:
                                <ul style="margin-top: 3px;">
                                    <li>Pengenalan Ilmu Tajwid</li>
                                    <li>Makhorijul Huruf</li>
                                </ul>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                {{-- Jika belum ada ujian --}}
                <tr class="sub-row">
                    <td class="text-center">1</td>
                    <td style="padding-left: 30px;">a. Tahfizh</td>
                    <td class="text-center">-</td>
                    <td class="text-center">-</td>
                    <td><i>Belum ada data ujian tahfizh</i></td>
                </tr>

                <tr class="sub-row">
                    <td class="text-center">2</td>
                    <td style="padding-left: 30px;">b. Tahsin</td>
                    <td class="text-center">-</td>
                    <td class="text-center">-</td>
                    <td><i>Belum ada data ujian tahsin</i></td>
                </tr>
            @endforelse

            <!-- Dirasah Islamiyah Section -->
            <tr class="highlight-row">
                <td class="no-cell">2</td>
                <td class="subject-cell" colspan="4">Dirasah Islamiyah</td>
            </tr>

            @forelse ($santri->nilaiAkademik as $index => $a)
                <tr class="sub-row">
                    <td class="text-center">{{ $index + 1 }}</td>
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
                    <td class="text-center">1</td>
                    <td style="padding-left: 30px;">a. Bahasa Arab<br>(Al-Arabiyyah Baina Yadaik)</td>
                    <td class="text-center">72</td>
                    <td class="text-center">C</td>
                    <td>
                        <div class="detail-text">
                            <ul>
                                <li>Bab Perkenalan</li>
                                <li>Bab Keluarga</li>
                                <li>Bab Tempat Tinggal</li>
                                <li>Bab Kehidupan Sehari-hari</li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr class="sub-row">
                    <td class="text-center">2</td>
                    <td style="padding-left: 30px;">b. Adab<br>(Ta'lim Muta'alim)</td>
                    <td class="text-center">82</td>
                    <td class="text-center">B</td>
                    <td>
                        <div class="detail-text">
                            <ul>
                                <li>Giat, rajin, dan semangat</li>
                                <li>Memulai belajar, ukuran, dan pentingnya berkesinambungan</li>
                                <li>Bertanwakal</li>
                                <li>Masa belajar</li>
                            </ul>
                        </div>
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
            <tr class="section-row">
                <td>1</td>
                <td><b>Penilaian Akhlak Santri</b></td>
                <td></td>
                <td></td>
            </tr>

            @if(isset($nilaiKesantrian) && $nilaiKesantrian->count() > 0)
                @foreach($nilaiKesantrian as $index => $item)
                    <tr class="sub-item">
                        <td></td>
                        <td>{{ chr(97 + $index) }}. {{ $item->aspek ?? '-' }}</td>
                        <td style="text-align: center; font-weight: bold;">{{ $item->nilai ?? '-' }}</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
            @else
                <tr class="sub-item">
                    <td></td>
                    <td>a. Ibadah</td>
                    <td style="text-align: center; font-weight: bold;">C</td>
                    <td>Jayyid</td>
                </tr>
                <tr class="sub-item">
                    <td></td>
                    <td>b. Akhlak</td>
                    <td style="text-align: center; font-weight: bold;">B</td>
                    <td>Jayyid Jiddan</td>
                </tr>
                <tr class="sub-item">
                    <td></td>
                    <td>c. Kerapian</td>
                    <td style="text-align: center; font-weight: bold;">B</td>
                    <td>Jayyid Jiddan</td>
                </tr>
                <tr class="sub-item">
                    <td></td>
                    <td>d. Kedisiplinan</td>
                    <td style="text-align: center; font-weight: bold;">C</td>
                    <td>Jayyid</td>
                </tr>
            @endif

            <tr class="section-row">
                <td>2</td>
                <td><b>Ekstrakulikuler</b></td>
                <td style="text-align: center; font-weight: bold;">B</td>
                <td>Jayyid Jiddan</td>
            </tr>

            <tr class="section-row">
                <td>3</td>
                <td><b>Buku Pegangan</b></td>
                <td style="text-align: center; font-weight: bold;">C+</td>
                <td>Kurang memahami dengan baik buku pegangan santri</td>
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