@extends('layouts.app')

@section('page_title', 'Detail Kelompok Halaqoh')

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
        --green: #1f4a34; 
        --btn-green: #1f4b2c;
    }

    body {
        background-color: #e8f5e9;
    }

    .container-wrapper {
        max-width: 1200px; 
        margin: 30px auto; 
        padding: 0 15px;
    }

    /* --- Tombol Kembali (Umum) --- */
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--green);
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 20px;
        transition: all 0.2s;
    }

    .back-btn:hover {
        color: var(--primary-color);
        gap: 12px;
    }

    /* ===================================================
    ⭐ HEADER BOX KHUSUS (Dari Gambar) 
    =================================================== */
    .add-santri-header-box {
        display: flex;
        justify-content: space-between; 
        align-items: center;
        padding: 15px 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 25px;
    }

    .add-santri-header-box .title {
        color: var(--green);
        font-size: 1.1rem;
        font-weight: 700;
        text-align: right; 
        line-height: 1.2;
    }

    .add-santri-header-box .title i {
        font-size: 1.5rem;
        display: block;
        margin-bottom: 5px;
        text-align: right;
    }

    .add-santri-header-box .btn-kembali {
        padding: 8px 15px;
        border: 1px solid var(--primary-color);
        border-radius: 8px;
        color: var(--primary-color);
        background: white;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    /* --- Card Info Halaqoh --- */
    .info-detail-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        padding: 20px;
        margin-bottom: 25px;
        border: none;
    }

    .info-detail-card h5 {
        color: var(--green);
        text-align: center;
        margin-bottom: 20px;
        font-size: 1.3rem;
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 10px;
    }
    
    .info-group {
        width: 48%;
        min-width: 150px;
        margin-bottom: 15px;
    }

    .info-label {
        font-weight: 500;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .info-value {
        font-weight: 700;
        color: var(--text-color);
        font-size: 1rem;
    }

    /* --- Card Daftar Santri --- */
    .santri-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        /* Hapus overflow: hidden agar scroll horizontal berfungsi */
    }

    .santri-header {
        display: flex;
        flex-direction: column; 
        align-items: flex-start;
        padding: 15px 20px;
        background-color: var(--bg-light);
        border-bottom: 1px solid var(--border-color);
        gap: 10px;
    }

    .santri-header h5 {
        margin: 0;
        font-weight: 700;
        color: var(--green);
        font-size: 1.1rem;
    }

    .header-controls {
        display: flex;
        flex-direction: column; 
        width: 100%;
        gap: 10px;
    }
    
    .search-box {
        display: flex;
        align-items: center;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 8px 12px;
        background: white;
        width: 100%;
    }

    .search-box input {
        border: none;
        outline: none;
        margin-left: 8px;
        flex-grow: 1;
        width: 100%;
    }

    .add-santri-btn {
        background-color: var(--btn-green);
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border: none;
        cursor: pointer;
        width: 100%;
    }
    
    .add-santri-btn:hover {
        background-color: #1a3a2b;
        color: white;
    }

    /* --- Tabel Desktop Styling --- */
    /* Pastikan .table-container yang membuat tabel bisa di-scroll secara horizontal */
    .table-container {
        padding: 0 20px 20px 20px;
        overflow-x: auto; /* Kunci agar tabel bisa di-scroll ke samping */
    }
    table {
        min-width: 600px; /* Tambahkan lebar minimum agar ada yang di-scroll */
        width: 100%;
        border-collapse: collapse;
    }
    
    thead th {
        background-color: #f1f5f3; 
        font-weight: 600;
        color: var(--green);
        text-transform: uppercase;
        font-size: 0.8rem;
        padding: 12px 15px;
        border-bottom: 2px solid var(--border-color);
        text-align: left; 
    }
    thead th:last-child {
        text-align: center; 
    }

    tbody td {
        padding: 12px 15px;
        border-bottom: 1px solid #f0f0f0; 
        text-align: left; 
    }
    tbody td:last-child {
        text-align: center; 
    }
    
    /* --- Tombol Aksi --- */
    .action-btns {
        display: flex;
        justify-content: center;
        gap: 8px;
    }
    .action-btn-link, .action-btn-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: none;
        color: #fff;
        transition: 0.2s;
        padding: 0;
        flex-shrink: 0;
        text-decoration: none;
    }
    .btn-setoran { background: var(--secondary-color); color: var(--text-color);} 
    .btn-delete { background: var(--delete-color); }

    .action-btn-link:hover, .action-btn-button:hover {
        opacity: 0.9;
        transform: scale(1.05);
    }
    
    /* 💻 MEDIA QUERY UNTUK DESKTOP (Tidak Ada Perubahan) */
    @media (min-width: 769px) {
        .santri-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        .header-controls {
            flex-direction: row;
            width: auto;
        }
        .search-box {
             width: auto;
             max-width: none;
        }
        .add-santri-btn {
            width: auto;
            max-width: 250px;
        }
        .info-detail-card .d-flex {
            justify-content: space-around !important; 
        }
        .info-group {
            width: auto;
        }
    }

    /* 📱 MEDIA QUERY UNTUK MOBILE - **DIUBAH MENJADI SCROLLABLE TABLE** */
    @media (max-width: 768px) {
        .container-wrapper {
            margin: 0;
        }
        /* Mengatur padding container agar tabel scroll tetap terlihat rapi */
        .table-container {
            padding: 15px 0 20px 0; /* Padding kiri dan kanan dihilangkan agar scroll optimal */
        }

        /* --- Perbaikan Info Halaqoh Card (Tetap Rapi Seperti Sebelumnya) --- */
        .info-detail-card .info-group {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 5px;
        }
        .info-detail-card .info-label {
            font-weight: 600;
            color: var(--green);
            font-size: 1rem;
        }
        .info-detail-card .info-value {
            text-align: right;
            font-weight: 700;
            flex-shrink: 0;
        }

        /* --- MENGHAPUS SEMUA CSS CARD VIEW YANG LAMA --- */
        table {
            display: table; /* Kembali ke tampilan tabel normal */
            min-width: 600px; /* Set lebar minimum agar bisa di-scroll */
            margin: 0 15px; /* Tambahkan margin kiri/kanan untuk visual */
        }
        thead {
            display: table-header-group; /* Tampilkan kembali header */
        }
        tr {
            display: table-row;
            border: none;
            margin-bottom: 0;
            padding: 0;
            box-shadow: none;
        }
        td {
            display: table-cell;
            text-align: left;
            padding: 10px 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }
        td:last-child {
             text-align: center;
             padding-left: 15px;
        }
        /* Menghapus semua pseudoelemen yang berkaitan dengan Card View */
        td::before, 
        td:nth-child(4)::before { 
            content: none !important; 
        }

        /* Penyesuaian Tombol Aksi */
        .action-btns {
            justify-content: center; 
            padding-top: 0;
        }

        /* Tombol Bawah (Add Santri / Form) */
        .form-bottom-actions {
            justify-content: space-between; 
            padding: 10px 15px;
        }
    }
