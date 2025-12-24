@extends('layouts.app')

@section('page_title', auth()->user()->role == 'musyrif' ? 'Setoran Harian' : 'Kelompok Halaqoh')

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
        --green: #1f4a34;
        --btn-green: #234f3a;
        --btn-green-hover: #1a3a2b;
        --btn-yellow: #d97706;
        --btn-red: #b91c1c;
    }

    body {
        background-color: #f5f5f5;
    }

    /* Container */
    .container {
        max-width: 1200px;
        margin: 20px auto;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        padding: 0;
    }

    /* Header */
    .header {
        display: flex;
        flex-direction: column;
        padding: 24px 20px;
        background: linear-gradient(135deg, var(--green) 0%, #2d6a4f 100%);
        gap: 16px;
    }
    
    .header h3 {
        margin: 0;
        font-weight: 700;
        color: white;
        font-size: 1.5rem;
    }

    .header-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 100%;
    }

    .search-box {
        display: flex;
        align-items: center;
        background: white;
        border-radius: 10px;
        padding: 12px 16px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .search-box i {
        color: #666;
        flex-shrink: 0;
    }

    .search-box input {
        border: none;
        outline: none;
        margin-left: 10px;
        flex-grow: 1;
        font-size: 15px;
        width: 100%;
        min-width: 0;
    }

    .add-button {
        background-color: #ffc107;
        color: #1f4a34;
        padding: 14px 20px;
        border-radius: 10px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-weight: 600;
        font-size: 16px;
        border: none;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .add-button:hover {
        background-color: #ffb700;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    /* Desktop Header Layout */
    @media (min-width: 769px) {
        .header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 25px 30px;
        }
        
        .header-actions {
            flex-direction: row;
            width: auto;
        }
        
        .search-box {
            width: 300px;
        }
        
        .add-button {
            width: auto;
            white-space: nowrap;
        }
    }

    /* Table Container */
    .table-container {
        padding: 20px;
    }

    /* Desktop Table */
    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: var(--green);
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 15px 12px;
        border-bottom: 2px solid var(--border-color);
        text-align: left;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    thead th:first-child,
    thead th:nth-child(2),
    thead th:nth-child(4) {
        text-align: center;
    }

    tbody td {
        padding: 16px 12px;
        border-bottom: 1px solid #f0f0f0;
        text-align: left;
        vertical-align: middle;
    }

    tbody td:first-child,
    tbody td:nth-child(2),
    tbody td:nth-child(4) {
        text-align: center;
    }

    tbody tr {
        transition: all 0.2s ease;
        cursor: pointer;
    }

    tbody tr:hover {
        background-color: #f8fdf9;
        transform: translateX(4px);
    }

    /* Action Buttons - Desktop */
    .action-btns {
        display: flex;
        justify-content: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 6px;
        border: none;
        color: #fff;
        transition: all 0.2s ease;
        padding: 0;
        cursor: pointer;
        text-decoration: none;
        font-size: 15px;
        font-weight: 600;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .action-btn:active {
        transform: translateY(0);
    }

    .btn-view { background: #22c55e; }
    .btn-view:hover { background: #16a34a; }
    
    .btn-edit { background: #f59e0b; }
    .btn-edit:hover { background: #d97706; }
    
    .btn-delete { background: #ef4444; }
    .btn-delete:hover { background: #dc2626; }


    /* 📱 MOBILE CARD VIEW */
    @media (max-width: 768px) {
        body {
            background-color: #f5f5f5;
        }

        .container {
            margin: 0;
            border-radius: 0;
            box-shadow: none;
            background: transparent;
        }

        .header {
            border-radius: 0;
            padding: 20px 16px;
            margin-bottom: 12px;
        }

        .header h3 {
            font-size: 1.3rem;
        }

        .header-actions {
            gap: 12px;
        }

        .search-box {
            padding: 12px 14px;
            border-radius: 10px;
        }

        .search-box input {
            font-size: 14px;
        }

        .add-button {
            padding: 13px 18px;
            font-size: 15px;
        }

        .table-container {
            padding: 0 12px 12px 12px;
        }

        /* Hide table */
        table, thead, tbody, tr {
            display: block;
        }

        thead {
            display: none;
        }

        tbody tr {
            background: white;
            border-radius: 12px;
            margin-bottom: 12px;
            padding: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: block;
            position: relative;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }

        tbody tr:active {
            transform: scale(0.98);
        }

        tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border: none;
            text-align: left;
            gap: 10px;
        }

        tbody td:before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--green);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            min-width: 110px;
            flex-shrink: 0;
        }

        /* Hide NO column on mobile */
        tbody td:first-child {
            display: none;
        }

        /* Style nama kelompok sebagai judul */
        tbody td:nth-child(3) {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--green);
            padding: 0 0 12px 0;
            margin-bottom: 8px;
            border-bottom: 1px solid #e0e0e0;
            display: block;
        }

        tbody td:nth-child(3):before {
            display: none;
        }

        /* Action buttons mobile */
        tbody td:last-child {
            padding-top: 15px;
            margin-top: 8px;
            border-top: 1px solid #f0f0f0;
            justify-content: center;
            display: flex;
        }

        tbody td:last-child:before {
            display: none;
        }

        .action-btns {
            width: 100%;
            justify-content: space-around;
            gap: 8px;
        }

        .action-btn {
            flex: 1;
            height: 46px;
            width: auto;
            max-width: 110px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 0 12px;
        }

        .btn-delete {
            flex-basis: 100%;
            max-width: 100%;
        }

        /* Add text labels to buttons on mobile */
        .action-btn:after {
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            margin-left: 4px;
        }

        .btn-view:after { content: 'Lihat'; }
        .btn-edit:after { content: 'Edit'; }
        .btn-delete:after { content: 'Hapus'; }


        /* Empty state */
        tbody tr td[colspan="5"] {
            display: block;
            text-align: center;
            padding: 40px 20px;
            background: white;
            border-radius: 12px;
        }

        tbody tr td[colspan="5"]:before {
            display: none;
        }

        /* Pagination mobile */
        .d-flex.justify-content-end.mt-3 {
            justify-content: center !important;
            padding: 0 12px 20px 12px;
        }

        /* Tap highlight untuk feedback visual */
        tbody tr {
            -webkit-tap-highlight-color: rgba(31, 74, 52, 0.1);
        }

        /* Perbaikan modal di mobile */
        .modal-dialog {
            margin: 16px;
        }

        .modal-content {
            border-radius: 12px;
        }
    }

    /* Pagination */
    .pagination {
        margin: 0;
    }

    .pagination .page-link {
        color: var(--green);
        border: 1px solid #dee2e6;
        padding: 8px 12px;
        border-radius: 6px;
        margin: 0 3px;
    }

    .pagination .page-link:hover {
        background-color: #e8f5e9;
        border-color: var(--green);
    }

    .pagination .active .page-link {
        background-color: var(--green);
        border-color: var(--green);
    }

    /* Loading State */
    .loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.9);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .loading-overlay.active {
        display: flex;
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid var(--green);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

@section('content')

    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>

    <div class="container">
        {{-- HEADER --}}
        <header class="header" role="banner">
            <h3>{{ auth()->user()->role == 'musyrif' ? 'Setoran Harian' : 'Kelompok Halaqoh' }}</h3>
            <div class="header-actions">
                <div style="display: flex; gap: 10px; width: 100%; flex-wrap: wrap; align-items: stretch;">
                    <div class="search-box" role="search" style="flex: 1; min-width: 200px;">
                        <i class="fas fa-search" aria-hidden="true"></i>
                        <input type="text" placeholder="Cari nama kelompok atau ustadz..." id="searchInput" aria-label="Kolom Pencarian Kelompok atau Ustadz">
                    </div>
                    <select id="filterTahun" class="form-select" style="flex: 0 1 250px; padding: 12px; border-radius: 10px; border: 1px solid #ddd;" aria-label="Filter Tahun Ajaran">
                        <option value="">Semua Tahun Ajaran</option>
                        @foreach ($tahunAjaran as $ta)
                            <option value="{{ $ta->id_tahunAjaran }}">{{ $ta->tahun }} ({{ $ta->semester }})</option>
                        @endforeach
                    </select>
                </div>
                <button class="add-button" data-bs-toggle="modal" data-bs-target="#createModal" aria-label="Tambah Kelompok Halaqoh">
                    <i class="fas fa-plus" aria-hidden="true"></i> 
                    <span>Tambah Kelompok</span>
                </button>
            </div>
        </header>

        {{-- KONTEN DATA TABEL --}}
        <div class="table-container">
            <table role="table" aria-label="Tabel Data Kelompok Halaqoh">
                <thead>
                    <tr>
                        <th scope="col" style="width: 8%;">NO</th>
                        <th scope="col" style="width: 35%;">NAMA KELOMPOK</th>
                        <th scope="col" style="width: 20%;">NAMA USTADZ</th>
                        <th scope="col" style="width: 15%;">TAHUN AJARAN</th>
                        <th scope="col" style="width: 22%;">AKSI</th>
                    </tr>
                </thead>
                <tbody id="halaqahTable">
                    @forelse ($kelompok as $group)
                        <tr role="row" data-href="{{ route('halaqah.show', $group->id_halaqah) }}" data-tahun="{{ $group->id_tahunAjaran }}" aria-label="Kelompok {{ $group->nama_kelompok }}">
                            <td data-label="NO">{{ $loop->iteration }}</td>
                            <td data-label="Nama Kelompok">{{ $group->nama_kelompok }}</td>
                            <td data-label="Nama Ustadz">{{ $group->pendidik?->nama ?? '-' }}</td>
                            <td data-label="Tahun Ajaran">{{ $group->tahunAjaran?->tahun . ' (' . $group->tahunAjaran?->semester . ')' ?? '-' }}</td>
                            <td data-label="Aksi" class="action-cell">
                                <div class="action-btns">
                                    <a href="{{ route('halaqah.show', $group->id_halaqah) }}" 
                                       class="action-btn btn-view" 
                                       title="Lihat Detail"
                                       aria-label="Lihat detail kelompok {{ $group->nama_kelompok }}"
                                       onclick="event.stopPropagation();">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>

                                    <button type="button"
                                            class="action-btn btn-edit" 
                                            title="Edit"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal"
                                            data-id="{{ $group->id_halaqah }}" 
                                            data-nama="{{ $group->nama_kelompok }}"
                                            data-pendidik="{{ $group->id_pendidik }}"
                                            aria-label="Edit kelompok {{ $group->nama_kelompok }}"
                                            onclick="event.stopPropagation();">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>

                                    <button type="button"
                                            class="action-btn btn-delete" 
                                            title="Hapus"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal"
                                            data-id="{{ $group->id_halaqah }}"
                                            data-nama="{{ $group->nama_kelompok }}" 
                                            aria-label="Hapus kelompok {{ $group->nama_kelompok }}"
                                            onclick="event.stopPropagation();">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted" style="padding: 40px 20px;">
                                <i class="fas fa-inbox fa-3x mb-3" style="color: #ccc;"></i>
                                <p style="margin: 0; font-size: 16px;">Belum ada data kelompok.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            {{-- PAGINATION --}}
            <div class="d-flex justify-content-end mt-3" aria-label="Navigasi Halaman">
                {{ $kelompok->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('halaqah.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header" style="background: var(--green); color: white; border: none;">
                        <h5 class="modal-title" id="createModalLabel">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Kelompok Halaqoh
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body" style="padding: 25px;">
                        <div class="mb-4">
                            <label for="createPendidik" class="form-label fw-semibold">
                                <i class="fas fa-user-tie me-2"></i>Nama Ustadz
                            </label>
                            <select name="id_pendidik" id="createPendidik" class="form-select" required style="padding: 12px;">
                                <option value="">-- Pilih Ustadz --</option>
                                @foreach ($pendidik as $p)
                                    <option value="{{ $p->id_pendidik }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="createTahunAjaran" class="form-label fw-semibold">
                                <i class="fas fa-calendar me-2"></i>Tahun Ajaran
                            </label>
                            <select name="id_tahunAjaran" id="createTahunAjaran" class="form-select" style="padding: 12px;">
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                @foreach ($tahunAjaran as $ta)
                                    <option value="{{ $ta->id_tahunAjaran }}">{{ $ta->tahun }} ({{ $ta->semester }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="createNamaKelompok" class="form-label fw-semibold">
                                <i class="fas fa-users me-2"></i>Nama Kelompok
                            </label>
                            <input type="text" name="nama_kelompok" id="createNamaKelompok" class="form-control" required placeholder="Masukkan nama kelompok" style="padding: 12px;">
                        </div>
                    </div>
                    <div class="modal-footer" style="border: none; padding: 20px 25px;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 10px 20px;">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn text-white" style="background: var(--green); padding: 10px 20px;">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header" style="background: var(--btn-yellow); color: white; border: none;">
                        <h5 class="modal-title" id="editModalLabel">
                            <i class="fas fa-edit me-2"></i>Edit Kelompok Halaqoh
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body" style="padding: 25px;">
                        <div class="mb-4">
                            <label for="editPendidik" class="form-label fw-semibold">
                                <i class="fas fa-user-tie me-2"></i>Nama Ustadz
                            </label>
                            <select name="id_pendidik" id="editPendidik" class="form-select" required style="padding: 12px;">
                                <option value="">-- Pilih Ustadz --</option>
                                @foreach ($pendidik as $p)
                                    <option value="{{ $p->id_pendidik }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="editTahunAjaran" class="form-label fw-semibold">
                                <i class="fas fa-calendar me-2"></i>Tahun Ajaran
                            </label>
                            <select name="id_tahunAjaran" id="editTahunAjaran" class="form-select" style="padding: 12px;">
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                @foreach ($tahunAjaran as $ta)
                                    <option value="{{ $ta->id_tahunAjaran }}">{{ $ta->tahun }} ({{ $ta->semester }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editNama" class="form-label fw-semibold">
                                <i class="fas fa-users me-2"></i>Nama Kelompok
                            </label>
                            <input type="text" name="nama_kelompok" id="editNama" class="form-control" required style="padding: 12px;">
                        </div>
                    </div>
                    <div class="modal-footer" style="border: none; padding: 20px 25px;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 10px 20px;">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn text-white" style="background: var(--btn-yellow); padding: 10px 20px;">
                            <i class="fas fa-save me-1"></i>Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Hapus --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body text-center" style="padding: 10px 30px 30px 30px;">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24"
                                fill="#dc3545">
                                <path d="M13.435 2.075a3.33 3.33 0 0 0-2.87 0c-.394.189-.755.497-1.26.928l-.079.066a2.56 2.56 0 0 1-1.58.655l-.102.008c-.662.053-1.135.09-1.547.236a3.33 3.33 0 0 0-2.03 2.029c-.145.412-.182.885-.235 1.547l-.008.102a2.56 2.56 0 0 1-.655 1.58l-.066.078c-.431.506-.74.867-.928 1.261a3.33 3.33 0 0 0 0 2.87c.189.394.497.755.928 1.26l.066.079c.41.48.604.939.655 1.58l.008.102c.053.662.09 1.135.236 1.547a3.33 3.33 0 0 0 2.029 2.03c.412.145.885.182 1.547.235l.102.008c.629.05 1.09.238 1.58.655l.078.066c.506.431.867.74 1.261.928a3.33 3.33 0 0 0 2.87 0c.394-.189.755-.497 1.26-.928l.079-.066c.48-.41.939-.604 1.58-.655l.102-.008c.662-.053 1.135-.09 1.547-.236a3.33 3.33 0 0 0 2.03-2.029c.145-.412.182-.885.235-1.547l-.008-.102c.05-.629.238-1.09.655-1.58l.066-.079c.431-.505.74-.866.928-1.26a3.33 3.33 0 0 0 0-2.87c-.189-.394-.497-.755-.928-1.26l-.066-.079a2.56 2.56 0 0 1-.655-1.58l-.008-.102c-.053-.662-.09-1.135-.236-1.547a3.33 3.33 0 0 0-2.029-2.03c-.412-.145-.885-.182-1.547-.235l-.102-.008a2.56 2.56 0 0 1-1.58-.655l-.079-.066c-.505-.431-.866-.74-1.26-.928M12 6.877a.75.75 0 0 1 .75.75v5.5a.75.75 0 0 1-1.5 0v-5.5a.75.75 0 0 1 .75-.75m.75 8.996v.5a.75.75 0 0 1-1.5 0v-.5a.75.75 0 0 1 1.5 0" />
                            </svg>
                        </div>
                        <h5 class="text-danger fw-bold mb-3">Konfirmasi Hapus</h5>
                        <p class="mb-0">Apakah Anda yakin ingin menghapus kelompok <strong id="deleteNama"></strong>?</p>
                        <p class="text-muted small mt-2">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                    <div class="modal-footer justify-content-center border-0" style="padding: 20px 30px;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 10px 20px;">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-danger" style="padding: 10px 20px;">
                            <i class="fas fa-trash me-1"></i>Ya, Hapus
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const filterTahun = document.getElementById('filterTahun');
            const tableBody = document.getElementById('halaqahTable');
            const rows = tableBody.getElementsByTagName('tr');
            const loadingOverlay = document.getElementById('loadingOverlay');

            // ===== RESTORE FILTER STATE =====
            const savedTahun = sessionStorage.getItem('halaqahFilterTahun');
            if (savedTahun !== null) {
                filterTahun.value = savedTahun;
            }

            // Fitur klik baris untuk redirect (kecuali tombol aksi)
            document.querySelectorAll('tbody tr[data-href]').forEach(row => {
                row.addEventListener('click', function(e) {
                    // Jangan redirect jika klik pada cell aksi atau tombol
                    if (!e.target.closest('.action-cell') && !e.target.closest('.action-btn')) {
                        window.location.href = this.dataset.href;
                    }
                });
            });

            // Fungsi filter kombinasi
            function applyFilters() {
                const searchFilter = searchInput.value.toLowerCase();
                const tahunFilter = filterTahun.value;
                let found = false;

                for (let row of rows) {
                    if (row.children.length > 1) {
                        const text = row.textContent.toLowerCase();
                        const tahunData = row.getAttribute('data-tahun');
                        
                        // Match search (nama kelompok atau ustadz)
                        const matchSearch = text.includes(searchFilter);
                        // Match filter tahun (jika filter kosong, tampilkan semua)
                        const matchTahun = !tahunFilter || tahunData === tahunFilter;
                        
                        if (matchSearch && matchTahun) {
                            row.style.display = '';
                            found = true;
                        } else {
                            row.style.display = 'none';
                        }
                    } else {
                        row.style.display = 'none';
                    }
                }
                
                // Update pesan pencarian
                const noDataRow = document.querySelector('td[colspan="4"]');
                if (noDataRow) {
                    if (found) { 
                        noDataRow.parentNode.style.display = 'none';
                    } else {
                        noDataRow.innerHTML = '<i class="fas fa-search fa-2x mb-3" style="color: #ccc;"></i><p style="margin: 0;">Tidak ada kelompok yang cocok dengan kriteria pencarian.</p>';
                        noDataRow.parentNode.style.display = '';
                    }
                }
            }

            // Event listener untuk search
            searchInput.addEventListener('keyup', applyFilters);
            
            // Event listener untuk filter tahun
            filterTahun.addEventListener('change', function() {
                // Simpan filter ke sessionStorage
                sessionStorage.setItem('halaqahFilterTahun', this.value);
                applyFilters();
            });

            // Jalankan filter saat halaman dimuat
            applyFilters();

            // Modal Edit
            const editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');
                const pendidik = button.getAttribute('data-pendidik');

                const form = editModal.querySelector('#editForm');
                form.action = `/halaqah/${id}`; 
                form.querySelector('#editNama').value = nama;
                form.querySelector('#editPendidik').value = pendidik;
            });

            // Modal Hapus
            const deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');

                const form = deleteModal.querySelector('#deleteForm');
                form.action = `/halaqah/${id}`;
                deleteModal.querySelector('#deleteNama').textContent = nama;
            });

            // Loading overlay untuk form submissions
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    loadingOverlay.classList.add('active');
                });
            });
        });
    </script>

@endsection