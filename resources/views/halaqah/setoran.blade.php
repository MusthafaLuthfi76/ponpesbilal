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

    /* SEMBUNYIKAN CARD VIEW DI DESKTOP */
    .setoran-card-mobile {
        display: none;
    }

    
    /* ===================================================
    ⭐ MOBILE CARD VIEW IMPLEMENTATION (< 768px)
    =================================================== */
    @media (max-width: 768px) {
        
        body {
            background-color: #f5f5f5;
        }

        .container-wrapper {
            padding: 0 0 20px 0;
        }
        
        /* 1. Header */
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
        
        /* 2. Santri Info Card */
        .santri-info-card {
            border-radius: 0;
            padding: 20px 15px;
            margin-bottom: 15px;
        }
        .santri-info-header {
            margin-bottom: 12px;
        }
        .santri-avatar {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }
        .santri-details h5 {
            font-size: 18px;
        }
        .santri-stats {
            flex-wrap: wrap;
            gap: 15px;
        }
        .stat-item {
            flex: 1;
            min-width: calc(50% - 8px);
        }

        /* 3. Setoran Header */
        .setoran-card {
            border-radius: 0;
        }
        .setoran-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 15px;
            gap: 12px;
        }
        .setoran-header h5 {
            font-size: 16px;
        }
        .add-setoran-btn {
            width: 100%; 
            justify-content: center;
        }

        /* SEMBUNYIKAN TABEL DI MOBILE */
        .table-responsive {
            display: none !important;
        }

        /* TAMPILKAN CARD VIEW DI MOBILE */
        .setoran-card-mobile {
            display: block;
            padding: 0 15px 15px 15px;
        }

        /* Styling Card Item */
        .setoran-item {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-left: 4px solid var(--primary-color);
        }

        .setoran-item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f0f0f0;
        }

        .setoran-date {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 14px;
        }

        .setoran-actions {
            display: flex;
            gap: 6px;
        }

        .setoran-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 10px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-color);
        }

        .setoran-catatan {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 6px;
            margin-top: 10px;
        }

        .setoran-catatan .info-label {
            margin-bottom: 5px;
        }

        .setoran-catatan .info-value {
            font-size: 13px;
            font-weight: normal;
            color: #555;
            line-height: 1.4;
        }

        /* Empty State Mobile */
        .empty-state-mobile {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }

        .empty-state-mobile i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.3;
        }

        .empty-state-mobile p {
            font-size: 16px;
            margin-bottom: 8px;
        }

        .empty-state-mobile small {
            font-size: 13px;
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

            {{-- DESKTOP: TABLE VIEW --}}
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL</th>
                            <th>JUZ</th>
                            <th>HALAMAN</th>
                            <th>STATUS</th>
                            <th>CATATAN</th>
                            <th style="text-align: center;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($setoran as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->tanggal_setoran->format('d/m/Y') }}</td>
                                <td>{{ $s->juz ?? '-' }}</td>
                                <td>{{ $s->halaman_awal }} - {{ $s->halaman_akhir }}</td>
                                <td>
                                    <span
                                        class="status-badge 
                                        @if ($s->status == 'Lancar') status-lancar
                                        @elseif($s->status == 'Kurang Lancar') status-kurang
                                        @else status-tidak @endif">
                                        {{ $s->status }}
                                    </span>
                                </td>
                                <td>{{ $s->catatan ?? '-' }}</td>
                                <td style="text-align: center;">
                                    <button class="action-btn edit" data-bs-toggle="modal"
                                        data-bs-target="#editSetoranModal"
                                        data-id="{{ $s->id_setoran }}"
                                        data-nis="{{ $santri->nis }}"
                                        data-tanggal="{{ $s->tanggal_setoran->format('Y-m-d') }}"
                                        data-juz="{{ $s->juz }}"
                                        data-ayat="{{ $s->ayat }}"
                                        data-halaman_awal="{{ $s->halaman_awal }}"
                                        data-halaman_akhir="{{ $s->halaman_akhir }}"
                                        data-status="{{ $s->status }}"
                                        data-catatan="{{ $s->catatan }}"
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="white"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2
                                                2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3
                                                3L12 15l-4 1 1-4 9.5-9.5z" />
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
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
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

            {{-- MOBILE: CARD VIEW --}}
            <div class="setoran-card-mobile">
                @forelse($setoran as $s)
                    <div class="setoran-item">
                        <div class="setoran-item-header">
                            <div class="setoran-date">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $s->tanggal_setoran->format('d M Y') }}
                            </div>
                            <div class="setoran-actions">
                                <button class="action-btn edit" data-bs-toggle="modal"
                                    data-bs-target="#editSetoranModal"
                                    data-id="{{ $s->id_setoran }}"
                                    data-nis="{{ $santri->nis }}"
                                    data-tanggal="{{ $s->tanggal_setoran->format('Y-m-d') }}"
                                    data-juz="{{ $s->juz }}"
                                    data-ayat="{{ $s->ayat }}"
                                    data-halaman_awal="{{ $s->halaman_awal }}"
                                    data-halaman_akhir="{{ $s->halaman_akhir }}"
                                    data-status="{{ $s->status }}"
                                    data-catatan="{{ $s->catatan }}"
                                    title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="white"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                </button>
                                <button class="action-btn delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteSetoranModal" 
                                    data-id="{{ $s->id_setoran }}"
                                    data-nis="{{ $santri->nis }}" 
                                    data-surah="{{ $s->surah }}" 
                                    title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="white" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2">
                                        <path d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="setoran-info">
                            <div class="info-item">
                                <span class="info-label">Juz</span>
                                <span class="info-value">{{ $s->juz ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Halaman</span>
                                <span class="info-value">{{ $s->halaman_awal }} - {{ $s->halaman_akhir }}</span>
                            </div>
                            <div class="info-item" style="grid-column: 1 / -1;">
                                <span class="info-label">Status</span>
                                <div>
                                    <span class="status-badge 
                                        @if ($s->status == 'Lancar') status-lancar
                                        @elseif($s->status == 'Kurang Lancar') status-kurang
                                        @else status-tidak @endif">
                                        {{ $s->status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if($s->catatan)
                        <div class="setoran-catatan">
                            <span class="info-label">Catatan</span>
                            <div class="info-value">{{ $s->catatan }}</div>
                        </div>
                        @endif
                    </div>
                @empty
                    <div class="empty-state-mobile">
                        <i class="fas fa-book-quran"></i>
                        <p>Belum ada setoran</p>
                        <small>Klik tombol "Tambah Setoran" untuk menambah setoran baru</small>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Modal Tambah Setoran --}}
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
                            <label class="form-label">Halaman Awal</label>
                            <input type="number" class="form-control" name="halaman_awal" placeholder="Misal: 12" required>
                            </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Halaman Akhir</label>
                            <input type="number" class="form-control" name="halaman_akhir" placeholder="Misal: 15" required>
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

    {{-- Modal Edit Setoran --}}
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
                                <label class="form-label">Halaman Awal</label>
                                <input type="number" class="form-control" id="edit_halaman_awal" name="halaman_awal" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Halaman Akhir</label>
                                <input type="number" class="form-control" id="edit_halaman_akhir" name="halaman_akhir" required>
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

    {{-- Modal Delete Setoran --}}
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
            document.getElementById('edit_halaman_awal').value = button.dataset.halaman_awal;
            document.getElementById('edit_halaman_akhir').value = button.dataset.halaman_akhir;
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