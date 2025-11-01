@extends('layouts.app')

@section('page_title','Data Tahun Ajaran')

@section('content')

<style>
/* 🌿 WARNA UTAMA */
:root {
    --green: #1f4a34;
    --green-dark: #173e2b;
    --light-green: #e8f5e9;
    --panel: #ffffff;
    --btn-green: #16a34a;
    --btn-green-hover: #15803d;
    --btn-red: #dc2626;
    --btn-yellow: #f59e0b;
}

/* 🧩 AREA UTAMA */
main.content {
    background: var(--panel);
    border-radius: 20px 0 0 0;
    padding: 30px;
    min-height: 100vh;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
}

/* 🏷️ HEADER */
.content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 20px;
}
.content-header h2 {
    font-size: 22px;
    font-weight: 700;
    color: var(--green);
    margin: 0;
}

/* 🔍 SEARCH DAN FILTER */
.search-filter {
    display: flex;
    align-items: center;
    gap: 10px;
}
input[type="search"], select.filter {
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 14px;
    transition: 0.2s;
}
input[type="search"]:focus, select.filter:focus {
    border-color: var(--green);
    outline: none;
    box-shadow: 0 0 4px rgba(31, 74, 52, 0.3);
}

/* ➕ TOMBOL TAMBAH DATA */
.btn-add {
    background: var(--btn-green);
    color: #fff;
    border: none;
    padding: 9px 16px;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s;
}
.btn-add:hover {
    background: var(--btn-green-hover);
    transform: translateY(-1px);
}

/* 📋 TABEL DATA */
table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
}
th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
    font-size: 14px;
}
th {
    background: #f1f5f3;
    font-weight: 600;
    color: var(--green);
    text-transform: uppercase;
    font-size: 13px;
}
tr:hover {
    background: #f9fdfb;
}

/* ⚙️ AKSI EDIT/HAPUS */
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
    transition: 0.2s;
}
.btn-warning { background: var(--btn-yellow); }
.btn-danger { background: var(--btn-red); }
.btn-warning:hover { background: #b45309; }
.btn-danger:hover { background: #7f1d1d; }

/* ✅ NOTIFIKASI SUKSES */
.alert {
    background: #d1fae5;
    color: #065f46;
    padding: 10px 14px;
    border-radius: 6px;
    margin-bottom: 10px;
    border-left: 5px solid var(--btn-green);
    font-size: 14px;
}

/* 📱 RESPONSIF */
@media (max-width: 768px) {
    .content-header {
        flex-direction: column;
        align-items: flex-start;
    }
    .search-filter {
        width: 100%;
        flex-wrap: wrap;
    }
    input[type="search"], select.filter {
        width: 100%;
    }
    table {
        font-size: 13px;
    }
}

</style>


    <!-- Content -->
    <main class="content">
        <div class="content-header d-flex justify-content-between align-items-center mb-3">
            <h4>Data Tahun Ajaran</h4>
            <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambahTahunAjaran">+ Tambah Tahun</button>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tahun</th>
                    <th>Semester</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tahunajaran as $index => $t)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $t->tahun }}</td>
                        <td>{{ $t->semester }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $t->id_tahunAjaran }}">✏️</button>
                            <form action="{{ route('tahunajaran.destroy', $t->id_tahunAjaran) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada data tahun ajaran</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </main>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahTahunAjaran" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('tahunajaran.store') }}" method="POST" onsubmit="return validateTahunAjaran(this)">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tahun Ajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Tahun Ajaran</label>
                    <input type="text" name="tahun" class="form-control" placeholder="2024/2025" required pattern="^[0-9]{4}/[0-9]{4}$" title="Gunakan format 2024/2025">
                    <label class="form-label mt-3">Semester</label>
                    <select name="semester" class="form-select" required>
                        <option value="GANJIL">GANJIL</option>
                        <option value="GENAP">GENAP</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
@foreach($tahunajaran as $t)
<div class="modal fade" id="editModal{{ $t->id_tahunAjaran }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('tahunajaran.update', $t->id_tahunAjaran) }}" method="POST" onsubmit="return validateTahunAjaran(this)">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tahun Ajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Tahun Ajaran</label>
                    <input type="text" name="tahun" value="{{ $t->tahun }}" class="form-control" required pattern="^[0-9]{4}/[0-9]{4}$" title="Gunakan format 2024/2025">
                    <label class="form-label mt-3">Semester</label>
                    <select name="semester" class="form-select" required>
                        <option value="GANJIL" {{ $t->semester=='GANJIL'?'selected':'' }}>GANJIL</option>
                        <option value="GENAP" {{ $t->semester=='GENAP'?'selected':'' }}>GENAP</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
function validateTahunAjaran(form) {
    const input = form.querySelector('[name="tahun"]');
    const value = input.value.trim();
    const pattern = /^(\d{4})\/(\d{4})$/;
    const match = value.match(pattern);

    if (!match) {
        alert('Format tahun ajaran harus seperti 2024/2025');
        return false;
    }

    const startYear = parseInt(match[1]);
    const endYear = parseInt(match[2]);
    if (endYear - startYear !== 1) {
        alert('Tahun ajaran tidak valid! Selisih tahun harus 1, contoh: 2024/2025');
        return false;
    }
    return true;
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection