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

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .content-header h2 {
            font-size: 20px;
            color: var(--green);
            font-weight: 700;
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
</body>
</html>
