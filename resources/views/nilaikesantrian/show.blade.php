@extends('layouts.app')

@section('page_title', 'Santri Tahun Ajaran')

{{-- Bootstrap & Font Awesome --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    :root {
        --primary-color: #28a745;
        --secondary-color: #ffc107;
        --delete-color: #dc3545;
        --border-color: #dee2e6;
        --text-color: #212529;
        --bg-light: #f8f9fa;
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

    .back-btn, .assign-btn {
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

    .back-btn:hover, .assign-btn:hover {
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

    .tahun-info-card {
        background: linear-gradient(135deg, var(--primary-color) 0%, #1e7e34 100%);
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 20px;
        color: white;
    }

    .tahun-info-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .tahun-icon {
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

    .tahun-details h5 {
        margin: 0 0 5px 0;
        font-weight: 600;
        font-size: 22px;
        line-height: 1.2;
    }

    .tahun-details p {
        margin: 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .tahun-stats {
        display: flex;
        gap: 30px;
        padding-top: 15px;
        border-top: 1px solid rgba(255, 255, 255, 0.3);
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .stat-item i {
        font-size: 20px;
        opacity: 0.9;
    }

    .stat-item div {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12px;
        opacity: 0.8;
    }

    .stat-value {
        font-size: 18px;
        font-weight: 600;
    }

    .santri-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .santri-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        background-color: var(--bg-light);
        border-bottom: 1px solid var(--border-color);
    }

    .santri-header h5 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Table Styling */
    .table-responsive {
        max-height: 70vh;
        overflow-y: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
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
        padding: 15px 12px;
        border-bottom: 1px solid var(--border-color);
        text-align: center;
        vertical-align: middle;
    }

    /* FIX ALIGNMENT HEADER & ISI */
    thead th,
    tbody td {
        vertical-align: middle !important;
        text-align: center !important;
    }

    /* Kecualikan kolom nama santri - biarkan rata kiri */
    thead th:nth-child(3),
    tbody td:nth-child(3) {
        text-align: left !important;
    }

    /* Paksa center untuk kolom nomor dan NIS */
    thead th:nth-child(1),
    thead th:nth-child(2),
    tbody td:nth-child(1),
    tbody td:nth-child(2) {
        text-align: center !important;
    }

    tbody tr:hover {
        background-color: #eef6ff;
        transition: .2s;
    }

    .nilai-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
        min-width: 40px;
        text-align: center;
    }

    .nilai-A {
        background-color: #d4edda;
        color: #155724;
    }

    .nilai-B {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .nilai-C {
        background-color: #fff3cd;
        color: #856404;
    }

    .nilai-D {
        background-color: #f8d7da;
        color: #721c24;
    }

    .action-btn {
        border: none;
        border-radius: 50%;
        width: 38px;
        height: 38px;
        color: #fff;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--secondary-color);
        margin: 0;
    }

    .action-btn:hover {
        opacity: 0.85;
        transform: scale(1.05);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    .empty-state p {
        font-size: 18px;
        margin-bottom: 10px;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        body {
            background-color: #f5f5f5;
        }

        .container-wrapper {
            padding: 0 0 20px 0;
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

        .back-btn, .assign-btn {
            width: 100%;
            justify-content: center;
            margin-bottom: 8px;
        }

        .tahun-info-card {
            border-radius: 0;
            padding: 20px 15px;
            margin-bottom: 15px;
        }

        .tahun-icon {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }

        .tahun-details h5 {
            font-size: 18px;
        }

        .tahun-stats {
            flex-wrap: wrap;
            gap: 15px;
        }

        .stat-item {
            flex: 1;
            min-width: calc(50% - 8px);
        }

        .santri-card {
            border-radius: 0;
        }

        .santri-header {
            padding: 15px;
        }

        .santri-header h5 {
            font-size: 16px;
        }

        thead th {
            font-size: 10px;
            padding: 8px 4px;
        }

        tbody td {
            padding: 8px 4px;
            font-size: 12px;
        }

        .action-btn {
            width: 32px;
            height: 32px;
        }
    }
</style>

@section('content')

<div class="container-wrapper">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left">
            <h4>
                <i class="fas fa-users"></i> Santri Tahun Ajaran
            </h4>
        </div>
        <div>
            <a href="{{ route('nilaikesantrian.assignForm', $tahunAjaran->id_tahunAjaran) }}" class="assign-btn">
                <i class="fas fa-user-plus"></i> Assign Santri Baru
            </a>
            <a href="{{ route('nilaikesantrian.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Tahun Ajaran Info Card -->
    <div class="tahun-info-card">
        <div class="tahun-info-header">
            <div class="tahun-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="tahun-details">
                <h5>Tahun Ajaran {{ $tahunAjaran->tahun }}</h5>
                <p><i class="fas fa-book me-2"></i>Semester {{ strtoupper($tahunAjaran->semester) }}</p>
            </div>
        </div>
        <div class="tahun-stats">
            <div class="stat-item">
                <i class="fas fa-users"></i>
                <div>
                    <span class="stat-label">Total Santri</span>
                    <span class="stat-value">{{ $nilai->count() }}</span>
                </div>
            </div>
            <div class="stat-item">
                <i class="fas fa-check-circle"></i>
                <div>
                    <span class="stat-label">Nilai Lengkap</span>
                    <span class="stat-value">{{ $nilai->whereNotNull('nilai_akhlak')->count() }}</span>
                </div>
            </div>
            <div class="stat-item">
                <i class="fas fa-clipboard-list"></i>
                <div>
                    <span class="stat-label">Status</span>
                    <span class="stat-value">Aktif</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Santri Card -->
    <div class="santri-card">
        <div class="santri-header">
            <h5><i class="fas fa-clipboard-list"></i> Daftar Santri & Nilai Kesantrian</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th class="d-none d-md-table-cell" style="width: 100px;">NIS</th>
                        <th style="min-width: 200px; text-align: left;">Nama Santri</th>
                        <th style="width: 110px;">Akhlak</th>
                        <th style="width: 110px;">Ibadah</th>
                        <th style="width: 110px;">Kerapian</th>
                        <th style="width: 120px;">Kedisiplinan</th>
                        <th style="width: 110px;">Ekstra</th>
                        <th style="width: 110px;">Buku Pegangan</th>
                        <th style="width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($nilai as $n)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="d-none d-md-table-cell"><small>{{ $n->santri->nis ?? '-' }}</small></td>
                        <td style="text-align: left;">
                            <strong>{{ $n->santri->nama ?? '-' }}</strong>
                            <small class="text-muted d-block d-md-none">NIS: {{ $n->santri->nis ?? '-' }}</small>
                        </td>
                        <td>
                            @if($n->nilai_akhlak)
                                <span class="nilai-badge nilai-{{ $n->nilai_akhlak }}">{{ $n->nilai_akhlak }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($n->nilai_ibadah)
                                <span class="nilai-badge nilai-{{ $n->nilai_ibadah }}">{{ $n->nilai_ibadah }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($n->nilai_kerapian)
                                <span class="nilai-badge nilai-{{ $n->nilai_kerapian }}">{{ $n->nilai_kerapian }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($n->nilai_kedisiplinan)
                                <span class="nilai-badge nilai-{{ $n->nilai_kedisiplinan }}">{{ $n->nilai_kedisiplinan }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($n->nilai_ekstrakulikuler)
                                <span class="nilai-badge nilai-{{ $n->nilai_ekstrakulikuler }}">{{ $n->nilai_ekstrakulikuler }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($n->nilai_buku_pegangan)
                                <span class="nilai-badge nilai-{{ $n->nilai_buku_pegangan }}">{{ $n->nilai_buku_pegangan }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('nilaikesantrian.edit', $n->id_nilai_kesantrian) }}" 
                               class="action-btn" 
                               title="Edit Nilai">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="white"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <i class="fas fa-users-slash"></i>
                                <p>Belum ada santri yang di-assign</p>
                                <small>Klik tombol "Assign Santri Baru" untuk menambah santri</small>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection