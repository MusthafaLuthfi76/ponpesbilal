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
        /* Tambahan warna konsisten dengan Data Santri */
        --green: #1f4a34;
        --btn-green: #234f3a;
        --btn-green-hover: #1a3a2b;
        --btn-yellow: #d97706;
        --btn-red: #b91c1c;
    }

    /* Penyesuaian Kontainer & Layout */
    .container {
        max-width: 1200px;
        margin: 30px auto;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        padding: 0; 
    }

    /* Header (Dibuat lebih responsif untuk mobile) */
    .header {
        display: flex;
        flex-direction: column; /* Default: Kolom untuk mobile */
        align-items: flex-start;
        padding: 20px;
        border-bottom: 1px solid var(--border-color);
        gap: 10px;
    }
    
    .header h3 {
        margin-bottom: 0;
        font-weight: 700;
        color: var(--green);
    }

    .header-right {
        display: flex;
        flex-direction: column; /* Tumpuk Search dan Tambah di mobile */
        width: 100%;
        gap: 10px;
    }

    .search-box {
        display: flex;
        align-items: center;
        border: 1px solid var(--border-color);
        border-radius: 8px; 
        padding: 8px 12px;
        width: 100%; 
    }

    .search-box input {
        border: none;
        outline: none;
        margin-left: 8px;
        flex-grow: 1;
    }

    .add-button {
        background-color: var(--btn-green); 
        color: white;
        padding: 10px 15px; 
        border-radius: 8px; 
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%; 
    }

    .add-button:hover {
        background-color: var(--btn-green-hover);
    }
    
    /* Media Query untuk Desktop (Mengembalikan layout header ke baris) */
    @media (min-width: 769px) {
        .header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        .header-right {
            flex-direction: row;
            width: auto;
        }
        .search-box {
            width: auto;
        }
        .add-button {
            width: auto;
        }
    }


    /* Tampilan Tabel Dasar (untuk Desktop) */
    .table-container {
        padding: 20px;
        overflow-x: auto; 
    }
    table {
        min-width: 700px; /* Tambahkan lebar minimum agar bisa di-scroll di mobile */
        width: 100%;
        border-collapse: collapse;
    }
    thead th {
        background-color: #f1f5f3; 
        font-weight: 600;
        color: var(--green);
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 12px;
        border-bottom: 2px solid var(--border-color);
        text-align: center; /* Sesuaikan perataan kolom */
    }
    thead th:nth-child(3) {
        text-align: left; /* Nama Kelompok di kiri */
    }
    tbody td {
        padding: 12px;
        border-bottom: 1px solid #f0f0f0; 
        text-align: center;
    }
    tbody td:nth-child(3) {
        text-align: left; /* Nama Kelompok di kiri */
    }
    tbody tr:hover {
        background: #f9fdfb;
    }

    /* Tombol Aksi */
    .action-btns {
        display: flex;
        justify-content: center;
        gap: 6px;
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
    .action-btn-link:hover, .action-btn-button:hover {
        opacity: 0.85;
        transform: scale(1.05);
    }
    /* Warna yang lebih konsisten */
    .btn-view { background: var(--primary-color); } 
    .btn-edit { background: var(--btn-yellow); }
    .btn-delete { background: var(--btn-red); }
    
    /* Pagination */
    .pagination .pagination-summary {
        display: none;
    }


    /* 📱 TAMPILAN SCROLLABLE TABLE MOBILE */
    @media (max-width: 768px) {
        .container {
            margin: 0; 
            border-radius: 0;
            box-shadow: none;
        }

        /* Container tabel agar scroll berfungsi */
        .table-container {
            padding: 15px 0; /* Hapus padding horizontal agar tabel bisa menyentuh tepi */
            overflow-x: auto; 
        }
        
        table {
            min-width: 700px; /* Pastikan min-width diterapkan untuk memicu scroll */
            margin: 0 15px; /* Tambahkan margin agar tabel tidak menempel ke tepi layar */
            border-radius: 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05); /* Tambahkan bayangan untuk visual kartu */
        }
        
        thead {
            display: table-header-group; /* Tetap tampilkan header */
        }
        
        /* Hapus properti Card View */
        tr {
            display: table-row;
            border: none;
            margin-bottom: 0;
            padding: 0;
            box-shadow: none;
            background: white;
        }

        td {
            display: table-cell;
            padding: 12px;
            border-bottom: 1px solid #f0f0f0; 
            text-align: center;
            font-size: 14px;
            position: static;
        }
        td:nth-child(3) {
            text-align: left; /* Pertahankan perataan nama */
        }
        
        /* Pastikan label Card View dihilangkan */
        td::before,
        td:nth-child(5)::before {
            content: none;
        }
        
        /* Penyesuaian Pagination agar tetap di tengah */
        .d-flex.justify-content-end.mt-3 {
            justify-content: center !important;
            padding-right: 0;
            padding-left: 0;
            padding-bottom: 15px;
        }
    }
</style>

