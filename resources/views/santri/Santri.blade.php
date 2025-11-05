@extends('layouts.app')

@section('page_title','Data Santri')

@section('content')
<style>
    :root {
        --green:#1f4a34;
        --green-dark:#173e2b;
        --light-green:#cfe9d7;
        --bg:#cdd9cf;
        --panel:#f8fdf9;
        --accent:#234f3a;
        --btn-green:#234f3a;
        --btn-green-hover:#1a3a2b;
        --btn-red:#b91c1c;
        --btn-yellow:#d97706;
    }

    /* Main Content */
    main.content {
        background: var(--panel);
        border-radius: 20px 0 0 0;
        padding: 30px;
    }

    /* Header di dalam Content */
    .content-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    .content-header h2 {
        font-size: 20px;
        color: var(--green);
        font-weight: 700;
    }

    /* Search dan Filter */
    .search-filter {
        display: block; 
        gap: 10px; 
        margin-bottom: 15px; 
    }
    
    .filter-and-add-group {
        display: flex; 
        align-items: center;
        gap: 10px;
        margin-top: 10px; 
    }

    input[type="search"] {
        width: 100%;
        max-width: none; 
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 8px 12px;
    }

    select.filter {
        max-width: none; 
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 8px 12px;
    }

    /* Tombol Tambah Data */
    .btn-add {
        padding: 8px 10px; 
        flex-shrink: 0; 
        background: var(--btn-green);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-add:hover {
        background: var(--btn-green-hover);
    }

    /* Tabel Data */
    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        overflow: hidden;
    }
    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
    }
    th {
        background: #f1f5f3;
        font-weight: 600;
        color: #1f4a34;
    }
    tr:hover {
        background: #f9fdfb;
    }

    /* Tombol Aksi di Kolom Action */
    .action-btns {
        display: flex;
        gap: 6px;
    }
    .btn {
        border: none;
        border-radius: 6px;
        padding: 6px 10px;
        cursor: pointer;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: 0.3s;
    }
    .btn-warning { background: var(--btn-yellow); }
    .btn-danger { background: var(--btn-red); }
    .btn-warning:hover { background: #b45309; }
    .btn-danger:hover { background: #7f1d1d; }

    /* Notifikasi Sukses */
    .alert {
        background: #d1fae5;
        color: #065f46;
        padding: 10px 14px;
        border-radius: 6px;
        margin-bottom: 10px;
    }

    /* Responsif Default */
    @media (max-width: 900px) {
        .layout { grid-template-columns: 1fr; }
    }

    /* 📱 RESPONSIVE MOBILE - Kunci untuk tampilan seperti Tahun Ajaran */
    @media (max-width: 768px) {
        /* Tata Letak Header */
        .content-header {
            flex-direction: column; /* Ubah layout header menjadi kolom */
            align-items: flex-start;
        }

        .content-header h2 {
            margin-bottom: 10px; /* Jarak antara judul dan kontrol */
        }

        /* Tata Letak Search, Filter, dan Tombol Tambah */
        .search-filter {
            width: 100%; /* Agar kontrol memenuhi lebar */
            flex-direction: column; /* Tumpuk elemen kontrol secara vertikal */
            gap: 8px;
        }

        input[type="search"],
        select.filter,
        .btn-add {
            box-sizing: border-box; /* Agar padding/border tidak menambah lebar total */
        }

        /* Tabel Responsif (Tampilan Kartu) */
        table {
            border-radius: 0; /* Hilangkan border radius pada tabel agar baris menempel */
        }
        tr {
            border: 1px solid #e0e0e0;
            margin-bottom: 15px; /* Jarak antar kartu */
            border-radius: 10px; /* Radius untuk setiap kartu/baris */
            display: block;
            background: white;
            padding: 10px; /* Padding di dalam kartu */
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        thead {
            display: none; /* Sembunyikan header tabel di mobile */
        }

        td {
            border-bottom: 1px solid #f0f0f0; /* Garis pemisah antar data */
            position: relative;
            padding: 8px 10px 8px 50%; /* Sisakan ruang untuk label */
            text-align: right;
            display: block;
            font-size: 14px;
        }

        td:last-child {
            border-bottom: none; /* Hilangkan garis pemisah pada kolom terakhir */
            padding-bottom: 0;
            padding-top: 10px;
        }

        /* Label Kolom (seperti No, Tahun, Semester di tampilan Tahun Ajaran) */
        td::before {
            content: attr(data-label); /* Gunakan atribut data-label sebagai label */
            position: absolute;
            left: 10px;
            width: 45%;
            font-weight: 600;
            color: var(--green);
            text-align: left;
        }

        /* Penyesuaian Kolom Aksi */
        .action-btns {
            justify-content: flex-end; /* Posisikan tombol aksi di kanan (mirip Tahun Ajaran) */
            padding-top: 5px;
        }
        td:nth-child(7) { /* Kolom Action */
            text-align: right;
            padding-left: 10px;
        }
        td:nth-child(7)::before {
            content: ""; /* Sembunyikan label untuk Aksi */
        }

        /* di dalam <style> di layouts/app.blade.php */

    @media (max-width: 900px) {
        .layout { grid-template-columns: 1fr; }
        
        .sidebar.toggled { 
            display: block !important; /* Menimpa display: none */
            position: fixed; 
            z-index: 1050; 
            width: 250px;
            height: 100vh;
            background-color: white; 
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    }
    }
</style>

<main class="content">
    <div class="search-filter">
    {{-- BARIS 1: Search (Full Width) --}}
    <input type="search" id="searchInput" placeholder="Search...">

    {{-- BARIS 2: Filter & Button (Berdampingan) --}}
    <div class="filter-and-add-group"> 
        <select id="filterAngkatan" class="filter">
            <option value="">Semua Angkatan</option>
            @foreach($santri->pluck('angkatan')->unique()->filter() as $angkatan)
                <option value="{{ $angkatan }}">{{ $angkatan }}</option>
            @endforeach
        </select>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambahSantri">+ Tambah</button>
    </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Lengkap</th>
                <th>Angkatan</th>
                <th>Status</th>
                <th>Tahun Ajaran</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($santri as $index => $s)
            <tr>
                {{-- ⭐ Tambahkan data-label untuk responsif mobile --}}
                <td data-label="No">{{ $index + 1 }}</td>
                <td data-label="NIS">{{ $s->nis }}</td>
                <td data-label="Nama Lengkap">{{ $s->nama }}</td>
                <td data-label="Angkatan">{{ $s->angkatan ?? '-' }}</td>
                <td data-label="Status">{{ $s->status }}</td>
                <td data-label="Tahun Ajaran">{{ $s->tahunAjaran->tahun ?? '-' }} - {{ $s->tahunAjaran->semester ?? '' }}</td>
                <td data-label="Action">
                    <div class="action-btns">
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $s->nis }}">✏️</button>
                        <form action="{{ route('santri.destroy', $s->nis) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">🗑️</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;">Belum ada data santri</td></tr>
            @endforelse
        </tbody>
    </table>

 @foreach ($santri as $s)
<div class="modal fade" id="editModal{{ $s->nis }}" tabindex="-1" aria-labelledby="editModalLabel{{ $s->nis }}" aria-hidden="true">
    <div class="modal-dialog">
        {{-- Tambahkan border-0 shadow-sm untuk tampilan modern --}}
        <div class="modal-content border-0 shadow-sm">
            <form action="{{ route('santri.update', $s->nis) }}" method="POST">
                @csrf
                @method('PUT')
                
                {{-- HEADER KUNING: Sesuai Modal Edit --}}
                <div class="modal-header bg-warning text-white"> 
                    <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Data Santri</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button> 
                </div>
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">NIS</label>
                        <input type="text" name="nis" class="form-control" value="{{ $s->nis }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="{{ $s->nama }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Angkatan</label>
                        <input type="text" name="angkatan" class="form-control" value="{{ $s->angkatan }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="MTS" {{ $s->status == 'MTS' ? 'selected' : '' }}>MTS</option>
                            <option value="MA" {{ $s->status == 'MA' ? 'selected' : '' }}>MA</option>
                            <option value="Alumni" {{ $s->status == 'Alumni' ? 'selected' : '' }}>Alumni</option>
                            <option value="Keluar" {{ $s->status == 'Keluar' ? 'selected' : '' }}>Keluar</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun Ajaran</label>
                        <select name="id_tahunAjaran" class="form-select">
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach($tahunajaran as $t)
                                <option value="{{ $t->id_tahunAjaran }}" {{ $s->id_tahunAjaran == $t->id_tahunAjaran ? 'selected' : '' }}>
                                    {{ $t->tahun }} - {{ $t->semester }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer">
                    {{-- Tombol Batal Abu-abu --}}
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    {{-- Tombol Perbarui Kuning --}}
                    <button type="submit" class="btn btn-warning text-white">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


<div class="modal fade" id="modalTambahSantri" tabindex="-1" aria-labelledby="modalTambahSantriLabel" aria-hidden="true">
  <div class="modal-dialog">
    {{-- Tambahkan border-0 shadow-sm untuk tampilan modern --}}
    <div class="modal-content border-0 shadow-sm">
      <form action="{{ route('santri.store') }}" method="POST">
        @csrf
        
        {{-- HEADER HIJAU: Sesuai Modal Tambah --}}
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="modalTambahSantriLabel"><i class="bi bi-plus-circle"></i> Tambah Santri</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">
            <div class="mb-3">
                <label for="nis" class="form-label">NIS</label>
                <input type="text" name="nis" class="form-control" placeholder="Masukkan NIS" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Lengkap" required>
            </div>
            <div class="mb-3">
                <label for="angkatan" class="form-label">Angkatan</label>
                <input type="text" name="angkatan" class="form-control" placeholder="Masukkan Angkatan">
            </div>
            <div class="mb-3">
                <label for="id_tahunAjaran" class="form-label">Tahun Ajaran</label>
                <select name="id_tahunAjaran" class="form-select" required>
                    <option value="" disabled selected>Pilih Tahun Ajaran</option>
                    @foreach($tahunajaran as $t)
                        <option value="{{ $t->id_tahunAjaran }}">{{ $t->tahun }} - {{ $t->semester }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="MTS" selected>MTS</option>
                    <option value="MA">MA</option>
                    <option value="Alumni">Alumni</option>
                    <option value="Keluar">Keluar</option>
                </select>
            </div>
        </div>
        
        <div class="modal-footer">
          {{-- Tombol Batal Abu-abu --}}
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          {{-- Tombol Simpan Hijau --}}
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
        

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

document.addEventListener("DOMContentLoaded", function() {


    const searchInput = document.getElementById("searchInput");
    const filterAngkatan = document.getElementById("filterAngkatan");
    const rows = document.querySelectorAll("tbody tr");

    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();
        const selectedAngkatan = filterAngkatan.value;

        rows.forEach(row => {
            // Kita perlu memeriksa apakah baris tersebut adalah baris 'Belum ada data santri'
            if (row.children.length > 1) { // Pastikan ini bukan baris kosong/pesan
                const nis = row.children[1].textContent.toLowerCase();
                const nama = row.children[2].textContent.toLowerCase();
                const angkatan = row.children[3].textContent.trim();

                const matchSearch = nis.includes(searchValue) || nama.includes(searchValue);
                const matchAngkatan = selectedAngkatan === "" || angkatan === selectedAngkatan;

                if (matchSearch && matchAngkatan) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            } else {
                // Biarkan pesan 'Belum ada data santri' ditampilkan jika pencarian/filter kosong
                if (searchValue === "" && selectedAngkatan === "") {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        });

        // Pastikan pesan 'Belum ada data santri' tetap terlihat jika tidak ada hasil
        const visibleRows = Array.from(rows).filter(row => row.style.display !== "none" && row.children.length > 1);
        const noDataRow = document.querySelector('td[colspan="7"]');
        
        if (noDataRow) {
            // Sembunyikan pesan 'Belum ada data' jika ada data yang terlihat
            if (visibleRows.length > 0) {
                noDataRow.parentNode.style.display = "none";
            } else if (searchInput.value === "" && filterAngkatan.value === "") {
                // Tampilkan pesan 'Belum ada data' jika filter/search kosong dan memang tidak ada data
                if ({{ count($santri) }} === 0) {
                    noDataRow.parentNode.style.display = "";
                } else {
                    noDataRow.parentNode.style.display = "none"; // Sembunyikan jika tidak ada hasil pencarian/filter
                }
            } else {
                // Tampilkan pesan bahwa tidak ada hasil
                noDataRow.parentNode.style.display = ""; 
                noDataRow.textContent = "Tidak ada santri yang cocok dengan kriteria.";
            }
        }
    }

    searchInput.addEventListener("input", filterTable);
    filterAngkatan.addEventListener("change", filterTable);

    // Initial check to handle the "Belum ada data santri" row
    if ({{ count($santri) }} === 0) {
        document.querySelector('td[colspan="7"]').parentNode.style.display = "";
    } else {
        const noDataRow = document.querySelector('td[colspan="7"]');
        if (noDataRow) noDataRow.parentNode.style.display = "none";
    }
});
</script>

@endsection