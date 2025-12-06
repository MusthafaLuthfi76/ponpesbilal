@extends('layouts.app')

@section('page_title', 'Daftar Mata Pelajaran')

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

    /* ============================================
   HEADER SECTION
   ============================================ */

/* === HEADER WRAPPER === */
.header {
    display: flex;
    flex-direction: column;
    gap: 15px;
    padding: 20px 24px;
    border-bottom: 1px solid var(--border-color);
    background: #fff;
}

.header h3 {
    margin: 0;
    padding: 0;
    font-weight: 700;
    color: var(--green);
    font-size: 1.5rem;
    line-height: 1.3;
}

/* === RIGHT AREA (Mobile: Vertical Stack) === */
.header-right {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
}

/* === SEARCH BOX === */
.search-box {
    display: flex;
    align-items: center;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 0 14px;
    height: 46px;
    background: #fff;
    transition: border-color 0.2s;
}

.search-box:focus-within {
    border-color: var(--btn-green);
}

.search-box i {
    font-size: 15px;
    color: #666;
    flex-shrink: 0;
}

.search-box input {
    border: none;
    outline: none;
    flex: 1;
    margin-left: 10px;
    font-size: 14px;
    background: transparent;
    padding: 0;
}

.search-box input::placeholder {
    color: #999;
}

/* === FILTER BAR === */
.filter-box {
    display: flex;
    align-items: stretch;
    gap: 10px;
    width: 100%;
}

.filter-box select {
    flex: 1;
    height: 46px !important;
    padding: 0 40px 0 14px !important;
    border-radius: 8px !important;
    font-size: 14px !important;
    line-height: normal !important;
    border: 1px solid var(--border-color) !important;
    background-color: #fff !important;
    outline: none !important;
    cursor: pointer;
    
    /* Flexbox untuk centering vertikal */
    display: flex !important;
    align-items: center !important;
    
    /* Custom Arrow */
    appearance: none !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M6 9L1 4h10z'/%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 14px center !important;
}

.filter-box select:focus {
    border-color: var(--btn-green) !important;
    box-shadow: none !important;
}

/* === FILTER BUTTON === */
.filter-button {
    height: 46px !important;
    padding: 0 20px !important;
    border-radius: 8px !important;
    background: var(--btn-green) !important;
    border: none !important;
    color: #fff !important;
    font-size: 14px !important;
    font-weight: 500 !important;
    line-height: normal !important;
    cursor: pointer;
    white-space: nowrap;
    flex-shrink: 0;
    
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px;
    
    transition: background-color 0.2s;
}

.filter-button:hover {
    background: var(--btn-green-hover) !important;
}

.filter-button:focus {
    outline: none !important;
    box-shadow: none !important;
}

.filter-button i {
    font-size: 13px;
}

/* ============================================
   RESPONSIVE - DESKTOP LAYOUT
   ============================================ */
@media (min-width: 769px) {
    .header {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .header-right {
        flex-direction: row;
        width: auto;
        align-items: stretch;
        gap: 10px;
    }

    .search-box {
        width: 280px;
    }

    .filter-box {
        width: auto;
    }

    .filter-box select {
        width: 260px !important;
        flex: none !important;
    }
}

/* ============================================
   RESPONSIVE - TABLET
   ============================================ */
@media (min-width: 576px) and (max-width: 768px) {
    .search-box {
        width: 100%;
    }

    .filter-box select {
        min-width: 200px !important;
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
        vertical-align: middle;
    }

    thead th:nth-child(2) {
        text-align: left;
    }

    tbody td {
        padding: 12px;
        border-bottom: 1px solid #f0f0f0; 
        text-align: center;
        vertical-align: middle;
    }

    tbody td:nth-child(2) {
        text-align: left;
    }

    tbody tr:hover {
        background: #f9fdfb;
    }

    /* Tombol Aksi */
    .action-btns {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
    }

    .action-btn-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: none;
        color: #fff;
        transition: opacity 0.2s, transform 0.2s;
        padding: 0;
        flex-shrink: 0;
        text-decoration: none; 
    }

    .action-btn-link:hover {
        opacity: 0.85;
        transform: scale(1.05);
    }

    .btn-view { 
        background: var(--primary-color); 
    }

    /* Badge untuk Semester */
    .badge-semester {
        display: inline-block;
        padding: 4px 8px;
        font-size: 0.75rem;
        border-radius: 4px;
        background-color: #17a2b8;
        color: white;
        margin-left: 5px;
        vertical-align: middle;
    }

    /* 📱 TAMPILAN SCROLLABLE TABLE MOBILE */
    @media (max-width: 768px) {
        .container {
            margin: 0; 
            border-radius: 0;
            box-shadow: none;
        }

        .table-container {
            padding: 15px 0;
            overflow-x: auto; 
        }
        
        table {
            min-width: 700px;
            margin: 0 15px;
            border-radius: 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        thead {
            display: table-header-group;
        }
        
        tr {
            display: table-row;
            border: none;
            margin-bottom: 0;
            padding: 0;
            box-shadow: none;
            background: white;
        }

        td {
            display: table-cell;
            padding: 12px;
            border-bottom: 1px solid #f0f0f0; 
            text-align: center;
            font-size: 14px;
            position: static;
        }

        td:nth-child(2) {
            text-align: left;
        }
        
        td::before {
            content: none;
        }
    }
</style>

@section('content')

    <div class="container">
        {{-- HEADER (Search & Filter) --}}
        <header class="header" role="banner">
            <h3>📘 Daftar Mata Pelajaran</h3>
            <div class="header-right">
                <div class="search-box" role="search">
                    <i class="fas fa-search" aria-hidden="true"></i>
                    <input type="text" placeholder="Cari Mata Pelajaran..." id="searchInput" aria-label="Kolom Pencarian Mata Pelajaran">
                </div>
                <form method="GET" action="{{ route('nilaiakademik.mapel.index') }}" class="filter-box">
    <select name="id_tahun_ajaran" class="form-select">
    <option value="">Semua Tahun Ajaran</option>

    @foreach($tahunAjaranList as $ta)
        <option value="{{ $ta->id_tahun_ajaran }}"
            {{ $selectedTA == $ta->id_tahun_ajaran ? 'selected' : '' }}>
            {{ $ta->tahun }} - Semester {{ strtoupper($ta->semester) }}
        </option>
    @endforeach
</select>


    <button type="submit" class="filter-button">
        <i class="fas fa-filter"></i> Filter
    </button>
</form>


            </div>
        </header>

        {{-- KONTEN DATA TABEL --}}
        <div class="table-container">
            <table role="table" aria-label="Tabel Data Mata Pelajaran">
                <thead>
                    <tr>
                        <th scope="col" style="width: 8%;">NO</th>
                        <th scope="col" style="width: 30%;">MATA PELAJARAN</th>
                        <th scope="col" style="width: 25%;">TAHUN AJARAN</th>
                        <th scope="col" style="width: 25%;">PENDIDIK</th>
                        <th scope="col" style="width: 12%;">AKSI</th>
                    </tr>
                </thead>
                <tbody id="mapelTable">
                    @forelse ($mapel as $m)
                        <tr role="row" aria-label="Data mata pelajaran {{ $m->nama_matapelajaran }}">
                            <td role="cell">{{ $loop->iteration }}</td>
                            <td role="cell">{{ $m->nama_matapelajaran }}</td>
                            <td role="cell">
                                @if($m->tahunAjaran)
                                    {{ $m->tahunAjaran->tahun }}
                                    <span class="badge-semester">
                                        Semester {{ strtoupper($m->tahunAjaran->semester) }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td role="cell">{{ $m->pendidik->nama ?? '-' }}</td>
                            <td role="cell">
                                <div class="action-btns">
                                    <a href="{{ route('nilaiakademik.mapel.show', $m->id_matapelajaran) }}" 
                                       title="Lihat Detail"
                                       class="action-btn-link btn-view" 
                                       aria-label="Lihat detail mata pelajaran {{ $m->nama_matapelajaran }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="white">
                                            <path d="M11.5 18c4 0 7.46-2.22 9.24-5.5C18.96 9.22 15.5 7 11.5 7S4.04 9.22 2.26 12.5C4.04 15.78 7.5 18 11.5 18m0-12c4.56 0 8.5 2.65 10.36 6.5C20 16.35 16.06 19 11.5 19S3 16.35 1.14 12.5C3 8.65 6.94 6 11.5 6m0 2C14 8 16 10 16 12.5S14 17 11.5 17 7 15 7 12.5 9 8 11.5 8m0 1A3.5 3.5 0 0 0 8 12.5a3.5 3.5 0 0 0 3.5 3.5a3.5 3.5 0 0 0 3.5-3.5A3.5 3.5 0 0 0 11.5 9" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data mata pelajaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('mapelTable');
            const rows = tableBody.getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                let found = false;

                for (let row of rows) {
                    if (row.children.length > 1) { 
                        const text = row.textContent.toLowerCase();
                        if (text.includes(filter)) {
                            row.style.display = 'table-row';
                            found = true;
                        } else {
                            row.style.display = 'none';
                        }
                    } else {
                        row.style.display = 'none';
                    }
                }
                
                const noDataRow = document.querySelector('td[colspan="5"]');
                if (noDataRow) {
                    if (found || rows.length > 1 && filter === "") { 
                        noDataRow.parentNode.style.display = 'none';
                    } else if (filter !== "") { 
                        noDataRow.textContent = 'Tidak ada mata pelajaran yang cocok dengan kriteria.';
                        noDataRow.parentNode.style.display = 'table-row';
                    } else if (rows.length === 1 && filter === "") {
                        noDataRow.textContent = 'Belum ada data mata pelajaran.';
                        noDataRow.parentNode.style.display = 'table-row';
                    }
                }
            });
        });
    </script>

@endsection