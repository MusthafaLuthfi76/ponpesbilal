@extends('layouts.app')

@section('page_title', 'Data Tahun Ajaran')

@section('content')
<style>
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

/* 🧭 Layout utama */
section.tahun-ajaran {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* 🏷️ Header */
.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: .75rem;
}
.header-section h2 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--green);
}

/* ➕ Tombol Tambah */
.btn-add {
    background: var(--btn-green);
    color: #fff;
    border: none;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
    transition: 0.2s;
}
.btn-add:hover {
    background: var(--btn-green-hover);
}

/* 📋 Table styling */
.table-responsive {
    border-radius: 10px;
    overflow-x: auto;
    background: #fff;
    box-shadow: 0 1px 6px rgba(0,0,0,0.05);
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    padding: 12px 14px;
    border-bottom: 1px solid #e5e7eb;
    font-size: 14px;
}
th {
    background: #f1f5f3;
    font-weight: 600;
    color: var(--green-dark);
    text-transform: uppercase;
    font-size: 13px;
}
tr:hover {
    background: #f9fdfb;
}
/* Kolom AKSI fix width */
.aksi-col {
     width: 140px !important;
    text-align: center !important;
}

/* ⚙️ Aksi */
.action-btns {
    display: flex;
    justify-content: center;
    gap: 8px;
}
.btn-sm {
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 13px;
    border: none;
    color: #fff;
}
.btn-warning { background: var(--btn-yellow); }
.btn-warning:hover { background: #b45309; }
.btn-danger { background: var(--btn-red); }
.btn-danger:hover { background: #7f1d1d; }

/* ✅ Notifikasi */
.alert-success {
    background: #d1fae5;
    color: #065f46;
    border-left: 4px solid var(--btn-green);
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 14px;
}

/* RESPONSIVE: ubah tabel jadi card view di layar kecil */
@media (max-width: 768px) {
    table, thead, tbody, th, td, tr { display: block; }
    thead { display: none; }
    tbody tr {
        background:#fff;
        margin-bottom:1rem;
        border-radius:10px;
        box-shadow:0 1px 6px rgba(0,0,0,0.05);
        padding:.75rem;
    }
    td {
        border:none;
        display:flex;
        justify-content:space-between;
        padding:.5rem 0;
        font-size:14px;
    }
    td::before {
        content: attr(data-label);
        font-weight:600;
        color:var(--green-dark);
    }
}
/* 🌟 PREMIUM MODAL STYLE */
.modal.fade .modal-dialog {
    transform: translateY(-20px);
    transition: all .3s ease-out;
}

.modal.show .modal-dialog {
    transform: translateY(0);
}

.modal-content {
    border-radius: 14px !important;
    overflow: hidden;
    border: none !important;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}

.modal-header {
    padding: 16px 20px;
    border-bottom: none;
}

.modal-body {
    padding: 20px;
    max-height: 65vh;
    overflow-y: auto;
    background: #f9fafb;
}

.modal-footer {
    border-top: none;
    padding: 16px 20px;
    background: #f9fafb;
}

.modal-lg {
    max-width: 550px !important;
}

/* Input Style */
.modal .form-control, .modal .form-select {
    border-radius: 8px;
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    transition: .2s;
}

.modal .form-control:focus,
.modal .form-select:focus {
    border-color: #16a34a;
    box-shadow: 0 0 0 2px rgba(22,163,74,0.2);
}

/* Notifikasi error di modal */
.alert-danger {
    background: #fee2e2;
    border-left: 4px solid #dc2626;
    color: #7f1d1d;
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 13px;
}

</style>

<section class="tahun-ajaran">
    <header class="header-section">
        <h2><i class="bi bi-calendar3"></i> Data Tahun Ajaran</h2>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambahTahunAjaran">
            <i class="bi bi-plus-circle"></i> Tambah Tahun
        </button>
    </header>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tahun</th>
                    <th>Semester</th>
                    <th class="aksi-col">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($tahunajaran as $index => $t)
            <tr>
                <td data-label="No">{{ $index + 1 }}</td>
                <td data-label="Tahun">{{ $t->tahun }}</td>
                <td data-label="Semester">{{ $t->semester }}</td>
                <td data-label="Aksi" class="text-end">
                    <div class="action-btns">
                        <button class="btn btn-warning btn-sm" title="Edit"
                            data-bs-toggle="modal" data-bs-target="#editModal{{ $t->id_tahunAjaran }}">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <form action="{{ route('tahunajaran.destroy', $t->id_tahunAjaran) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" title="Hapus">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted py-3">Belum ada data tahun ajaran</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3 d-flex justify-content-between align-items-center">
    <div class="small text-muted">
        Menampilkan {{ $tahunajaran->firstItem() }}–{{ $tahunajaran->lastItem() }}
        dari {{ $tahunajaran->total() }} data
    </div>

    {{ $tahunajaran->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>

</section>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahTahunAjaran" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('tahunajaran.store') }}" method="POST" onsubmit="return validateTahunAjaran(this)">
                @csrf

                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Tambah Tahun Ajaran</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <label class="form-label">Tahun Ajaran</label>
                    <input type="text" name="tahun" class="form-control"
                        placeholder="2024/2025" required
                        pattern="^[0-9]{4}/[0-9]{4}$"
                        title="Gunakan format 2024/2025">

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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('tahunajaran.update', $t->id_tahunAjaran) }}" method="POST"
                  onsubmit="return validateTahunAjaran(this)">
                @csrf
                @method('PUT')

                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Tahun Ajaran</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label class="form-label">Tahun Ajaran</label>
                    <input type="text" name="tahun" value="{{ $t->tahun }}" class="form-control"
                           required pattern="^[0-9]{4}/[0-9]{4}$"
                           title="Gunakan format 2024/2025">

                    <label class="form-label mt-3">Semester</label>
                    <select name="semester" class="form-select" required>
                        <option value="GANJIL" {{ $t->semester=='GANJIL'?'selected':'' }}>GANJIL</option>
                        <option value="GENAP" {{ $t->semester=='GENAP'?'selected':'' }}>GENAP</option>
                    </select>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white">Perbarui</button>
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

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('modalTambahTahunAjaran'));
        modal.show();
    });
</script>
@endif

@endsection
