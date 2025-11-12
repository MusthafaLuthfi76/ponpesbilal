@extends('layouts.app')

@section('page_title', 'Data Pendidik')

@section('content')
<style>
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

    main.content {
        background: var(--panel);
        border-radius: 20px 0 0 0;
        padding: 30px;
    }

    .content-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .content-header h2 {
        color: var(--green);
        font-weight: 700;
        font-size: 22px;
    }

    .search-bar {
        display: flex;
        gap: 10px;
    }

    input[type="search"] {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 8px 12px;
        width: 200px;
    }

    .btn-add {
        background: var(--btn-green);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 14px;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-add:hover { background: var(--btn-green-hover); }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
    }

    th, td {
        padding: 12px 14px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
    }

    th {
        background: #f1f5f3;
        color: var(--green);
        font-weight: 600;
    }

    tr:hover { background: #f9fdfb; }

    .action-btns {
        display: flex;
        gap: 6px;
    }

    .btn {
        border: none;
        border-radius: 6px;
        padding: 6px 10px;
        color: white;
        cursor: pointer;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
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
        margin-bottom: 10px;
    }

</style>

<main class="content">
    <div class="content-header">
        <h2>Data Pendidik</h2>

        <div class="search-bar">
            <input type="search" id="searchInput" placeholder="Search...">
            <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambahPendidik">+ Tambah</button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID_PENDIDIK</th>
                <th>Nama Lengkap</th>
                <th>Jabatan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendidik as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->id_pendidik }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->jabatan }}</td>
                <td>
                    <div class="action-btns">
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $p->id_pendidik }}">✏️</button>
                        <form action="{{ route('pendidik.destroy', $p->id_pendidik) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">🗑️</button>
                        </form>
                    </div>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal{{ $p->id_pendidik }}" tabindex="-1" aria-labelledby="editModalLabel{{ $p->id_pendidik }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('pendidik.update', $p->id_pendidik) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">User</label>
                                    <select name="id_user" class="form-control" required>
                                        <option value="">-- Pilih User --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id_user }}" 
                                                {{ $p->id_user == $user->id_user ? 'selected' : '' }}>
                                                {{ $user->id_user }} - {{ $user->nama }}
                                            </option>

                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" value="{{ $p->nama }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jabatan</label>
                                    <input type="text" name="jabatan" class="form-control" value="{{ $p->jabatan }}" required>
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
            @empty
            <tr><td colspan="5" style="text-align:center;">Belum ada data pendidik</td></tr>
            @endforelse
        </tbody>
    </table>
</main>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahPendidik" tabindex="-1" aria-labelledby="modalTambahPendidikLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('pendidik.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Pendidik</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
    const rows = document.querySelectorAll("tbody tr");

    searchInput.addEventListener("input", function() {
        const query = this.value.toLowerCase();
        rows.forEach(row => {
            const nama = row.children[2].textContent.toLowerCase();
            const jabatan = row.children[3].textContent.toLowerCase();
            if (nama.includes(query) || jabatan.includes(query)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
});
</script>
@endsection
