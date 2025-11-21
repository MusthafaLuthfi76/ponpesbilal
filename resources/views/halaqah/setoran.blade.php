@extends('layouts.app')

@section('page_title', 'Setoran Santri')

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

    .back-btn {
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
    }

    .back-btn:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .santri-info-card {
        background: linear-gradient(135deg, var(--primary-color) 0%, #1e7e34 100%);
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 20px;
        color: white;
    }

    .santri-info-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .santri-avatar {
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

    .santri-details h5 {
        margin: 0 0 5px 0;
        font-weight: 600;
        font-size: 22px;
        line-height: 1.2;
    }

    .santri-details p {
        margin: 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .santri-stats {
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

    .setoran-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .setoran-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        background-color: var(--bg-light);
        border-bottom: 1px solid var(--border-color);
    }

    .setoran-header h5 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .add-setoran-btn {
        background-color: var(--primary-color);
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s;
    }

    .add-setoran-btn:hover {
        background-color: #1e7e34;
        color: white;
        transform: translateY(-1px);
    }

    /* --- Tabel Desktop Styling --- */
    table {
        min-width: 800px; /* Lebar minimum untuk memicu scroll di mobile */
        width: 100%;
        border-collapse: collapse;
    }

    thead th {
        background-color: var(--bg-light);
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 12px 15px;
        border-bottom: 2px solid var(--border-color);
        font-weight: 600;
        text-align: left;
    }

    tbody td {
        padding: 15px;
        border-bottom: 1px solid var(--border-color);
        text-align: left;
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .status-lancar {
        background-color: #d4edda;
        color: #155724;
    }

    .status-kurang {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-tidak {
        background-color: #f8d7da;
        color: #721c24;
    }

    .action-btn {
        border: none;
        border-radius: 50%; 
        width: 36px;
        height: 36px;
        color: #fff;
        margin: 0 3px;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .edit {
        background: var(--secondary-color);
        color: #212529;
    }

    .delete {
        background: var(--delete-color);
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
    
    /* Modal Styles */
    .modal-header {
        color: var(--text-color);
    }

    .form-label {
        font-weight: 600;
        color: #555;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        border: 2px solid var(--border-color);
        border-radius: 5px;
        padding: 10px 12px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
    }
    
    /* ===================================================
    ⭐ MOBILE SCROLLABLE TABLE IMPLEMENTATION (< 768px)
    =================================================== */
    @media (max-width: 768px) {
        
        .container-wrapper {
            /* Pastikan padding horizontal di container-wrapper memadai */
            padding: 0 15px 20px 15px; 
        }
        
        /* 1. Header (Kembali & Judul) - Dibuat 100% lebar */
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 15px;
        }
        .page-header-left {
            margin-bottom: 10px;
        }
        .back-btn {
            width: 100%;
            justify-content: center;
        }
        
        /* 2. Santri Info Card - Dibuat lebih ringkas */
        .santri-info-card {
            padding: 20px;
        }
        .santri-stats {
            flex-direction: column; 
            gap: 15px;
        }
        .stat-item {
            justify-content: space-between; 
            width: 100%;
        }
        /* Sembunyikan ikon di statistik agar lebih ringkas */
        .stat-item i {
            display: none; 
        }
        .stat-label {
             /* Ubah kembali nilai opacity yang dihapus oleh Card View CSS sebelumnya */
            opacity: 0.8; 
            font-size: 12px; 
            font-weight: normal;
        }
        .stat-value {
            font-size: 18px;
        }

        /* 3. Setoran Header dan Tombol */
        .setoran-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 15px;
            gap: 10px;
        }
        .add-setoran-btn {
            width: 100%; 
            justify-content: center;
        }

        /* 4. Implementasi Tabel Scrollable */
        .table-responsive {
            overflow-x: auto; /* Memicu Scroll Horizontal */
            /* Tambahkan padding di sini agar scroll tidak mentok ke sisi layar */
            padding: 0 15px 0 15px; 
        }
        
        /* Hapus semua properti Card View yang tidak diperlukan */
        thead {
            display: table-header-group; /* Tampilkan Header */
        }
        tr {
            display: table-row;
            margin-bottom: 0;
            border: none;
            padding: 0;
            box-shadow: none;
            background: none;
        }
        td {
            display: table-cell;
            text-align: left;
            padding: 10px 15px;
            border-bottom: 1px solid #f0f0f0;
            position: static; /* Hapus positioning relatif */
            font-size: 14px;
        }
        td:last-child {
            text-align: center;
        }
        /* Hapus semua pseudoelemen (label kolom) */
        tr td:before,
        tr td:nth-last-child(1)::before {
            content: none;
        }
        
        /* Perataan tombol aksi */
        .action-btn {
            margin: 0 3px;
        }
    }
</style>

@section('content')

    <div class="container-wrapper">
        
        <div class="page-header">
            <div class="page-header-left">
                <h4><svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m20.148 5.437l-.659-1.043c-.364-.577-.546-.866-.785-.892c-.238-.027-.505.247-1.038.795c-1.722 1.77-3.444 1.508-5.166 4.691c-1.722-3.183-3.444-2.921-5.166-4.691c-.533-.548-.8-.822-1.038-.795c-.239.026-.421.315-.785.892l-.658 1.043c-.255.402-.382.604-.347.816c.034.212.217.357.584.647l6.182 4.898c.591.468.887.702 1.228.702s.637-.234 1.228-.702L19.91 6.9c.367-.29.55-.435.584-.647c.035-.212-.092-.414-.346-.816M22.5 8.5l-16 12v-4.696M2.5 8.5l16 12v-4.696"/></svg> Setoran Hafalan</h4>
            </div>
            <a href="{{ route('halaqah.show', $id_halaqah) }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        
        {{-- Santri Info Card --}}
        <div class="santri-info-card">
            <div class="santri-info-header">
                <div class="santri-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="santri-details">
                    <h5>{{ $santri->nama }}</h5>
                    <p><i class="fas fa-id-card me-2"></i>NIS: {{ $santri->nis }}</p>
                </div>
            </div>
            <div class="santri-stats">
                <div class="stat-item">
                    <i class="fas fa-book-open"></i>
                    <div>
                        <span class="stat-label">Total Setoran</span>
                        <span class="stat-value">{{ $setoran->count() }}</span>
                    </div>
                </div>
                <div class="stat-item">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <span class="stat-label">Lancar</span>
                        <span class="stat-value">{{ $setoran->where('status', 'Lancar')->count() }}</span>
                    </div>
                </div>
                <div class="stat-item">
                    <i class="fas fa-clock"></i>
                    <div>
                        <span class="stat-label">Terakhir Setor</span>
                        <span class="stat-value">{{ $setoran->first()?->tanggal_setoran?->format('d/m/Y') ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>


        {{-- Setoran Card --}}
        <div class="setoran-card">
            <div class="setoran-header">
                <h5><i class="fas fa-list"></i> Riwayat Setoran</h5>
                <button class="add-setoran-btn" data-bs-toggle="modal" data-bs-target="#addSetoranModal">
                    <i class="fas fa-plus"></i> Tambah Setoran
                </button>
            </div>

            {{-- **TABLE CONTAINER DENGAN OVERFLOW-X: AUTO DI MOBILE** --}}
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL</th>
                            <th>JUZ</th>
                            <th>AYAT</th>
                            <th>HALAMAN</th>
                            <th>STATUS</th>
                            <th>CATATAN</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($setoran as $s)
                            <tr>
                                {{-- data-label DIBIARKAN ADA, JIKA SUATU SAAT KEMBALI KE CARD VIEW --}}
                                <td data-label="NO">{{ $loop->iteration }}</td>
                                <td data-label="TANGGAL">{{ $s->tanggal_setoran->format('d/m/Y') }}</td>
                                <td data-label="JUZ">{{ $s->juz ?? '-' }}</td>
                                <td data-label="AYAT">{{ $s->ayat }}</td>
                                <td data-label="HALAMAN">{{ $s->halaman }}</td>
                                <td data-label="STATUS">
                                    <span
                                        class="status-badge 
                                        @if ($s->status == 'Lancar') status-lancar
                                        @elseif($s->status == 'Kurang Lancar') status-kurang
                                        @else status-tidak @endif">
                                        {{ $s->status }}
                                    </span>
                                </td>
                                <td data-label="CATATAN">{{ $s->catatan ?? '-' }}</td>
                                <td data-label="ACTION">
                                    <div class="d-flex justify-content-center">
                                        <button class="action-btn edit" data-bs-toggle="modal"
                                            data-bs-target="#editSetoranModal" data-id="{{ $s->id_setoran }}"
                                            data-nis="{{ $santri->nis }}"
                                            data-tanggal="{{ $s->tanggal_setoran->format('Y-m-d') }}"
                                            data-juz="{{ $s->juz }}" data-ayat="{{ $s->ayat }}"
                                            data-halaman="{{ $s->halaman }}" data-status="{{ $s->status }}"
                                            data-catatan="{{ $s->catatan }}" title="Edit">
                                             <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="white">
                                                <path
                                                    d="M21 12a1 1 0 0 0-1 1v6a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h6a1 1 0 0 0 0-2H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-6a1 1 0 0 0-1-1m-15 .76V17a1 1 0 0 0 1 1h4.24a1 1 0 0 0 .71-.29l6.92-6.93L21.71 8a1 1 0 0 0 0-1.42l-4.24-4.29a1 1 0 0 0-1.42 0l-2.82 2.83l-6.94 6.93a1 1 0 0 0-.29.71m10.76-8.35l2.83 2.83l-1.42 1.42l-2.83-2.83ZM8 13.17l5.93-5.93l2.83 2.83L10.83 16H8Z" />
                                            </svg>
                                        </button>

                                        <button class="action-btn delete" data-bs-toggle="modal"
                                            data-bs-target="#deleteSetoranModal" data-id="{{ $s->id_setoran }}"
                                            data-nis="{{ $santri->nis }}" data-surah="{{ $s->surah }}" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="white" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2">
                                                <path
                                                    d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class="fas fa-book-quran"></i>
                                        <p>Belum ada setoran</p>
                                        <small>Klik tombol "Tambah Setoran" untuk menambah setoran baru</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Setoran (Kode tetap sama) --}}
    <div class="modal fade" id="addSetoranModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('setoran.store', $santri->nis) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Setoran Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_setoran" class="form-label">Tanggal Setoran</label>
                                <input type="date" class="form-control" id="tanggal_setoran" name="tanggal_setoran"
                                    required value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="juz" class="form-label">Juz (Opsional)</label>
                                <input type="text" class="form-control" id="juz" name="juz"
                                    placeholder="Contoh: 1">
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6 mb-3">
                                <label for="ayat" class="form-label">Ayat</label>
                                <input type="text" class="form-control" id="ayat" name="ayat"
                                    placeholder="Contoh: 1–7" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="halaman" class="form-label">Halaman</label>
                                <input type="text" class="form-control" id="halaman" name="halaman"
                                    placeholder="Contoh: 12" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Lancar">Lancar</option>
                                <option value="Kurang Lancar">Kurang Lancar</option>
                                <option value="Tidak Lancar">Tidak Lancar</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3" placeholder="Catatan tambahan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn border-success" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit Setoran (Kode tetap sama) --}}
    <div class="modal fade" id="editSetoranModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form id="editSetoranForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Setoran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_tanggal_setoran" class="form-label">Tanggal Setoran</label>
                                <input type="date" class="form-control" id="edit_tanggal_setoran"
                                    name="tanggal_setoran" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_juz" class="form-label">Juz (Opsional)</label>
                                <input type="text" class="form-control" id="edit_juz" name="juz">
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6 mb-3">
                                <label for="edit_ayat" class="form-label">Ayat</label>
                                <input type="text" class="form-control" id="edit_ayat" name="ayat" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_halaman" class="form-label">Halaman</label>
                                <input type="text" class="form-control" id="edit_halaman" name="halaman" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Status</label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="Lancar">Lancar</option>
                                <option value="Kurang Lancar">Kurang Lancar</option>
                                <option value="Tidak Lancar">Tidak Lancar</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_catatan" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" id="edit_catatan" name="catatan" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn border-success" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                             Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Delete Setoran (Kode tetap sama) --}}
    <div class="modal fade" id="deleteSetoranModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="deleteSetoranForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header border-0 justify-content-center">
                             <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                fill="green" class="ml-auto">
                                <path
                                    d="M13.435 2.075a3.33 3.33 0 0 0-2.87 0c-.394.189-.755.497-1.26.928l-.079.066a2.56 2.56 0 0 1-1.58.655l-.102.008c-.662.053-1.135.09-1.547.236a3.33 3.33 0 0 0-2.03 2.029c-.145.412-.182.885-.235 1.547l-.008.102a2.56 2.56 0 0 1-.655 1.58l-.066.078c-.431.506-.74.867-.928 1.261a3.33 3.33 0 0 0 0 2.87c.189.394.497.755.928 1.26l.066.079c.41.48.604.939.655 1.58l.008.102c.053.662.09 1.135.236 1.547a3.33 3.33 0 0 0 2.029 2.03c.412.145.885.182 1.547.235l.102.008c.629.05 1.09.238 1.58.655l.078.066c.506.431.867.74 1.261.928a3.33 3.33 0 0 0 2.87 0c.394-.189.755-.497 1.26-.928l.079-.066c.48-.41.939-.604 1.58-.655l.102-.008c.662-.053 1.135-.09 1.547-.236a3.33 3.33 0 0 0 2.03-2.029c.145-.412.182-.885.235-1.547l-.008-.102c.05-.629.238-1.09.655-1.58l.066-.079c.431-.505.74-.866.928-1.26a3.33 3.33 0 0 0 0-2.87c-.189-.394-.497-.755-.928-1.26l-.066-.079a2.56 2.56 0 0 1-.655-1.58l-.008-.102c-.053-.662-.09-1.135-.236-1.547a3.33 3.33 0 0 0-2.029-2.03c-.412-.145-.885-.182-1.547-.235l-.102-.008a2.56 2.56 0 0 1-1.58-.655l-.079-.066c-.505-.431-.866-.74-1.26-.928M12 6.877a.75.75 0 0 1 .75.75v5.5a.75.75 0 0 1-1.5 0v-5.5a.75.75 0 0 1 .75-.75m.75 8.996v.5a.75.75 0 0 1-1.5 0v-.5a.75.75 0 0 1 1.5 0" />
                            </svg>
                    </div>
                    <div class="modal-body text-center">
                        <p class="mb-0">Apakah Anda yakin ingin menghapus setoran <strong
                                id="deleteSurahName"></strong>?</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn border-success" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- JS untuk handle modal edit & delete --}}
    <script>
        const editModal = document.getElementById('editSetoranModal');
        editModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const form = document.getElementById('editSetoranForm');

            // Ganti URL aksi form
            form.action = `/setoran/${button.dataset.nis}/${button.dataset.id}`;

            document.getElementById('edit_tanggal_setoran').value = button.dataset.tanggal;
            document.getElementById('edit_juz').value = button.dataset.juz ?? '';
            document.getElementById('edit_ayat').value = button.dataset.ayat;
            document.getElementById('edit_halaman').value = button.dataset.halaman;
            document.getElementById('edit_status').value = button.dataset.status;
            document.getElementById('edit_catatan').value = button.dataset.catatan ?? '';
        });

        const deleteModal = document.getElementById('deleteSetoranModal');
        deleteModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const form = document.getElementById('deleteSetoranForm');
            const surahName = document.getElementById('deleteSurahName');

            // Ganti URL aksi form
            form.action = `/setoran/${button.dataset.nis}/${button.dataset.id}`;
            surahName.textContent = button.dataset.surah;
        });
    </script>
    
@endsection