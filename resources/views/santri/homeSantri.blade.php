<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Santri - PPTQ Bilal bin Rabah Sukoharjo</title>
        <!-- ✅ Tambahkan ini -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }

        body { background: var(--bg); color: #0f1b14; }

        /* Topbar */
        .topbar {
            background: var(--green);
            color: #fff;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .topbar img { width: 40px; height: 40px; border-radius: 50%; }
        .topbar h1 { font-size: 18px; font-weight: 600; }

        /* Layout */
        .layout { display: grid; grid-template-columns: 250px 1fr; min-height: calc(100vh - 56px); }

        /* Sidebar */
        .sidebar {
            background: var(--green-dark);
            color: #e9fff3;
            padding: 20px;
            border-top-right-radius: 20px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }
        .side-title { display: flex; align-items: center; gap: 10px; font-weight: 600; margin-bottom: 20px; color: #cfe9d7; }
        .side-title img { width: 30px; height: 30px; }
        .menu a {
            display: block;
            text-decoration: none;
            color: #e9fff3;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: 0.3s;
        }
        .menu a.active, .menu a:hover { background: var(--accent); }

        /* Main Content */
        main.content {
            background: var(--panel);
            border-radius: 20px 0 0 0;
            padding: 30px;
        }


        .content-header h2 {
            font-size: 20px;
            color: var(--green);
            font-weight: 700;
        }

        .content-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

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
        .btn-add:hover { background: var(--btn-green-hover); }

        /* Table */
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
        th { background: #f1f5f3; font-weight: 600; color: #1f4a34; }
        tr:hover { background: #f9fdfb; }

        .status-select {
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 4px 6px;
            font-size: 13px;
        }

        /* Action Buttons */
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

        .alert {
            background: #d1fae5;
            color: #065f46;
            padding: 10px 14px;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        @media (max-width: 900px) {
            .layout { grid-template-columns: 1fr; }
            .sidebar { display: none; }
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div style="display:flex;align-items:center;gap:10px;">
            <img src="/img/logo.png" alt="Logo">
            <h1>PPTQ Bilal bin Rabah Sukoharjo</h1>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-add" style="background:#e7f5ec;color:#173e2b;">Logout</button>
        </form>
    </div>

    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="side-title">
                <img src="/img/logo.png" alt="Logo">
                <span>Menu Utama</span>
            </div>
            <nav class="menu">
                <a href="/dashboard">Dashboard</a>
                <a href="/santri" class="active">Data Santri</a>
                <a href="#">Mata Pelajaran</a>
                <a href="tahunajaran">Tahun Ajaran</a>
                <a href="#">Kelas</a>
                <a href="#">Kelompok Halaqah</a>
                <a href="#">Data Pendidik</a>
                <a href="#">Nilai Akademik</a>
                <a href="#">Nilai Tahfidz</a>
                <a href="#">Nilai Kesantrian</a>
                <a href="#">Laporan & Rapor</a>
            </nav>
        </aside>

        <!-- Main -->
        <main class="content">
            <div class="content-header mb-3">
                <h2 class="fw-bold text-success">Data Santri</h2>

                <div class="search-filter">
                    <!-- Search -->
                    <input type="search" id="searchInput" placeholder="Search...">

                    <!-- Filter Tahun Ajaran -->
                    <select id="filterTahunAjaran" class="filter">
                        <option value="">Tahun Ajaran</option>
                        @foreach($tahunajaran as $t)
                            <option value="{{ $t->id_tahunAjaran }}">{{ $t->tahun }} - {{ $t->semester }}</option>
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
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $s->nis }}">
                                    ✏️
                                </button>
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
    </div>

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
</body>
</html>
