<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Sistem Informasi Pesantren</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --green: #1f4a34;
            --green2: #305d47;
            --panel: #e3ede6;
            --bg: #cdd9cf;
            --card-bg: #2b5d45;
            --card-bg-dark: #1c3f2d;
            --primary-text: #0f1b14;
            --secondary-text: #1b3126;
            --accent-color: #cfe9d7;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: var(--bg);
            color: var(--primary-text);
            line-height: 1.6;
        }

        .topbar {
            background: var(--green);
            color: #fff;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .topbar img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .topbar h1 {
            font-size: 18px;
            margin: 0;
        }

        .layout {
            display: grid;
            grid-template-columns: 220px 1fr;
            min-height: calc(100vh - 56px);
            gap: 20px;
            padding: 20px;
        }

        .sidebar {
            background: #173e2b;
            color: rgb(7, 46, 19);
            padding: 14px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .side-title {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #cfe9d7;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .menu a {
            text-decoration: none;
            color: #e9fff3;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 15px;
            transition: background 0.3s ease;
        }

        .menu a.active,
        .menu a:hover {
            background: #234f3a;
        }

        .content {
            padding: 20px;
            background: var(--panel);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .welcome {
            background: #e6f3ea;
            color: var(--secondary-text);
            border: 1px solid #d7e5dc;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(260px, 1fr));
            gap: 20px;
        }

        .card {
            background: linear-gradient(180deg, var(--card-bg) 0%, var(--card-bg-dark) 100%);
            color: #fff;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card .value {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .card .label {
            font-size: 16px;
            opacity: 0.85;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        /* Styling form */
        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: var(--secondary-text);
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            background: #fff;
            color: var(--primary-text);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--green);
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-success {
            background: var(--green);
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .container h2 {
            margin-bottom: 20px;
            color: var(--secondary-text);
        }

        @media (max-width: 840px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: none;
            }

            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="topbar">
        <img src="/img/logo.png" alt="Logo" />
        <h1>Dashboard</h1>
        <div style="margin-left:auto; display:flex; align-items:center; gap:12px;">
            <span>Halo, {{ $user?->name ?? 'Pengguna' }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    style="background: var(--accent-color); color: #173e2b; border: none; border-radius: 6px; padding: 8px 14px; cursor: pointer;">Logout</button>
            </form>
        </div>
    </div>

    <div class="layout">
        <aside class="sidebar">
            <div class="side-title">
                <img src="/img/logo.png" alt="Logo" style="width:28px;height:28px;" />
                <span>PPTQ Bilal bin Rabah Sukoharjo</span>
            </div>
            <nav class="menu">
                <a href="/dashboard">Dashboard</a>
                <a href="/santri" class="active">Santri</a>
                <a href="#">Mata Pelajaran</a>
                <a href="#">Tahun Ajaran</a>
                <a href="#">Kelas</a>
                <a href="#">Kelompok Halqah</a>
                <a href="#">Data Pendidikan</a>
                <a href="#">Nilai Akademik</a>
                <a href="#">Nilai Tahfidz</a>
                <a href="#">Nilai Kesantrian</a>
                <a href="#">Laporan & Rapor</a>
            </nav>
        </aside>
        <main class="content">
            <div class="container">
                <h2>Tambah Data Santri</h2>
                <form action="{{ route('santri.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nis">NIS</label>
                        <input type="text" id="nis" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis') }}" required>
                        @error('nis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="angkatan">Angkatan</label>
                        <input type="text" id="angkatan" name="angkatan" class="form-control @error('angkatan') is-invalid @enderror" value="{{ old('angkatan') }}" placeholder="Isi angka saja, contoh: 2024">
                        @error('angkatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="MA" {{ old('status')=='MA'?'selected':'' }}>Madrasah Aliyah (MA)</option>
                            <option value="MTS" {{ old('status')=='MTS'?'selected':'' }}>Madrasah Tsanawiyah (MTS)</option>
                            <option value="Alumni" {{ old('status')=='Alumni'?'selected':'' }}>Alumni</option>
                            <option value="Keluar" {{ old('status')=='Keluar'?'selected':'' }}>Keluar</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_tahunAjaran">Tahun Ajaran</label>
                        <select id="id_tahunAjaran" name="id_tahunAjaran" class="form-control @error('id_tahunAjaran') is-invalid @enderror" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach($tahunajaran as $ta)
                                <option value="{{ $ta->id_tahunAjaran }}" {{ old('id_tahunAjaran')==$ta->id_tahunAjaran?'selected':'' }}>
                                    {{ $ta->tahun }} - {{ $ta->semester }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_tahunAjaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('santri.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </main>
    </div>
</body>

</html>