</style>

@section('content')

    <div class="container-wrapper" role="main">

        {{-- 💡 PENGGANTIAN STRUKTUR HEADER (Dari Gambar Sebelumnya) --}}
        <div class="add-santri-header-box">
            {{-- Tombol Kembali di Kiri --}}
            <a href="{{ route('halaqah.index') }}" class="btn-kembali" aria-label="Kembali ke Daftar Halaqoh">
                <i class="fas fa-arrow-left" aria-hidden="true"></i> Kembali
            </a>
            
            {{-- Teks "Tambah Santri Baru" di Kanan --}}
            <div class="title">
                <i class="fas fa-user-plus" aria-hidden="true"></i>
                Tambah Santri Baru
            </div>
        </div>

        {{-- Judul halaman Detail Halaqoh asli --}}
        <a href="{{ route('halaqah.index') }}" class="back-btn" aria-label="Kembali ke Daftar Halaqoh" style="display:none;">
            <i class="fas fa-arrow-left" aria-hidden="true"></i> Kembali
        </a>
        
        {{-- Card Info Halaqoh (Detail Kelompok) --}}
        <section class="info-detail-card" role="region" aria-labelledby="halaqah-title">
            <h5 id="halaqah-title" class="fw-bold">
                Kelompok: {{ $kelompok->nama_kelompok }}
            </h5>

            <div class="d-flex flex-wrap justify-content-start">
                
                {{-- ID HALAQOH --}}
                <div class="info-group">
                    <div class="info-label">ID Halaqoh</div>
                    <div class="info-value">{{ $kelompok->id_halaqah }}</div>
                </div>

                {{-- NAMA KELOMPOK --}}
                <div class="info-group">
                    <div class="info-label">Nama Kelompok</div>
                    <div class="info-value">{{ $kelompok->nama_kelompok }}</div>
                </div>

                {{-- NAMA USTADZ --}}
                <div class="info-group">
                    <div class="info-label">Nama Ustadz</div>
                    <div class="info-value">{{ $kelompok->pendidik->nama ?? '—' }}</div>
                </div>

                {{-- ID PENDIDIK --}}
                <div class="info-group">
                    <div class="info-label">ID Ustadz</div>
                    <div class="info-value">{{ $kelompok->id_pendidik }}</div>
                </div>

            </div>
        </section>


        {{-- Card Daftar Santri --}}
        <div class="santri-card">
            <header class="santri-header" role="heading">
                <h5>Daftar Santri Kelompok ({{ $santri->total() }})</h5>
                <div class="header-controls">
                    <div class="search-box" role="search">
                        <i class="fas fa-search" aria-hidden="true"></i>
                        <input type="text" placeholder="Cari Nama/NIS..." id="searchInput" aria-label="Kolom Pencarian Santri">
                    </div>
                    <a href="{{ route('halaqah.showAddSantri', $kelompok->id_halaqah) }}" class="add-santri-btn" role="button" aria-label="Tambah Santri ke kelompok ini">
                        <i class="fas fa-plus" aria-hidden="true"></i> Tambah Santri
                    </a>
                </div>
            </header>

            {{-- **TABLE CONTAINER DENGAN OVERFLOW-X: AUTO** --}}
            <div class="table-container"> 
                <table role="table" aria-label="Daftar Santri dalam Kelompok">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 10%;">NO</th>
                            <th scope="col" style="width: 25%;">ID SANTRI</th>
                            <th scope="col" style="width: 45%;">NAMA SANTRI</th>
                            <th scope="col" style="width: 20%;" class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="santriTable">
                        @forelse ($santri as $s)
                            <tr role="row">
                                <td data-label="NO" role="cell">{{ ($santri->currentPage() - 1) * $santri->perPage() + $loop->iteration }}</td>
                                <td data-label="ID SANTRI" role="cell">{{ $s->nis }}</td>
                                <td data-label="NAMA SANTRI" role="cell">{{ $s->nama }}</td>
                                <td data-label="AKSI" role="cell">
                                    <div class="action-btns">
                                        
                                        {{-- SETORAN (VIEW) --}}
                                        <a href="{{ route('setoran.index', $s->nis) }}" title="Lihat Setoran"
                                            class="action-btn-link btn-setoran" aria-label="Lihat setoran santri {{ $s->nama }}">
                                            <i class="fas fa-book-open" aria-hidden="true"></i>
                                        </a>

                                        {{-- DELETE / KELUARKAN SANTRI --}}
                                        <button
                                            class="action-btn-button btn-delete" 
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteSantriModal" 
                                            data-id="{{ $s->nis }}"
                                            data-nama="{{ $s->nama }}" 
                                            title="Keluarkan dari kelompok"
                                            aria-label="Keluarkan santri {{ $s->nama }} dari kelompok ini">
                                            <i class="fas fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state text-center py-4">
                                        <i class="fas fa-users fa-3x text-muted" aria-hidden="true"></i>
                                        <p class="mt-2 text-muted">Belum ada santri dalam kelompok ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                {{-- PAGINATION --}}
                <div class="d-flex justify-content-end mt-3 px-3">
                    {{ $santri->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Delete Santri (Kode tetap sama) --}}
    <div class="modal fade" id="deleteSantriModal" tabindex="-1" aria-labelledby="deleteSantriModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="deleteSantriForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header justify-content-center border-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                            fill="var(--delete-color)">
                            <path
                                d="M13.435 2.075a3.33 3.33 0 0 0-2.87 0c-.394.189-.755.497-1.26.928l-.079.066a2.56 2.56 0 0 1-1.58.655l-.102.008c-.662.053-1.135.09-1.547.236a3.33 3.33 0 0 0-2.03 2.029c-.145.412-.182.885-.235 1.547l-.008.102a2.56 2.56 0 0 1-.655 1.58l-.066.078c-.431.506-.74.867-.928 1.261a3.33 3.33 0 0 0 0 2.87c.189.394.497.755.928 1.26l.066.079c.41.48.604.939.655 1.58l.008.102c.053.662.09 1.135.236 1.547a3.33 3.33 0 0 0 2.029 2.03c.412.145.885.182 1.547.235l.102.008c.629.05 1.09.238 1.58.655l.078.066c.506.431.867.74 1.261.928a3.33 3.33 0 0 0 2.87 0c.394-.189.755-.497 1.26-.928l.079-.066c.48-.41.939-.604 1.58-.655l.102-.008c.662-.053 1.135-.09 1.547-.236a3.33 3.33 0 0 0 2.03-2.029c.145-.412.182-.885.235-1.547l-.008-.102c.05-.629.238-1.09.655-1.58l.066-.079c.431-.505.74-.866.928-1.26a3.33 3.33 0 0 0 0-2.87c-.189-.394-.497-.755-.928-1.26l-.066-.079a2.56 2.56 0 0 1-.655-1.58l-.008-.102c-.053-.662-.09-1.135-.236-1.547a3.33 3.33 0 0 0-2.029-2.03c-.412-.145-.885-.182-1.547-.235l-.102-.008a2.56 2.56 0 0 1-1.58-.655l-.079-.066c-.505-.431-.866-.74-1.26-.928M12 6.877a.75.75 0 0 1 .75.75v5.5a.75.75 0 0 1-1.5 0v-5.5a.75.75 0 0 1 .75-.75m.75 8.996v.5a.75.75 0 0 1-1.5 0v-.5a.75.75 0 0 1 1.5 0" />
                        </svg>
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Tutup"></button>

                    </div>
                    <div class="modal-body text-center">
                        <h5 class="mb-3 text-danger" id="deleteSantriModalLabel">Konfirmasi Penghapusan</h5>
                        <p>Apakah Anda yakin ingin mengeluarkan santri <strong id="deleteSantriNama"></strong> dari kelompok
                            ini?</p>
                    </div>
                    <div class="modal-footer justify-content-center border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-check me-1"></i> Ya, Keluarkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    {{-- KODE KHUSUS UNTUK MENIRU LAYOUT BUTTON GAMBAR (untuk testing) --}}
    <div class="container-wrapper mt-5">
        
        {{-- Area Santri Dipilih (1 santri dipilih) --}}
        <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-top-lg border-bottom">
             <span class="text-success fw-bold">1 santri dipilih</span>
        </div>
        
        {{-- Button Fix Area --}}
        <div class="form-bottom-actions d-flex bg-white rounded-bottom" style="box-shadow: 0 -2px 4px rgba(0,0,0,0.1);">
            {{-- Tombol Batal/Batal Pilih Semua --}}
            <button class="btn btn-outline-secondary" type="button">
                <i class="fas fa-times me-1"></i> Batal
            </button>
            
            {{-- Tombol Simpan --}}
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-save me-1"></i> Simpan
            </button>
        </div>
    </div>
    
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Search functionality (Tetap sama) ---
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('santriTable');

            if (searchInput && tableBody) {
                searchInput.addEventListener('keyup', function() {
                    const filter = this.value.toLowerCase();
                    const rows = tableBody.getElementsByTagName('tr');
                    let foundSantri = false;

                    for (let row of rows) {
                        // Cek apakah ini bukan baris empty state
                        if (!row.querySelector('.empty-state')) { 
                            const text = row.textContent.toLowerCase();
                            if (text.includes(filter)) {
                                row.style.display = 'table-row'; // Ubah kembali ke table-row untuk scroll view
                                foundSantri = true;
                            } else {
                                row.style.display = 'none';
                            }
                        }
                    }

                    // Logika untuk menampilkan/menyembunyikan empty state
                    let emptyStateRow = tableBody.querySelector('.empty-state');
                    if (emptyStateRow) {
                        emptyStateRow = emptyStateRow.closest('tr');
                    }
                    
                    if (emptyStateRow) {
                        if (!foundSantri && filter !== "") {
                            emptyStateRow.style.display = 'table-row'; // Tampilkan empty state
                            emptyStateRow.querySelector('p').textContent = 'Tidak ada santri yang cocok dengan pencarian.';
                        } else if ({{ count($santri) }} === 0 && filter === "") {
                            emptyStateRow.style.display = 'table-row';
                            emptyStateRow.querySelector('p').textContent = 'Belum ada santri dalam kelompok ini.';
                        } else {
                            // Sembunyikan empty state jika ada hasil atau jika tabel memang terisi dan tidak ada filter
                            emptyStateRow.style.display = 'none'; 
                        }
                    }
                });
            }

            // --- Delete Santri Modal (Tetap sama) ---
            const deleteModal = document.getElementById('deleteSantriModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', event => {
                    const button = event.relatedTarget;
                    const nis = button.getAttribute('data-id');
                    const nama = button.getAttribute('data-nama');
                    const halaqahId = '{{ $kelompok->id_halaqah }}';

                    const namaElement = deleteModal.querySelector('#deleteSantriNama');
                    if (namaElement) {
                        namaElement.textContent = nama;
                    }

                    const form = deleteModal.querySelector('#deleteSantriForm');
                    if (form) {
                        // Ganti dengan route yang sesuai di Laravel
                        const newAction = `/halaqah/${halaqahId}/remove-santri/${nis}`; 
                        form.setAttribute('action', newAction);
                    }
                });
            }
        });
    </script>

@endsection