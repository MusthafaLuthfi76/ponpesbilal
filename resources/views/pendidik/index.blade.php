@extends('layouts.app')

@section('page_title', 'Data Pendidik')

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

/* Layout */
section.pendidik-page {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    padding: 1rem;
}

/* Header */
.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 0.5rem;
}
.header-section h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--green);
    margin: 0;
}

/* Tombol tambah */
.btn-add {
    background: var(--btn-green);
    color: #fff;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
    transition: .2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-add:hover { background: var(--btn-green-hover); }

/* Table */
.table-responsive {
    border-radius: 10px;
    overflow-x: auto;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    padding: 14px 20px;
    border-bottom: 1px solid #e5e7eb;
    font-size: 14px;
    text-align: left;
}
th {
    background: #f1f5f3;
    color: var(--green-dark);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
}

/* Atur lebar kolom yang proporsional */
th:nth-child(1), td:nth-child(1) { width: 80px; }  /* No */
th:nth-child(2), td:nth-child(2) { width: 100px; }  /* ID */
th:nth-child(3), td:nth-child(3) { width: 30%; } /* Nama */
th:nth-child(4), td:nth-child(4) { width: 30%; } /* Jabatan */
th:nth-child(5), td:nth-child(5) { width: 150px; text-align: center !important; } /* Aksi */

tbody tr {
    transition: background 0.2s;
}
tbody tr:hover { 
    background: #f9fdfb; 
}
tbody tr:last-child td {
    border-bottom: none;
}

/* Buttons */
.action-btns {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
}
.btn-sm {
    padding: 7px 12px;
    border-radius: 6px;
    border: none;
    color: white;
    font-size: 13px;
    cursor: pointer;
    transition: .2s;
}
.btn-warning { background: var(--btn-yellow); }
.btn-warning:hover { background: #b45309; }
.btn-danger { background: var(--btn-red); }
.btn-danger:hover { background: #7f1d1d; }

/* Notifikasi */
.alert-success {
    background: #d1fae5;
    color: #065f46;
    border-left: 4px solid var(--btn-green);
    padding: 14px 18px;
    border-radius: 8px;
    font-size: 14px;
    margin-bottom: 0.5rem;
}

/* MOBILE CARD VIEW */
@media(max-width: 768px) {
    table, thead, tbody, th, td, tr { display: block; }
    thead { display:none; }
    tbody tr {
        background:#fff;
        margin-bottom:1rem;
        padding:.75rem;
        border-radius:10px;
        box-shadow:0 1px 6px rgba(0,0,0,0.06);
    }
    td {
        display:flex;
        justify-content: space-between;
        padding: .4rem 0;
        border:none;
        width: 100% !important;
    }
    td::before {
        content: attr(data-label);
        font-weight:700;
        color:var(--green-dark);
    }
}
</style>

<section class="pendidik-page">

    <!-- Header -->
    <header class="header-section">
        <h2><i class="bi bi-people-fill"></i> Data Pendidik</h2>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambahPendidik">
            <i class="bi bi-plus-circle"></i> Tambah Pendidik
        </button>
    </header>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <!-- Table -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($pendidik as $index => $p)
                <tr>
                    <td data-label="No">{{ $index + 1 }}</td>
                    <td data-label="ID">{{ $p->id_pendidik }}</td>
                    <td data-label="Nama">{{ $p->nama }}</td>
                    <td data-label="Jabatan">{{ $p->jabatan }}</td>
                    <td data-label="Aksi">
                        <div class="action-btns">
                            <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $p->id_pendidik }}">
                                <i class="bi bi-pencil-fill"></i>
                            </button>

                            <form action="{{ route('pendidik.destroy', $p->id_pendidik) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus?')"
                                  style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editModal{{ $p->id_pendidik }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content border-0 shadow-sm">
                            <form action="{{ route('pendidik.update', $p->id_pendidik) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title">
                                        <i class="bi bi-pencil-square"></i> Edit Pendidik
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $p->nama) }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <label class="form-label mt-3">Jabatan</label>
                                    <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan', $p->jabatan) }}" required>
                                    @error('jabatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <label class="form-label mt-3">User</label>
                                    <select name="id_user" class="form-select" required>
                                        <option value="">-- Pilih User --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id_user }}"
                                                {{ $p->id_user == $user->id_user ? 'selected' : '' }}>
                                                {{ $user->id_user }} - {{ $user->nama }}
                                            </option>
                                        @endforeach
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

            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-3">
                        Belum ada data pendidik
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahPendidik" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-sm">
            <form action="{{ route('pendidik.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Tambah Pendidik</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <label class="form-label mt-3">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan') }}" required>
                    @error('jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <label class="form-label mt-3">User</label>
                    <select name="id_user" class="form-select @error('id_user') is-invalid @enderror" required>
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id_user }}" {{ old('id_user')==$user->id_user?'selected':'' }}>
                                {{ $user->id_user }} - {{ $user->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_user')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection