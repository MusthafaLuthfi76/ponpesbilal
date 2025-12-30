@extends('layouts.app')

@section('page_title', 'Input Nilai Kesantrian')

{{-- Bootstrap & Font Awesome --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>
    :root {
        --primary-color: #28a745;
        --secondary-color: #ffc107;
        --delete-color: #dc3545;
        --border-color: #dee2e6;
        --text-color: #212529;
        --bg-light: #f8f9fa;
        --uts-color: #0d6efd;
        --uas-color: #6f42c1;
        --grade-a: #28a745;
        --grade-b: #ffc107;
        --grade-c: #dc3545;
        --grade-d: #0d6efd;
        --grade-e: #6c757d;
    }

    body {
        background-color: #e8f5e9;
    }

    .container-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px 15px;
    }

    .page-header {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px 25px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .page-header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .page-header h4 {
        margin: 0;
        color: var(--primary-color);
        font-weight: 600;
    }

    .back-btn,
    .assign-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
        padding: 8px 16px;
        border: 1px solid var(--primary-color);
        border-radius: 5px;
        background: white;
    }

    .back-btn:hover,
    .assign-btn:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .assign-btn {
        background-color: var(--primary-color);
        color: white;
    }

    .assign-btn:hover {
        background-color: #1e7e34;
    }

    .mapel-info-card {
        background: linear-gradient(135deg, var(--primary-color) 0%, #1e7e34 100%);
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 20px;
        color: white;
    }

    .mapel-info-header {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .mapel-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .mapel-details h5 {
        margin: 0 0 5px 0;
        font-weight: 600;
        font-size: 22px;
        line-height: 1.2;
    }

    .mapel-details p {
        margin: 0;
        opacity: 0.9;
        font-size: 14px;
    }

    /* Tabs Navigation */
    .nav-tabs {
        border-bottom: 2px solid var(--border-color);
        background: white;
        border-radius: 8px 8px 0 0;
        padding: 10px 15px 0;
        margin-bottom: 0;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #666;
        font-weight: 500;
        padding: 12px 20px;
        border-radius: 8px 8px 0 0;
        transition: all 0.2s;
    }

    .nav-tabs .nav-link:hover {
        background-color: #f8fff9;
        color: var(--primary-color);
    }

    .nav-tabs .nav-link.active {
        background-color: white;
        color: var(--primary-color);
        border-bottom: 3px solid var(--primary-color);
        font-weight: 600;
    }

    /* Tab Content */
    .tab-content {
        background: white;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 0;
    }

    /* Periode Banner */
    .periode-banner {
        background: linear-gradient(135deg, var(--uts-color) 0%, #0b5ed7 100%);
        color: white;
        padding: 15px 20px;
        margin: 15px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .periode-banner.uas-banner {
        background: linear-gradient(135deg, var(--uas-color) 0%, #5a32a3 100%);
    }

    .periode-banner i {
        font-size: 1.8rem;
    }

    .periode-banner h5 {
        margin: 0;
        font-weight: 600;
    }

    .periode-banner p {
        margin: 5px 0 0 0;
        opacity: 0.9;
        font-size: 14px;
    }

    /* Sub Pills Navigation */
    .nav-pills {
        padding: 15px 15px 0;
        gap: 8px;
        background-color: var(--bg-light);
        border-bottom: 1px solid var(--border-color);
    }

    .nav-pills .nav-link {
        color: var(--primary-color);
        font-weight: 500;
        border-radius: 20px;
        padding: 8px 16px;
        transition: all 0.2s;
        border: 1px solid transparent;
    }

    .nav-pills .nav-link:hover {
        background-color: #e8f5e9;
        border-color: var(--primary-color);
    }

    .nav-pills .nav-link.active {
        background-color: var(--primary-color);
        color: white;
    }

    /* Grade Legend */
    .grade-legend {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin: 10px 15px;
        padding: 10px;
        background-color: var(--bg-light);
        border-radius: 5px;
        border: 1px solid var(--border-color);
    }

    .grade-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 14px;
        font-weight: 500;
    }

    .grade-badge {
        width: 24px;
        height: 24px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 12px;
    }

    .grade-a-badge {
        background-color: var(--grade-a);
    }

    .grade-b-badge {
        background-color: var(--grade-b);
    }

    .grade-c-badge {
        background-color: var(--grade-c);
    }

    .grade-d-badge {
        background-color: var(--grade-d);
    }

    .grade-e-badge {
        background-color: var(--grade-e);
    }

    /* Table Styling */
    .table-responsive-nilai {
        max-height: 55vh;
        overflow-y: auto;
        border: 1px solid var(--border-color);
        margin: 15px;
        border-radius: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
    }

    thead th {
        background: linear-gradient(135deg, var(--primary-color) 0%, #1e7e34 100%);
        color: white !important;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 12px 15px;
        border-bottom: 2px solid var(--border-color);
        font-weight: 600;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    tbody td {
        padding: 12px 10px;
        border-bottom: 1px solid var(--border-color);
        text-align: center;
    }

    tbody tr:hover {
        background-color: #e6fff1;
        transition: .2s;
    }

    .nilai-input-kesantrian {
        width: 70px;
        padding: 10px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        text-align: center;
        text-transform: uppercase;
        font-weight: bold;
        font-size: 16px;
        background-color: white;
        cursor: pointer;
        transition: all 0.2s;
    }

    .nilai-input-kesantrian:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
        transform: scale(1.05);
    }

    /* Style untuk nilai A */
    .nilai-a {
        background-color: rgba(40, 167, 69, 0.1);
        color: var(--grade-a);
        border-color: var(--grade-a);
    }

    /* Style untuk nilai B */
    .nilai-b {
        background-color: rgba(255, 193, 7, 0.1);
        color: var(--grade-b);
        border-color: var(--grade-b);
    }

    /* Style untuk nilai C */
    .nilai-c {
        background-color: rgba(220, 53, 69, 0.1);
        color: var(--grade-c);
        border-color: var(--grade-c);
    }

    /* Style untuk nilai D */
    .nilai-d {
        background-color: rgba(13, 110, 253, 0.1);
        color: var(--grade-d);
        border-color: var(--grade-d);
    }

    /* Style untuk nilai E */
    .nilai-e {
        background-color: rgba(108, 117, 125, 0.1);
        color: var(--grade-e);
        border-color: var(--grade-e);
    }

    /* Placeholder style */
    .nilai-input-kesantrian::placeholder {
        color: #adb5bd;
        font-weight: normal;
        text-transform: none;
        font-size: 14px;
    }

    .uts-input {
        border-left: 4px solid var(--uts-color);
    }

    .uas-input {
        border-left: 4px solid var(--uas-color);
    }

    .action-btn {
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        color: #fff;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--delete-color);
    }

    .action-btn:hover {
        opacity: 0.85;
        transform: scale(1.05);
    }

    .save-btn-wrapper {
        padding: 15px 25px;
        display: flex;
        justify-content: flex-end;
        border-top: 1px solid var(--border-color);
        background-color: var(--bg-light);
    }

    .save-btn {
        background-color: var(--primary-color);
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .save-btn:hover {
        background-color: #1e7e34;
        transform: translateY(-1px);
    }

    .uts-btn {
        background-color: var(--uts-color);
    }

    .uts-btn:hover {
        background-color: #0b5ed7;
    }

    .uas-btn {
        background-color: var(--uas-color);
    }

    .uas-btn:hover {
        background-color: #5a32a3;
    }

    /* Assign Santri Section */
    .assign-section {
        padding: 20px;
    }

    .filter-section {
        background-color: var(--bg-light);
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .santri-assign-list {
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid var(--border-color);
        border-radius: 5px;
    }

    .santri-assign-item {
        padding: 12px 15px;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.2s;
        cursor: pointer;
    }

    .santri-assign-item:hover {
        background-color: #e8f5e9;
    }

    .santri-assign-item:last-child {
        border-bottom: none;
    }

    /* Nilai Guide */
    .nilai-guide {
        padding: 10px 15px;
        background-color: #f8f9fa;
        border-bottom: 1px solid var(--border-color);
        font-size: 12px;
        color: #6c757d;
        text-align: center;
    }

    .nilai-guide span {
        margin: 0 10px;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        body {
            background-color: #f5f5f5;
        }

        .container-wrapper {
            padding: 0 0 80px 0;
        }

        .page-header {
            border-radius: 0;
            flex-direction: column;
            align-items: flex-start;
            padding: 15px;
            margin-bottom: 15px;
        }

        .page-header-left {
            margin-bottom: 10px;
            width: 100%;
        }

        .page-header h4 {
            font-size: 18px;
        }

        .back-btn {
            width: 100%;
            justify-content: center;
        }

        .mapel-info-card {
            border-radius: 0;
            padding: 20px 15px;
            margin-bottom: 15px;
        }

        .mapel-icon {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }

        .mapel-details h5 {
            font-size: 18px;
        }

        .nav-tabs {
            border-radius: 0;
            padding: 8px 10px 0;
        }

        .nav-tabs .nav-link {
            font-size: 13px;
            padding: 8px 12px;
        }

        .tab-content {
            border-radius: 0;
        }

        .periode-banner {
            margin: 10px;
            padding: 12px 15px;
        }

        .periode-banner i {
            font-size: 1.5rem;
        }

        .nav-pills {
            padding: 10px;
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        .nav-pills .nav-link {
            font-size: 12px;
            padding: 6px 12px;
            white-space: nowrap;
        }

        .grade-legend {
            flex-wrap: wrap;
            gap: 10px;
            margin: 10px;
            padding: 8px;
        }

        .table-responsive-nilai {
            margin: 10px;
            max-height: 50vh;
        }

        thead th {
            font-size: 10px;
            padding: 8px 4px;
        }

        tbody td {
            padding: 8px 4px;
            font-size: 12px;
        }

        .nilai-input-kesantrian {
            width: 50px;
            font-size: 14px;
            padding: 6px;
        }

        .action-btn {
            width: 32px;
            height: 32px;
        }

        .save-btn {
            position: fixed;
            bottom: 12px;
            right: 12px;
            z-index: 200;
            border-radius: 30px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            padding: 12px 20px;
        }

        .assign-section {
            padding: 15px;
        }
    }
</style>

@section('content')

    <div class="container-wrapper">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-left">
                <h4>
                    <i class="fas fa-edit"></i> Input Nilai Kesantrian
                </h4>
            </div>
            <div>
                <a href="#assignSantri" class="assign-btn" data-bs-toggle="tab" role="tab">
                    <i class="fas fa-user-plus"></i> Tambah Santri
                </a>
                <a href="{{ route('nilaikesantrian.index', ['id_tahunAjaran' => $tahunAjaran->id_tahunAjaran]) }}"
                    class="back-btn">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Info Card -->
        <div class="mapel-info-card">
            <div class="mapel-info-header">
                <div class="mapel-icon">
                    <i class="fas fa-mosque"></i>
                </div>
                <div class="mapel-details">
                    <h5>Kesantrian</h5>
                    <p><i class="fas fa-calendar-alt me-2"></i>Tahun Ajaran: {{ $tahunAjaran->tahun }} - Semester
                        {{ strtoupper($tahunAjaran->semester) }}</p>
                </div>
            </div>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success mx-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger mx-3">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger mx-3">
                <h6>Terdapat Kesalahan Input:</h6>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Tabs Navigasi Utama --}}
        <ul class="nav nav-tabs" id="nilaiTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'uts' ? 'active' : '' }}" id="uts-tab" data-bs-toggle="tab"
                    href="#utsNilai" role="tab">
                    <i class="bi bi-file-earmark-text"></i> Input Nilai UTS
                    <span class="badge bg-primary">{{ $nilaiSantri->count() }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'uas' ? 'active' : '' }}" id="uas-tab" data-bs-toggle="tab"
                    href="#uasNilai" role="tab">
                    <i class="bi bi-file-earmark-text-fill"></i> Input Nilai UAS
                    <span class="badge bg-purple">{{ $nilaiSantri->count() }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'assign' ? 'active' : '' }}" id="assign-tab" data-bs-toggle="tab"
                    href="#assignSantri" role="tab">
                    <i class="bi bi-person-plus"></i> Tambah Santri
                    <span class="badge bg-success">{{ $santriBelumAssign->count() }}</span>
                </a>
            </li>
        </ul>

        <div class="tab-content">

            {{-- TAB 1: INPUT NILAI UTS --}}
            <div class="tab-pane fade {{ $activeTab == 'uts' ? 'show active' : '' }}" id="utsNilai" role="tabpanel">
                @if ($nilaiSantri->isEmpty())
                    <div class="alert alert-warning m-3">
                        Belum ada santri yang di tambah untuk penilaian kesantrian ini. Silakan pindah ke tab "Tambah Santri".
                    </div>
                @else
                    <form action="{{ route('nilaikesantrian.update.massal') }}" method="POST">
                        @csrf
                        <input type="hidden" name="periode" value="uts">

                        <div class="periode-banner">
                            <i class="bi bi-file-earmark-text"></i>
                            <div>
                                <h5>Input Nilai UTS</h5>
                                <p>Silakan input nilai untuk setiap komponen kesantrian</p>
                            </div>
                        </div>

                        {{-- Legend Nilai --}}
                        <div class="grade-legend">
                            <div class="grade-item">
                                <span class="grade-badge grade-a-badge">A</span>
                                <span>Mumtaz</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-badge grade-b-badge">B</span>
                                <span>Jayyid Jiddan</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-badge grade-c-badge">C</span>
                                <span>Jayyid</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-badge grade-d-badge">D</span>
                                <span>Maqbul</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-badge grade-e-badge">E</span>
                                <span>Dha'if</span>
                            </div>
                        </div>

                        {{-- Nilai Guide --}}
                        <div class="nilai-guide">
                            <strong>Petunjuk:</strong> Masukkan nilai <span class="text-success"><strong>A,
                                    A-</strong></span>,
                            <span class="text-warning"><strong>B+, B, B-</strong></span>,
                            <span class="text-danger"><strong>C+, C, C-</strong></span>,
                            <span class="text-primary"><strong>D</strong></span>, atau
                            <span class="text-secondary"><strong>E</strong></span>
                        </div>

                        {{-- SUB-TAB NAVIGATION untuk komponen nilai --}}
                        <ul class="nav nav-pills nav-fill" id="utsNilaiTabs" role="tablist">
                            @php
                                $komponenNilai = [
                                    'akhlak' => ['icon' => 'bi-heart-fill', 'title' => 'Akhlak'],
                                    'ibadah' => ['icon' => 'bi-book', 'title' => 'Ibadah'],
                                    'kerapian' => ['icon' => 'bi-scissors', 'title' => 'Kerapian'],
                                    'kedisiplinan' => ['icon' => 'bi-clock', 'title' => 'Kedisiplinan'],
                                    'ekstrakulikuler' => ['icon' => 'bi-activity', 'title' => 'Ekstrakulikuler'],
                                    'buku_pegangan' => ['icon' => 'bi-journal-check', 'title' => 'Buku Pegangan'],
                                ];
                            @endphp

                            @foreach ($komponenNilai as $key => $komponen)
                                <li class="nav-item">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                        id="{{ $key }}-uts-tab" data-bs-toggle="pill"
                                        data-bs-target="#{{ $key }}-uts" type="button">
                                        <i class="bi {{ $komponen['icon'] }}"></i> {{ $komponen['title'] }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        {{-- SUB-TAB CONTENT untuk komponen nilai --}}
                        <div class="tab-content" id="utsNilaiTabsContent">
                            @foreach ($komponenNilai as $key => $komponen)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="{{ $key }}-uts" role="tabpanel">

                                    <div class="table-responsive-nilai">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20px;">#</th>
                                                    <th class="d-none d-md-table-cell" style="width: 75px;">NIS</th>
                                                    <th style="text-align: left;">Nama Santri</th>
                                                    <th style="width: 120px;">
                                                        Nilai {{ $komponen['title'] }}
                                                        <small class="d-block text-muted">(A/B/C/D/E)</small>
                                                    </th>
                                                    <th style="width: 50px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($nilaiSantri as $nilai)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td class="d-none d-md-table-cell">
                                                            <small>{{ $nilai->santri->nis ?? 'N/A' }}</small>
                                                        </td>
                                                        <td style="text-align: left;">
                                                            <strong>{{ $nilai->santri->nama ?? 'N/A' }}</strong>
                                                            <small class="text-muted d-block d-md-none">NIS:
                                                                {{ $nilai->santri->nis ?? 'N/A' }}</small>
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="nilai[{{ $nilai->id_nilai_kesantrian }}][{{ $key }}]"
                                                                value="{{ old('nilai.' . $nilai->id_nilai_kesantrian . '.' . $key, $nilai->{$key . '_uts'}) }}"
                                                                class="nilai-input-kesantrian uts-input nilai-input-{{ $nilai->id_nilai_kesantrian }}-{{ $key }}-uts"
                                                                data-id="{{ $nilai->id_nilai_kesantrian }}"
                                                                data-komponen="{{ $key }}" data-periode="uts"
                                                                maxlength="2" placeholder="A/B/C/D/E"
                                                                onkeyup="validateNilaiInput(this)"
                                                                onchange="updateNilaiStyle(this)">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="action-btn"
                                                                title="Un-assign Santri"
                                                                onclick="confirmDelete('{{ $nilai->santri->nama ?? $nilai->nis }}', '{{ $nilai->id_nilai_kesantrian }}')">
                                                                <i class="bi bi-x"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="save-btn-wrapper">
                            <button type="submit" class="save-btn uts-btn">
                                <i class="fas fa-save"></i> Simpan Semua Nilai UTS
                            </button>
                        </div>
                    </form>
                @endif
            </div>

            {{-- TAB 2: INPUT NILAI UAS --}}
            <div class="tab-pane fade {{ $activeTab == 'uas' ? 'show active' : '' }}" id="uasNilai" role="tabpanel">
                @if ($nilaiSantri->isEmpty())
                    <div class="alert alert-warning m-3">
                        Belum ada santri yang di tambah untuk penilaian kesantrian ini. Silakan pindah ke tab "Tambah Santri".
                    </div>
                @else
                    <form action="{{ route('nilaikesantrian.update.massal') }}" method="POST">
                        @csrf
                        <input type="hidden" name="periode" value="uas">

                        <div class="periode-banner uas-banner">
                            <i class="bi bi-file-earmark-text-fill"></i>
                            <div>
                                <h5>Input Nilai UAS</h5>
                                <p>Silakan input nilai untuk setiap komponen kesantrian</p>
                            </div>
                        </div>

                        {{-- Legend Nilai --}}
                        <div class="grade-legend">
                            <div class="grade-item">
                                <span class="grade-badge grade-a-badge">A</span>
                                <span>Mumtaz</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-badge grade-b-badge">B</span>
                                <span>Jayyid Jiddan</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-badge grade-c-badge">C</span>
                                <span>Jayyid</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-badge grade-d-badge">D</span>
                                <span>Maqbul</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-badge grade-e-badge">E</span>
                                <span>Dha'if</span>
                            </div>
                        </div>

                        {{-- Nilai Guide --}}
                        <div class="nilai-guide">
                            <strong>Petunjuk:</strong> Masukkan nilai <span class="text-success"><strong>A,
                                    A-</strong></span>,
                            <span class="text-warning"><strong>B+, B, B-</strong></span>,
                            <span class="text-danger"><strong>C+, C, C-</strong></span>,
                            <span class="text-primary"><strong>D</strong></span>, atau
                            <span class="text-secondary"><strong>E</strong></span>
                        </div>

                        {{-- SUB-TAB NAVIGATION untuk komponen nilai --}}
                        <ul class="nav nav-pills nav-fill" id="uasNilaiTabs" role="tablist">
                            @php
                                $komponenNilai = [
                                    'akhlak' => ['icon' => 'bi-heart-fill', 'title' => 'Akhlak'],
                                    'ibadah' => ['icon' => 'bi-book', 'title' => 'Ibadah'],
                                    'kerapian' => ['icon' => 'bi-scissors', 'title' => 'Kerapian'],
                                    'kedisiplinan' => ['icon' => 'bi-clock', 'title' => 'Kedisiplinan'],
                                    'ekstrakulikuler' => ['icon' => 'bi-activity', 'title' => 'Ekstrakulikuler'],
                                    'buku_pegangan' => ['icon' => 'bi-journal-check', 'title' => 'Buku Pegangan'],
                                ];
                            @endphp

                            @foreach ($komponenNilai as $key => $komponen)
                                <li class="nav-item">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                        id="{{ $key }}-uas-tab" data-bs-toggle="pill"
                                        data-bs-target="#{{ $key }}-uas" type="button">
                                        <i class="bi {{ $komponen['icon'] }}"></i> {{ $komponen['title'] }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        {{-- SUB-TAB CONTENT untuk komponen nilai --}}
                        <div class="tab-content" id="uasNilaiTabsContent">
                            @foreach ($komponenNilai as $key => $komponen)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="{{ $key }}-uas" role="tabpanel">

                                    <div class="table-responsive-nilai">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20px;">#</th>
                                                    <th class="d-none d-md-table-cell" style="width: 75px;">NIS</th>
                                                    <th style="text-align: left;">Nama Santri</th>
                                                    <th style="width: 120px;">
                                                        Nilai {{ $komponen['title'] }}
                                                        <small class="d-block text-muted">(A/B/C/D/E)</small>
                                                    </th>
                                                    <th style="width: 50px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($nilaiSantri as $nilai)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td class="d-none d-md-table-cell">
                                                            <small>{{ $nilai->santri->nis ?? 'N/A' }}</small>
                                                        </td>
                                                        <td style="text-align: left;">
                                                            <strong>{{ $nilai->santri->nama ?? 'N/A' }}</strong>
                                                            <small class="text-muted d-block d-md-none">NIS:
                                                                {{ $nilai->santri->nis ?? 'N/A' }}</small>
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="nilai[{{ $nilai->id_nilai_kesantrian }}][{{ $key }}]"
                                                                value="{{ old('nilai.' . $nilai->id_nilai_kesantrian . '.' . $key, $nilai->{$key . '_uas'}) }}"
                                                                class="nilai-input-kesantrian uas-input nilai-input-{{ $nilai->id_nilai_kesantrian }}-{{ $key }}-uas"
                                                                data-id="{{ $nilai->id_nilai_kesantrian }}"
                                                                data-komponen="{{ $key }}" data-periode="uas"
                                                                maxlength="2" placeholder="A/B/C/D/E"
                                                                onkeyup="validateNilaiInput(this)"
                                                                onchange="updateNilaiStyle(this)">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="action-btn"
                                                                title="Un-assign Santri"
                                                                onclick="confirmDelete('{{ $nilai->santri->nama ?? $nilai->nis }}', '{{ $nilai->id_nilai_kesantrian }}')">
                                                                <i class="bi bi-x"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="save-btn-wrapper">
                            <button type="submit" class="save-btn uas-btn">
                                <i class="fas fa-save"></i> Simpan Semua Nilai UAS
                            </button>
                        </div>
                    </form>
                @endif
            </div>

            {{-- TAB 3: ASSIGN SANTRI --}}
            <div class="tab-pane fade {{ $activeTab == 'assign' ? 'show active' : '' }}" id="assignSantri"
                role="tabpanel">
                <div class="assign-section">
                    <h5 class="mb-3"><i class="bi bi-person-plus"></i> Pilih Santri yang Belum Di Tambah</h5>

                    {{-- Form Filter --}}
                    <div class="filter-section">
                        <form method="GET"
                            action="{{ route('nilaikesantrian.show', [
                                'id_tahunAjaran' => $tahunAjaran->id_tahunAjaran,
                            ]) }}"
                            class="row g-2">
                            <input type="hidden" name="tab" value="assign">

                            <div class="col-md-3">
                                <label class="form-label">Angkatan:</label>
                                <select name="angkatan" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua</option>
                                    @foreach ($angkatanList as $angkatan)
                                        <option value="{{ $angkatan }}"
                                            {{ request('angkatan') == $angkatan ? 'selected' : '' }}>{{ $angkatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Cari Nama:</label>
                                <div class="input-group">
                                    <input type="text" name="search_nama" value="{{ request('search_nama') }}"
                                        class="form-control" placeholder="Cari nama santri...">
                                    <button type="submit" class="btn btn-outline-success">
                                        <i class="bi bi-search"></i> Cari
                                    </button>
                                </div>
                            </div>

                            @if (request('angkatan') || request('search_nama'))
                                <div class="col-md-3 d-flex align-items-end">
                                    <a href="{{ route('nilaikesantrian.show', [
                                        'id_tahunAjaran' => $tahunAjaran->id_tahunAjaran,
                                        'tab' => 'assign',
                                    ]) }}"
                                        class="btn btn-outline-danger w-100">
                                        <i class="bi bi-x-circle"></i> Reset
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>

                    {{-- Form Assign Santri --}}
                    <form
                        action="{{ route('nilaikesantrian.assign.store', [
                            'id_tahunAjaran' => $tahunAjaran->id_tahunAjaran,
                        ]) }}"
                        method="POST">
                        @csrf

                        <div class="santri-assign-list">
                            @forelse($santriBelumAssign as $santri)
                                <label class="santri-assign-item d-flex align-items-center"
                                    for="santri-{{ $santri->nis }}">
                                    <input class="form-check-input me-3" type="checkbox" name="nis[]"
                                        value="{{ $santri->nis }}" id="santri-{{ $santri->nis }}">
                                    <div class="flex-grow-1">
                                        <strong class="text-success">{{ $santri->nama }}</strong>
                                        <small class="text-muted d-block">NIS: {{ $santri->nis }} • Angkatan:
                                            {{ $santri->angkatan }}</small>
                                    </div>
                                </label>
                            @empty
                                <div class="alert alert-success m-3">
                                    <i class="bi bi-check-circle"></i> Semua santri sudah di-assign ke penilaian kesantrian ini.
                                </div>
                            @endforelse
                        </div>

                        @if ($santriBelumAssign->isNotEmpty())
                            <button type="submit" class="btn btn-success mt-3 w-100">
                                <i class="bi bi-plus-circle"></i> Tambah Santri Terpilih
                                ({{ $santriBelumAssign->count() }})
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- HIDDEN FORM UNTUK DELETE (UN-ASSIGN) SANTRI --}}
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function validateNilaiInput(input) {
            // Mengonversi input ke huruf besar
            input.value = input.value.toUpperCase();

            // Pola validasi yang lebih fleksibel untuk nilai kesantrian
            // Format yang valid: A, A-, A+, B, B-, B+, C, C-, C+, D, E
            // Juga menerima input kosong
            const nilai = input.value;

            // Cek jika input tidak kosong
            if (nilai !== '') {
                // Validasi pola
                if (!/^[A-E][+-]?$/.test(nilai)) {
                    // Jika tidak valid, reset ke nilai sebelumnya yang valid
                    // Atau hapus karakter yang tidak valid
                    const validNilai = nilai.match(/^[A-E][+-]?/);
                    if (validNilai) {
                        input.value = validNilai[0];
                    } else {
                        // Jika hanya karakter pertama yang valid (A-E), pertahankan
                        if (/^[A-E]$/.test(nilai.charAt(0))) {
                            input.value = nilai.charAt(0);
                        } else {
                            // Jika tidak valid sama sekali, kosongkan
                            input.value = '';
                        }
                    }
                }
            }

            // Update style berdasarkan nilai
            updateNilaiStyle(input);
            return true;
        }

        function updateNilaiStyle(input) {
            // Hapus semua kelas nilai sebelumnya
            input.classList.remove('nilai-a', 'nilai-b', 'nilai-c', 'nilai-d', 'nilai-e');

            // Ambil nilai dan ambil hanya huruf pertama untuk menentukan kategori
            const nilai = input.value.toUpperCase();
            const kategori = nilai.charAt(0);

            // Tambahkan kelas sesuai kategori nilai
            if (kategori === 'A') {
                input.classList.add('nilai-a');
            } else if (kategori === 'B') {
                input.classList.add('nilai-b');
            } else if (kategori === 'C') {
                input.classList.add('nilai-c');
            } else if (kategori === 'D') {
                input.classList.add('nilai-d');
            } else if (kategori === 'E') {
                input.classList.add('nilai-e');
            }
        }

        function confirmDelete(nama, id_nilai_kesantrian) {
            if (confirm(`Yakin ingin MENGHAPUS (Un-assign) santri atas nama ${nama} dari penilaian kesantrian ini?`)) {
                const form = document.getElementById('delete-form');
                form.action = `/nilai-kesantrian/unassign/${id_nilai_kesantrian}`;
                form.submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);

            // Handle tab utama switching based on URL parameter
            const tabParam = urlParams.get('tab');
            if (tabParam) {
                const tabEl = document.getElementById(`${tabParam}-tab`);
                if (tabEl) {
                    const tab = new bootstrap.Tab(tabEl);
                    tab.show();
                }
            }

            // Force Assign Santri tab to open when the header button is clicked
            document.querySelectorAll('.assign-btn[data-bs-toggle="tab"]').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    const assignTabEl = document.getElementById('assign-tab');
                    if (assignTabEl) {
                        const assignTab = new bootstrap.Tab(assignTabEl);
                        assignTab.show();
                    }

                    const newUrl = new URL(window.location.href);
                    newUrl.searchParams.set('tab', 'assign');
                    window.history.pushState({ path: newUrl.href }, '', newUrl.href);

                    const assignPane = document.querySelector('#assignSantri');
                    if (assignPane) {
                        assignPane.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            // Update URL when main tab changes
            const tabTriggers = document.querySelectorAll('#nilaiTabs a[data-bs-toggle="tab"]');
            tabTriggers.forEach(function(trigger) {
                trigger.addEventListener('shown.bs.tab', function(event) {
                    const newUrl = new URL(window.location.href);
                    const tabId = event.target.getAttribute('id').replace('-tab', '');

                    if (tabId) {
                        newUrl.searchParams.set('tab', tabId);
                    } else {
                        newUrl.searchParams.delete('tab');
                    }

                    window.history.pushState({
                        path: newUrl.href
                    }, '', newUrl.href);
                });
            });

            // Handle sub-tabs untuk UTS
            const activeSubTabUts = urlParams.get('sub_tab_uts');
            if (activeSubTabUts) {
                const subTabEl = document.getElementById(activeSubTabUts + '-uts-tab');
                if (subTabEl) {
                    const subTab = new bootstrap.Tab(subTabEl);
                    subTab.show();
                }
            }

            // Handle sub-tabs untuk UAS
            const activeSubTabUas = urlParams.get('sub_tab_uas');
            if (activeSubTabUas) {
                const subTabEl = document.getElementById(activeSubTabUas + '-uas-tab');
                if (subTabEl) {
                    const subTab = new bootstrap.Tab(subTabEl);
                    subTab.show();
                }
            }

            // Update URL when sub-tab changes for UTS
            const utsSubTabTriggers = document.querySelectorAll('#utsNilaiTabs button[data-bs-toggle="pill"]');
            utsSubTabTriggers.forEach(function(trigger) {
                trigger.addEventListener('shown.bs.tab', function(event) {
                    const newUrl = new URL(window.location.href);
                    const tabId = event.target.getAttribute('id').replace('-uts-tab', '');

                    newUrl.searchParams.set('sub_tab_uts', tabId);
                    newUrl.searchParams.delete('sub_tab_uas');
                    newUrl.searchParams.set('tab', 'uts');

                    window.history.pushState({
                        path: newUrl.href
                    }, '', newUrl.href);
                });
            });

            // Update URL when sub-tab changes for UAS
            const uasSubTabTriggers = document.querySelectorAll('#uasNilaiTabs button[data-bs-toggle="pill"]');
            uasSubTabTriggers.forEach(function(trigger) {
                trigger.addEventListener('shown.bs.tab', function(event) {
                    const newUrl = new URL(window.location.href);
                    const tabId = event.target.getAttribute('id').replace('-uas-tab', '');

                    newUrl.searchParams.set('sub_tab_uas', tabId);
                    newUrl.searchParams.delete('sub_tab_uts');
                    newUrl.searchParams.set('tab', 'uas');

                    window.history.pushState({
                        path: newUrl.href
                    }, '', newUrl.href);
                });
            });

            // Apply initial styles to all nilai inputs
            document.querySelectorAll('.nilai-input-kesantrian').forEach(input => {
                updateNilaiStyle(input);
            });

            // Add event listener for Enter key to move to next input
            document.querySelectorAll('.nilai-input-kesantrian').forEach((input, index, inputs) => {
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();

                        // Find the next input in the same table cell column
                        const currentRow = this.closest('tr');
                        const currentColumnIndex = Array.from(this.parentNode.parentNode.children)
                            .indexOf(this.parentNode);
                        const allRows = currentRow.parentNode.querySelectorAll('tr');
                        const currentRowIndex = Array.from(allRows).indexOf(currentRow);

                        if (currentRowIndex < allRows.length - 1) {
                            const nextRow = allRows[currentRowIndex + 1];
                            const nextInput = nextRow.children[currentColumnIndex].querySelector(
                                '.nilai-input-kesantrian');
                            if (nextInput) {
                                nextInput.focus();
                                nextInput.select();
                            }
                        }
                    }
                });
            });

            // Focus and select text when input is clicked
            document.querySelectorAll('.nilai-input-kesantrian').forEach(input => {
                input.addEventListener('click', function() {
                    this.select();
                });
            });

            // Auto-uppercase and validate on input
            // Auto-uppercase and validate on input
            document.querySelectorAll('.nilai-input-kesantrian').forEach(input => {
                input.addEventListener('input', function() {
                    // Simpan posisi kursor sebelum perubahan
                    const start = this.selectionStart;
                    const end = this.selectionEnd;

                    // Konversi ke huruf besar
                    this.value = this.value.toUpperCase();

                    // Batasi panjang maksimal 2 karakter
                    if (this.value.length > 2) {
                        this.value = this.value.slice(0, 2);
                    }

                    // Validasi input (fungsi yang sudah diperbaiki)
                    validateNilaiInput(this);

                    // Kembalikan posisi kursor (dengan penyesuaian)
                    const newLength = this.value.length;
                    const newStart = Math.min(start, newLength);
                    const newEnd = Math.min(end, newLength);
                    this.setSelectionRange(newStart, newEnd);
                });
            });
        });
    </script>

@endsection