@section('content')

    <div class="container">
        {{-- HEADER (Role banner & Search) --}}
        <header class="header" role="banner">
            <h3>{{ auth()->user()->role == 'musyrif' ? 'Setoran Harian' : 'Kelompok Halaqoh' }}</h3>
            <div class="header-right">
                <div class="search-box" role="search">
                    <i class="fas fa-search" aria-hidden="true"></i>
                    <input type="text" placeholder="Cari Kelompok..." id="searchInput" aria-label="Kolom Pencarian Kelompok">
                </div>
                <button class="add-button" data-bs-toggle="modal" data-bs-target="#createModal" aria-label="Tambah Kelompok Halaqoh">
                    <i class="fas fa-plus" aria-hidden="true"></i> Tambah
                </button>
            </div>
        </header>

        {{-- KONTEN DATA TABEL --}}
        <div class="table-container">
            <table class="text-center" role="table" aria-label="Tabel Data Kelompok Halaqoh">
                <thead>
                    <tr>
                        <th scope="col" style="width: 10%;">NO</th>
                        <th scope="col" style="width: 20%;">ID HALAQOH</th>
                        <th scope="col" style="width: 40%; text-align: left;">NAMA KELOMPOK</th>
                        <th scope="col" style="width: 15%;">ID PENDIDIK</th>
                        <th scope="col" style="width: 15%;">AKSI</th>
                    </tr>
                </thead>
                <tbody id="halaqahTable">
                    @forelse ($kelompok as $group)
                        <tr role="row" aria-label="Data kelompok {{ $group->nama_kelompok }}">
                            {{-- data-label DIBIARKAN, JIKA INGIN KEMBALI KE CARD VIEW --}}
                            <td data-label="NO" role="cell">{{ $loop->iteration }}</td>
                            <td data-label="ID HALAQOH" role="cell">{{ $group->id_halaqah }}</td>
                            <td data-label="NAMA KELOMPOK" role="cell">{{ $group->nama_kelompok }}</td>
                            <td data-label="ID PENDIDIK" role="cell">{{ $group->id_pendidik }}</td>
                            <td data-label="AKSI" role="cell" class="text-center">
                                <div class="action-btns">
                                    {{-- DETAIL --}}
                                    <a href="{{ route('halaqah.show', $group->id_halaqah) }}" title="Lihat Detail"
                                        class="action-btn-link btn-view" aria-label="Lihat detail kelompok {{ $group->nama_kelompok }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="white">
                                            <path d="M11.5 18c4 0 7.46-2.22 9.24-5.5C18.96 9.22 15.5 7 11.5 7S4.04 9.22 2.26 12.5C4.04 15.78 7.5 18 11.5 18m0-12c4.56 0 8.5 2.65 10.36 6.5C20 16.35 16.06 19 11.5 19S3 16.35 1.14 12.5C3 8.65 6.94 6 11.5 6m0 2C14 8 16 10 16 12.5S14 17 11.5 17 7 15 7 12.5 9 8 11.5 8m0 1A3.5 3.5 0 0 0 8 12.5a3.5 3.5 0 0 0 3.5 3.5a3.5 3.5 0 0 0 3.5-3.5A3.5 3.5 0 0 0 11.5 9" />
                                        </svg>
                                    </a>

                                    {{-- EDIT --}}
                                    <button title="Edit" data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-id="{{ $group->id_halaqah }}" data-nama="{{ $group->nama_kelompok }}"
                                        data-pendidik="{{ $group->id_pendidik }}"
                                        class="action-btn-button btn-edit" aria-label="Edit kelompok {{ $group->nama_kelompok }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="white">
                                            <path
                                                d="M21 12a1 1 0 0 0-1 1v6a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h6a1 1 0 0 0 0-2H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-6a1 1 0 0 0-1-1m-15 .76V17a1 1 0 0 0 1 1h4.24a1 1 0 0 0 .71-.29l6.92-6.93L21.71 8a1 1 0 0 0 0-1.42l-4.24-4.29a1 1 0 0 0-1.42 0l-2.82 2.83l-6.94 6.93a1 1 0 0 0-.29.71m10.76-8.35l2.83 2.83l-1.42 1.42l-2.83-2.83ZM8 13.17l5.93-5.93l2.83 2.83L10.83 16H8Z" />
                                        </svg>
                                    </button>

                                    {{-- DELETE --}}
                                    <button title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        data-id="{{ $group->id_halaqah }}"
                                        data-nama="{{ $group->nama_kelompok }}" 
                                        class="action-btn-button btn-delete" aria-label="Hapus kelompok {{ $group->nama_kelompok }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="white">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data kelompok.</td>
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

    {{-- Modal Tambah (Kode tetap sama) --}}
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('halaqah.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="createModalLabel">Tambah Kelompok Halaqoh</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="createPendidik" class="form-label">Nama Ustadz</label>
                           <select name="id_pendidik" id="createPendidik" class="form-select" required>
                                <option value="">Pilih Ustadz</option>
                                @foreach ($pendidik as $p)
                                    <option value="{{ $p->id_pendidik }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="mb-3">
                            <label for="createNamaKelompok" class="form-label">Nama Kelompok</label>
                            <input type="text" name="nama_kelompok" id="createNamaKelompok" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit (Kode tetap sama) --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title" id="editModalLabel">Edit Kelompok Halaqoh</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editPendidik" class="form-label">Nama Ustadz</label>
                            <select name="id_pendidik" id="editPendidik" class="form-select" required>
                                <option value="">Pilih Ustadz</option>
                                @foreach ($pendidik as $p)
                                    <option value="{{ $p->id_pendidik }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editNama" class="form-label">Nama Kelompok</label>
                            <input type="text" name="nama_kelompok" id="editNama" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning text-white">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Hapus (Kode tetap sama) --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0 d-block">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                fill="#b91c1c" class="ml-auto">
                                <path
                                    d="M13.435 2.075a3.33 3.33 0 0 0-2.87 0c-.394.189-.755.497-1.26.928l-.079.066a2.56 2.56 0 0 1-1.58.655l-.102.008c-.662.053-1.135.09-1.547.236a3.33 3.33 0 0 0-2.03 2.029c-.145.412-.182.885-.235 1.547l-.008.102a2.56 2.56 0 0 1-.655 1.58l-.066.078c-.431.506-.74.867-.928 1.261a3.33 3.33 0 0 0 0 2.87c.189.394.497.755.928 1.26l.066.079c.41.48.604.939.655 1.58l.008.102c.053.662.09 1.135.236 1.547a3.33 3.33 0 0 0 2.029 2.03c.412.145.885.182 1.547.235l.102.008c.629.05 1.09.238 1.58.655l.078.066c.506.431.867.74 1.261.928a3.33 3.33 0 0 0 2.87 0c.394-.189.755-.497 1.26-.928l.079-.066c.48-.41.939-.604 1.58-.655l.102-.008c.662-.053 1.135-.09 1.547-.236a3.33 3.33 0 0 0 2.03-2.029c.145-.412.182-.885.235-1.547l-.008-.102c.05-.629.238-1.09.655-1.58l.066-.079c.431-.505.74-.866.928-1.26a3.33 3.33 0 0 0 0-2.87c-.189-.394-.497-.755-.928-1.26l-.066-.079a2.56 2.56 0 0 1-.655-1.58l-.008-.102c-.053-.662-.09-1.135-.236-1.547a3.33 3.33 0 0 0-2.029-2.03c-.412-.145-.885-.182-1.547-.235l-.102-.008a2.56 2.56 0 0 1-1.58-.655l-.079-.066c-.505-.431-.866-.74-1.26-.928M12 6.877a.75.75 0 0 1 .75.75v5.5a.75.75 0 0 1-1.5 0v-5.5a.75.75 0 0 1 .75-.75m.75 8.996v.5a.75.75 0 0 1-1.5 0v-.5a.75.75 0 0 1 1.5 0" />
                            </svg>
                            <h5 class="modal-title mt-2 text-danger" id="deleteModalLabel">Konfirmasi Hapus</h5>
                        </div>
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body text-center ">
                        <p>Apakah Anda yakin ingin menghapus kelompok <strong id="deleteNama"></strong>?</p>
                    </div>
                    <div class="modal-footer justify-content-center border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
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
            const tableBody = document.getElementById('halaqahTable');
            const rows = tableBody.getElementsByTagName('tr');

            // Fitur pencarian baris tabel
            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                let found = false;

                for (let row of rows) {
                    // Cek jika baris berisi data (jumlah kolom > 1)
                    if (row.children.length > 1) { 
                        const text = row.textContent.toLowerCase();
                        if (text.includes(filter)) {
                            row.style.display = 'table-row'; // Pertahankan display table-row
                            found = true;
                        } else {
                            row.style.display = 'none';
                        }
                    } else {
                         // Sembunyikan pesan "Belum ada data" saat mencari
                        row.style.display = 'none';
                    }
                }
                
                // Tambahkan logika untuk menampilkan pesan jika tidak ada hasil pencarian
                const noDataRow = document.querySelector('td[colspan="5"]');
                if (noDataRow) {
                    if (found || rows.length > 1 && filter === "") { 
                             noDataRow.parentNode.style.display = 'none';
                    } else if (filter !== "") { 
                        noDataRow.textContent = 'Tidak ada kelompok yang cocok dengan kriteria.';
                        noDataRow.parentNode.style.display = 'table-row';
                    } else if (rows.length === 1 && filter === "") { // Tabel memang kosong
                        noDataRow.textContent = 'Belum ada data kelompok.';
                        noDataRow.parentNode.style.display = 'table-row';
                    }
                }
            });

            // --- Modal Edit ---
            const editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');
                const pendidik = button.getAttribute('data-pendidik');

                const form = editModal.querySelector('#editForm');
                // Set action form untuk PUT
                form.action = `/halaqah/${id}`; 
                form.querySelector('#editNama').value = nama;
                form.querySelector('#editPendidik').value = pendidik;
            });

            // --- Modal Hapus ---
            const deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama'); // Ambil nama kelompok

                const form = deleteModal.querySelector('#deleteForm');
                // Set action form untuk DELETE
                form.action = `/halaqah/${id}`;
                deleteModal.querySelector('#deleteNama').textContent = nama; // Tampilkan nama di modal
            });
        });
    </script>


@endsection