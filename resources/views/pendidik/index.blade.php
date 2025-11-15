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
    gap: 1rem;
}

/* Header */
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

/* Tombol tambah */
.btn-add {
    background: var(--btn-green);
    color: #fff;
    border: none;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
    transition: .2s;
}
.btn-add:hover { background: var(--btn-green-hover); }

/* Table */
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
    color: var(--green-dark);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 13px;
}
tr:hover { background:#f9fdfb; }

/* Buttons */
.action-btns {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}
.btn-sm {
    padding: 6px 10px;
    border-radius: 6px;
    border: none;
    color: white;
    font-size: 13px;
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
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 14px;
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
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($pendidik as $index => $p)
                <tr>
                    <td data-label="No">{{ $index + 1 }}</td>
                    <td data-label="ID">{{ $p->id_pendidik }}</td>
                    <td data-label="Nama">{{ $p->nama }}</td>
                    <td data-label="Jabatan">{{ $p->jabatan }}</td>
                    <td data-label="Aksi" class="text-center">
                        <div class="action-btns">
                            <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $p->id_pendidik }}">
                                <i class="bi bi-pencil-fill"></i>
                            </button>

                            <form action="{{ route('pendidik.destroy', $p->id_pendidik) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus?')">
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
                                    <input type="text" name="nama" class="form-control" value="{{ $p->nama }}" required>

                                    <label class="form-label mt-3">Jabatan</label>
                                    <input type="text" name="jabatan" class="form-control" value="{{ $p->jabatan }}" required>

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
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button class="btn btn-warning text-white">Perbarui</button>
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
                    <input type="text" name="nama" class="form-control" required>

                    <label class="form-label mt-3">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" required>

                    <label class="form-label mt-3">User</label>
                    <select name="id_user" class="form-select" required>
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id_user }}">
                                {{ $user->id_user }} - {{ $user->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
