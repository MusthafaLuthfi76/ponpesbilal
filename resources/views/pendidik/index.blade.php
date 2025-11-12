@extends('layouts.app')

@section('page_title', 'Data Pendidik')

@section('content')
<style>
    /* Variabel Warna */
    :root {
        --green:#1f4a34;
        --green-dark:#173e2b;
        --light-green:#cfe9d7;
        --panel:#f8fdf9;
        --btn-green:#234f3a;
        --btn-green-hover:#1a3a2b;
        --btn-yellow:#d97706;
        --btn-red:#b91c1c;
    }

    /* Penyesuaian Main Content */
    main.content {
        background: var(--panel);
        border-radius: 20px 0 0 0;
        padding: 20px; /* Padding lebih kecil untuk mobile */
    }

    /* Header & Pencarian */
    .content-header {
        display: flex;
        flex-direction: column; /* Ubah menjadi kolom di mobile */
        align-items: flex-start;
        gap: 15px; /* Jarak antar elemen header */
        margin-bottom: 20px;
    }

    .content-header h2 {
        color: var(--green);
        font-weight: 700;
        font-size: 20px; /* Ukuran font lebih kecil */
        margin: 0;
    }

    .search-bar {
        display: flex;
        width: 100%; /* Lebar penuh di mobile */
        gap: 10px;
    }

    input[type="search"] {
        flex-grow: 1; /* Biarkan search input mengambil sisa ruang */
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px 12px;
        font-size: 14px;
    }

    .btn-add {
        background: var(--btn-green);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 14px;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
    }
    .btn-add:hover { background: var(--btn-green-hover); }

    /* Gaya Tabel Desktop (Disembunyikan di Mobile) */
    .table-container {
        overflow-x: auto; /* Untuk memastikan tabel tetap dapat discroll jika terlalu lebar */
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
    }

    .data-table th, .data-table td {
        padding: 12px 14px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
    }

    .data-table th {
        background: #f1f5f3;
        color: var(--green);
        font-weight: 600;
    }

    .data-table tr:hover { background: #f9fdfb; }

    /* Gaya Card Mobile (Tampil di Mobile) */
    .data-card-list {
        display: none; /* Default: disembunyikan */
        padding: 0;
        list-style: none;
        gap: 15px;
        flex-direction: column;
    }

    .data-card {
        background: #fff;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .card-item {
        margin-bottom: 10px;
    }

    .card-item-label {
        font-size: 12px;
        color: #666;
        font-weight: 500;
        display: block;
        margin-bottom: 2px;
    }

    .card-item-value {
        font-size: 16px;
        color: var(--green-dark);
        font-weight: 600;
        display: block;
    }
    
    .card-item:nth-child(1) .card-item-value {
        font-size: 18px;
        color: var(--green);
        font-weight: 700;
        border-bottom: 2px solid var(--light-green);
        padding-bottom: 5px;
        margin-bottom: 10px;
    }

    .card-actions {
        display: flex;
        justify-content: flex-end; /* Aksi di kanan bawah card */
        gap: 10px;
        padding-top: 10px;
        border-top: 1px dashed #e0e0e0;
    }
    
    /* Tombol Aksi */
    .action-btns {
        display: flex;
        gap: 6px;
    }

    .btn {
        border: none;
        border-radius: 6px;
        padding: 8px 12px; /* Padding lebih besar untuk sentuhan mobile */
        color: white;
        cursor: pointer;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px; /* Ukuran icon lebih besar */
    }
    .btn-warning { background: var(--btn-yellow); }
    .btn-warning:hover { background: #b45309; }
    .btn-danger { background: var(--btn-red); }
    .btn-danger:hover { background: #7f1d1d; }

    .alert {
        background: #d1fae5;
        color: #065f46;
        padding: 10px 14px;
        border-radius: 6px;
        margin-bottom: 15px;
        font-size: 14px;
    }

    /* Media Query untuk Mobile */
    @media (max-width: 768px) {
        /* Sembunyikan Tabel di Mobile */
        .table-container {
            display: none;
        }

        /* Tampilkan Card List di Mobile */
        .data-card-list {
            display: flex;
        }
        
        main.content {
            padding: 15px;
        }
    }
</style>

<main class="content">
    <div class="content-header">
        <h2>Data Pendidik</h2>
        <div class="search-bar">
            <input type="search" id="searchInput" placeholder="Cari Nama/Jabatan Pendidik...">
            <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambahPendidik">
                + Tambah
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    {{-- Tampilan Desktop: Tabel --}}
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID_PENDIDIK</th>
                    <th>Nama Lengkap</th>
                    <th>Jabatan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($pendidik as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->id_pendidik }}</td>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->jabatan }}</td>
                    <td>
                        <div class="action-btns">
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $p->id_pendidik }}">
                                ✏️
                            </button>
                            <form action="{{ route('pendidik.destroy', $p->id_pendidik) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @include('pendidik.modal_edit', ['p' => $p]) {{-- Asumsi modal edit ditaruh di file terpisah --}}
                @empty
                <tr><td colspan="5" style="text-align:center;">Belum ada data pendidik</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Tampilan Mobile: Card List --}}
    <div class="data-card-list" id="cardList">
        @forelse($pendidik as $index => $p)
        <div class="data-card" data-nama="{{ strtolower($p->nama) }}" data-jabatan="{{ strtolower($p->jabatan) }}">
            <div class="card-item">
                <span class="card-item-value">{{ $p->nama }} (No. {{ $index + 1 }})</span>
            </div>
            <div class="card-item">
                <span class="card-item-label">ID Pendidik</span>
                <span class="card-item-value">{{ $p->id_pendidik }}</span>
            </div>
            <div class="card-item">
                <span class="card-item-label">Jabatan</span>
                <span class="card-item-value">{{ $p->jabatan }}</span>
            </div>
            <div class="card-actions">
                <div class="action-btns">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $p->id_pendidik }}">
                        ✏️ Edit
                    </button>
                    <form action="{{ route('pendidik.destroy', $p->id_pendidik) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            🗑️ Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="data-card" style="text-align:center;">
            Belum ada data pendidik
        </div>
        @endforelse
    </div>
    
    {{-- Tambahkan pesan jika tidak ada hasil pencarian --}}
    <div id="noResults" style="display:none; text-align:center; padding: 20px;">
        Data pendidik tidak ditemukan.
    </div>
</main>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambahPendidik" tabindex="-1" aria-labelledby="modalTambahPendidikLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pendidik.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Pendidik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" placeholder="Masukkan jabatan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">User</label>
                        <select name="id_user" class="form-control" required>
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id_user }}">
                                    {{ $user->id_user }} - {{ $user->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-success" style="background:var(--btn-green);">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Untuk Modal Edit, Anda dapat memindahkannya ke dalam loop @forelse atau menggunakan partial view seperti di atas --}}
{{-- Saya asumsikan Anda memiliki file `pendidik/modal_edit.blade.php` atau Anda akan menambahkan modal edit di sini --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchInput");
    const tableRows = document.querySelectorAll("#tableBody tr");
    const cardListItems = document.querySelectorAll(".data-card");
    const noResults = document.getElementById("noResults");
    const dataCardList = document.getElementById("cardList");
    const dataTableContainer = document.querySelector(".table-container");

    function updateDisplay(query) {
        const isMobile = window.matchMedia("(max-width: 768px)").matches;
        let foundCount = 0;

        if (isMobile) {
            // Logika pencarian untuk tampilan Card (Mobile)
            cardListItems.forEach(card => {
                const nama = card.getAttribute('data-nama');
                const jabatan = card.getAttribute('data-jabatan');
                
                if (nama.includes(query) || jabatan.includes(query)) {
                    card.style.display = "block";
                    foundCount++;
                } else {
                    card.style.display = "none";
                }
            });
            // Tampilkan/Sembunyikan pesan "Tidak Ditemukan" di mobile
            noResults.style.display = (foundCount === 0 && cardListItems.length > 0) ? "block" : "none";
            dataCardList.style.display = (cardListItems.length > 0) ? "flex" : "none";
            dataTableContainer.style.display = "none";

        } else {
            // Logika pencarian untuk tampilan Tabel (Desktop)
            tableRows.forEach(row => {
                // Kolom Nama Lengkap (index 2) dan Jabatan (index 3)
                const nama = row.children[2].textContent.toLowerCase();
                const jabatan = row.children[3].textContent.toLowerCase();
                
                if (nama.includes(query) || jabatan.includes(query)) {
                    row.style.display = "";
                    foundCount++;
                } else {
                    row.style.display = "none";
                }
            });
            // Tampilkan/Sembunyikan pesan "Tidak Ditemukan" di desktop
            noResults.style.display = (foundCount === 0 && tableRows.length > 0) ? "block" : "none";
            dataTableContainer.style.display = "block";
            dataCardList.style.display = "none";
        }

        // Jika data awalnya kosong, tampilkan pesan default
        if (tableRows.length === 0 && cardListItems.length === 0) {
             noResults.style.display = "none"; // Biarkan pesan 'Belum ada data' di tabel/card tampil
        }
    }

    searchInput.addEventListener("input", function() {
        const query = this.value.toLowerCase().trim();
        updateDisplay(query);
    });

    // Panggil updateDisplay saat resize atau load untuk memastikan tampilan awal yang benar
    window.addEventListener('resize', () => updateDisplay(searchInput.value.toLowerCase().trim()));
    updateDisplay(searchInput.value.toLowerCase().trim()); // Panggilan awal
});
</script>
@endsection