@extends('layouts.app')

@section('page_title', 'Nilai Kesantrian')

{{-- Bootstrap & Font Awesome --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    :root {
        --primary-color: #28a745;
        --secondary-color: #ffc107;
        --delete-color: #dc3545;
        --border-color: #dee2e6;
        --text-color: #212529;
        --green: #1f4a34;
        --btn-green: #234f3a;
        --btn-green-hover: #1a3a2b;
        --btn-yellow: #d97706;
        --btn-red: #b91c1c;
    }

    /* Penyesuaian Kontainer & Layout */
    .container {
        max-width: 1200px;
        margin: 30px auto;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        padding: 0; 
    }

    /* Header (Dibuat lebih responsif untuk mobile) */
    .header {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding: 20px;
        border-bottom: 1px solid var(--border-color);
        gap: 10px;
    }
    
    .header h3 {
        margin-bottom: 0;
        font-weight: 700;
        color: var(--green);
    }

    .header-right {
        display: flex;
        flex-direction: column;
        width: 100%;
        gap: 10px;
    }

    .filter-box {
        display: flex;
        align-items: center;
        border: 1px solid var(--border-color);
        border-radius: 6px; 
        padding: 6px 10px;
        width: 100%; 
        background: white;
        height: 38px;
    }

    .filter-box select {
        border: none;
        outline: none;
        margin-left: 8px;
        flex-grow: 1;
        background: transparent;
        font-size: 14px;
    }

    .filter-box i {
        font-size: 14px;
        color: #6c757d;
    }

    .add-button {
        background-color: var(--btn-green); 
        color: white;
        padding: 8px 14px; 
        border-radius: 6px; 
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        border: none;
        cursor: pointer;
        font-size: 14px;
        height: 38px;
        white-space: nowrap;
    }

    .add-button:hover {
        background-color: var(--btn-green-hover);
        color: white;
    }
    
    /* Media Query untuk Desktop */
    @media (min-width: 769px) {
        .header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        .header-right {
            flex-direction: row;
            width: auto;
        }
        .filter-box {
            width: auto;
            min-width: 250px;
        }
        .add-button {
            width: auto;
        }
    }

    /* Tampilan Tabel Dasar (untuk Desktop) */
    .table-container {
        padding: 20px;
        overflow-x: auto; 
    }
    
    table {
        min-width: 700px;
        width: 100%;
        border-collapse: collapse;
    }
    
    thead th {
        background-color: #f1f5f3; 
        font-weight: 600;
        color: var(--green);
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 12px;
        border-bottom: 2px solid var(--border-color);
        text-align: center;
    }
    
    thead th:nth-child(2) {
        text-align: left;
    }
    
    tbody td {
        padding: 12px;
        border-bottom: 1px solid #f0f0f0; 
        text-align: center;
    }
    
    tbody td:nth-child(2) {
        text-align: left;
    }
    
    tbody tr:hover {
        background: #f9fdfb;
    }

    /* Tombol Aksi */
    .action-btn-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        color: #fff;
        transition: 0.2s;
        text-decoration: none;
        font-size: 0.875rem;
        background: var(--primary-color);
    }
    
    .action-btn-link:hover {
        opacity: 0.85;
        transform: scale(1.05);
        color: #fff;
    }

    /* Badge styling */
    .badge {
        font-size: 0.75rem;
        padding: 4px 8px;
    }

    /* Desktop table */
    .table-desktop {
        display: table;
        width: 100%;
    }

    /* Mobile cards */
    .cards-mobile {
        display: none;
    }

    /* 📱 TAMPILAN CARD VIEW MOBILE - seperti Mata Pelajaran */
    @media (max-width: 768px) {
        .container {
            margin: 0; 
            border-radius: 0;
            box-shadow: none;
        }

        .table-container {
            padding: 15px;
        }
        
        /* Hide desktop table */
        .table-desktop {
            display: none !important;
        }

        /* Show mobile cards */
        .cards-mobile {
            display: block !important;
        }

        .kesantrian-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .kesantrian-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-color: var(--btn-green);
        }

        .kesantrian-card h6 {
            color: var(--green);
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .kesantrian-card .info-text {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .kesantrian-card .action-btns {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .kesantrian-card .btn-sm {
            flex: 1;
            min-width: 100px;
        }
    }
</style>

@section('content')

<div class="container">
    {{-- HEADER --}}
    <header class="header" role="banner">
        <h3>📚 Daftar Penilaian Kesantrian</h3>
        <div class="header-right">
            <form method="GET" action="{{ route('nilaikesantrian.index') }}" class="filter-box">
                <i class="fas fa-filter" aria-hidden="true"></i>
                <select name="id_tahunAjaran" class="form-select-custom" onchange="this.form.submit()" aria-label="Filter Tahun Ajaran">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach($tahunAjaran as $ta)
                        <option value="{{ $ta->id_tahunAjaran }}" {{ request('id_tahunAjaran') == $ta->id_tahunAjaran ? 'selected' : '' }}>
                            {{ $ta->tahun }} ({{ $ta->semester }})
                        </option>
                    @endforeach
                </select>
            </form>
            <button class="add-button" data-bs-toggle="modal" data-bs-target="#tambahMapelKesantrianModal" aria-label="Tambah Data Nilai Kesantrian">
                <i class="fas fa-plus" aria-hidden="true"></i> Tambah Tahun Ajaran
            </button>
        </div>
    </header>

    {{-- KONTEN DATA TABEL --}}
    <div class="table-container">
        <!-- Desktop Table View -->
        <table class="table-desktop text-center" role="table" aria-label="Tabel Data Nilai Kesantrian">
            <thead>
                <tr>
                    <th scope="col" style="width: 8%;">NO</th>
                    <th scope="col" style="width: 40%; text-align: left;">TAHUN AJARAN</th>
                    <th scope="col" style="width: 25%;">SEMESTER</th>
                    <th scope="col" style="width: 15%;">SANTRI</th>
                    <th scope="col" style="width: 22%;">AKSI</th>
                </tr>
            </thead>
            <tbody id="kesantrianTable">
                @forelse($nilaiKesantrianList as $item)
                <tr role="row" aria-label="Data kesantrian {{ $item->tahunAjaran->tahun ?? '-' }}">
                    <td role="cell">{{ $loop->iteration }}</td>
                    <td role="cell" style="text-align: left;">
                        <strong>{{ $item->tahunAjaran->tahun ?? '-' }}</strong>
                    </td>
                    <td role="cell">
                        <span class="badge bg-info">Semester {{ strtoupper($item->tahunAjaran->semester ?? '-') }}</span>
                    </td>
                    <td role="cell">{{ $item->total_santri ?? 0 }}</td>
                    <td role="cell" class="text-center">
                        <div style="display: flex; gap: 6px; justify-content: center;">
                            <a href="{{ route('nilaikesantrian.show', ['id_tahunAjaran' => $item->id_tahunAjaran]) }}" 
                               class="btn btn-sm btn-info"
                               title="Input Nilai"
                               aria-label="Input nilai kesantrian">
                                <i class="bi bi-pencil-fill"></i> Input Nilai
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Belum ada data penilaian kesantrian.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Mobile Card View -->
        <div class="cards-mobile">
            @forelse($nilaiKesantrianList as $item)
                <div class="kesantrian-card" onclick="window.location.href='{{ route('nilaikesantrian.show', ['id_tahunAjaran' => $item->id_tahunAjaran]) }}'">
                    <h6>{{ $item->tahunAjaran->tahun ?? '-' }}</h6>
                    <p class="info-text mb-2">
                        <strong>Semester:</strong> {{ strtoupper($item->tahunAjaran->semester ?? '-') }}
                    </p>
                    <p class="info-text mb-2">
                        <strong>Santri:</strong> {{ $item->total_santri ?? 0 }}
                    </p>
                    <div class="action-btns" onclick="event.stopPropagation()">
                        <a href="{{ route('nilaikesantrian.show', ['id_tahunAjaran' => $item->id_tahunAjaran]) }}" 
                           class="btn btn-sm btn-info">
                            <i class="bi bi-pencil-fill"></i> Input Nilai
                        </a>
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center">Belum ada data penilaian kesantrian.</div>
            @endforelse
        </div>
    </div>
</div>

{{-- MODAL TAMBAH MATA PELAJARAN KESANTRIAN --}}
<div class="modal fade" id="tambahMapelKesantrianModal" tabindex="-1" aria-labelledby="tambahMapelKesantrianModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="tambahMapelKesantrianModalLabel">Tambah Data Nilai Kesantrian Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('nilaikesantrian.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    {{-- Dropdown Tahun Ajaran --}}
                    <div class="mb-3">
                        <label for="id_tahunAjaran_modal" class="form-label">Pilih Tahun Ajaran:</label>
                        <select name="id_tahunAjaran" id="id_tahunAjaran_modal" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Tahun Ajaran --</option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id_tahunAjaran }}">
                                    {{ $ta->tahun }} ({{ $ta->semester }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


@endsection