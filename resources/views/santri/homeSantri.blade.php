@extends('layouts.app')

@section('page_title','Data Santri')

@section('content')
<!-- ✅ CSS UNTUK HALAMAN INI -->
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
        display: flex;
        align-items: center;
        gap: 10px;
    }

    input[type="search"] {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 8px 12px;
        width: 200px;
    }

    select.filter {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 8px 12px;
    }

    /* Tombol Tambah Data */
    .btn-add {
        background: var(--btn-green);
        color: white;
        border: none;
        padding: 10px 18px;
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

    /* Responsif */
    @media (max-width: 900px) {
        .layout { grid-template-columns: 1fr; }
        .sidebar { display: none; }
    }
</style>

<!-- ✅ KONTEN UTAMA -->
<main class="content">
    <div class="content-header mb-3">
        <h2 class="fw-bold text-success">Data Santri</h2>

        <div class="search-filter">
            <!-- Search -->
            <input type="search" id="searchInput" placeholder="Search...">

            <!-- Filter Angkatan -->
            <select id="filterAngkatan" class="filter">
                <option value="">Semua Angkatan</option>
                @foreach($santri->pluck('angkatan')->unique()->filter() as $angkatan)
                    <option value="{{ $angkatan }}">{{ $angkatan }}</option>
                @endforeach
            </select>


            <!-- Tombol Tambah -->
            <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambahSantri">+ Tambah</button>
        </div>
    </div>

    <!-- Notifikasi sukses -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tabel Data -->
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
                <td>{{ $index + 1 }}</td>
                <td>{{ $s->nis }}</td>
                <td>{{ $s->nama }}</td>
                <td>{{ $s->angkatan ?? '-' }}</td>
                <td>{{ $s->status }}</td>
                <td>{{ $s->tahunAjaran->tahun ?? '-' }} - {{ $s->tahunAjaran->semester ?? '' }}</td>
                <td>
                    <div class="action-btns">
                        <!-- Tombol Edit -->
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

    <!-- Modal Edit Santri -->
    @foreach ($santri as $s)
    <div class="modal fade" id="editModal{{ $s->nis }}" tabindex="-1" aria-labelledby="editModalLabel{{ $s->nis }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('santri.update', $s->nis) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Santri</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</main>

<!-- Modal Tambah Santri -->
<div class="modal fade" id="modalTambahSantri" tabindex="-1" aria-labelledby="modalTambahSantriLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('santri.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahSantriLabel">Tambah Santri</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
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
        });
    }

    searchInput.addEventListener("input", filterTable);
    filterAngkatan.addEventListener("change", filterTable);
});
</script>

@endsection
