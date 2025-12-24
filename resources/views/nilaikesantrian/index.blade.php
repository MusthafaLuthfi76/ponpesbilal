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
                <i class="fas fa-plus" aria-hidden="true"></i> Tambah Data
            </button>
        </div>
    </header>

    {{-- KONTEN DATA TABEL --}}
    <div class="table-container">
        <table class="text-center" role="table" aria-label="Tabel Data Nilai Kesantrian">
            <thead>
                <tr>
                    <th scope="col" style="width: 8%;">NO</th>
                    <th scope="col" style="width: 30%; text-align: left;">MATA PELAJARAN</th>
                    <th scope="col" style="width: 35%;">TAHUN AJARAN</th>
                    <th scope="col" style="width: 27%;">AKSI</th>
                </tr>
            </thead>
            <tbody id="kesantrianTable">
                @forelse($nilaiKesantrianList as $item)
                <tr role="row" aria-label="Data kesantrian {{ $item->mataPelajaran->nama_matapelajaran }}">
                    <td role="cell">{{ $loop->iteration }}</td>
                    <td role="cell" style="text-align: left;">
                        <strong>{{ $item->mataPelajaran->nama_matapelajaran ?? '-' }}</strong>
                    </td>
                    <td role="cell">
                        {{ $item->tahunAjaran->tahun ?? '-' }}
                        <br>
                        <span class="badge bg-info">Semester {{ strtoupper($item->tahunAjaran->semester ?? '-') }}</span>
                    </td>
                    <td role="cell" class="text-center">
                        <div style="display: flex; gap: 6px; justify-content: center;">
                            <a href="{{ route('nilaikesantrian.show', ['id_matapelajaran' => $item->id_matapelajaran, 'id_tahunAjaran' => $item->id_tahunAjaran]) }}" 
                               class="btn btn-sm btn-info"
                               title="Input Nilai"
                               aria-label="Input nilai kesantrian">
                                <i class="bi bi-pencil-fill"></i> Input Nilai
                            </a>
                            <button class="btn btn-sm btn-warning" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editMapelKesantrianModal"
                                    data-id="{{ $item->id_matapelajaran }}"
                                    data-nama="{{ $item->mataPelajaran->nama_matapelajaran }}"
                                    data-kkm="{{ $item->mataPelajaran->kkm }}"
                                    data-bobot-uts="{{ $item->mataPelajaran->bobot_UTS }}"
                                    data-bobot-uas="{{ $item->mataPelajaran->bobot_UAS }}"
                                    data-bobot-praktik="{{ $item->mataPelajaran->bobot_praktik }}"
                                    data-pendidik="{{ $item->mataPelajaran->id_pendidik }}"
                                    title="Edit Mata Pelajaran">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteMapelKesantrianModal"
                                    data-id="{{ $item->id_matapelajaran }}"
                                    data-nama="{{ $item->mataPelajaran->nama_matapelajaran }}"
                                    title="Hapus Mata Pelajaran">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">Belum ada data penilaian kesantrian.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
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
                    {{-- Dropdown Mata Pelajaran Kesantrian (Template) --}}
                    <div class="mb-3">
                        <label for="id_matapelajaran_modal" class="form-label">Pilih Template Mata Pelajaran Kesantrian:</label>
                        <select name="id_matapelajaran_template" id="id_matapelajaran_modal" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Mata Pelajaran --</option>
                            @foreach($matapelajaranKesantrian as $mapel)
                                <option value="{{ $mapel->id_matapelajaran }}">
                                    {{ $mapel->nama_matapelajaran }}
                                </option>
                            @endforeach
                        </select>
                    </div>

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

{{-- MODAL EDIT MATA PELAJARAN KESANTRIAN --}}
<div class="modal fade" id="editMapelKesantrianModal" tabindex="-1" aria-labelledby="editMapelKesantrianModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editMapelKesantrianModalLabel">Edit Mata Pelajaran Kesantrian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editMapelForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama" class="form-label">Nama Mata Pelajaran</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama_matapelajaran" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_kkm" class="form-label">KKM</label>
                        <input type="number" class="form-control" id="edit_kkm" name="kkm" min="0" max="100" required>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="edit_uts" class="form-label">Bobot UTS</label>
                            <input type="number" class="form-control bobot-input-edit" id="edit_uts" name="bobot_UTS" min="0" max="100" required>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_uas" class="form-label">Bobot UAS</label>
                            <input type="number" class="form-control bobot-input-edit" id="edit_uas" name="bobot_UAS" min="0" max="100" required>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_praktik" class="form-label">Bobot Praktik</label>
                            <input type="number" class="form-control bobot-input-edit" id="edit_praktik" name="bobot_praktik" min="0" max="100" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="alert alert-info mb-0">
                                <strong>Total Bobot:</strong> <span id="edit_total_bobot">0</span>% 
                                <span id="edit_bobot_status" class="ms-2"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning" id="edit_submit_btn">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL DELETE MATA PELAJARAN KESANTRIAN --}}
<div class="modal fade" id="deleteMapelKesantrianModal" tabindex="-1" aria-labelledby="deleteMapelKesantrianModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteMapelKesantrianModalLabel">Hapus Mata Pelajaran Kesantrian</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteMapelForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus mata pelajaran <strong id="delete_nama"></strong>?</p>
                    <p class="text-danger small mb-0"><i class="bi bi-exclamation-circle"></i> Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data nilai kesantrian terkait.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // ===== EDIT MATA PELAJARAN MODAL =====
    const editMapelModal = document.getElementById('editMapelKesantrianModal');
    editMapelModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        
        document.getElementById('edit_nama').value = button.getAttribute('data-nama');
        document.getElementById('edit_kkm').value = button.getAttribute('data-kkm');
        document.getElementById('edit_uts').value = button.getAttribute('data-bobot-uts');
        document.getElementById('edit_uas').value = button.getAttribute('data-bobot-uas');
        document.getElementById('edit_praktik').value = button.getAttribute('data-bobot-praktik');
        
        document.getElementById('editMapelForm').action = `/nilai-kesantrian/${id}`;
        updateEditBobot();
    });

    // Track bobot input changes
    document.querySelectorAll('#editMapelKesantrianModal .bobot-input-edit').forEach(input => {
        input.addEventListener('input', updateEditBobot);
    });

    function updateEditBobot() {
        const uts = parseFloat(document.getElementById('edit_uts').value) || 0;
        const uas = parseFloat(document.getElementById('edit_uas').value) || 0;
        const praktik = parseFloat(document.getElementById('edit_praktik').value) || 0;
        
        const total = uts + uas + praktik;
        const totalSpan = document.getElementById('edit_total_bobot');
        const statusSpan = document.getElementById('edit_bobot_status');
        
        totalSpan.textContent = total.toFixed(2);
        
        if (total === 100) {
            statusSpan.innerHTML = '<span class="badge bg-success">✓ Sesuai (100%)</span>';
        } else if (total < 100) {
            statusSpan.innerHTML = `<span class="badge bg-warning">Kurang ${(100 - total).toFixed(2)}%</span>`;
        } else {
            statusSpan.innerHTML = `<span class="badge bg-danger">Lebih ${(total - 100).toFixed(2)}%</span>`;
        }
    }

    // ===== DELETE MATA PELAJARAN MODAL =====
    const deleteMapelModal = document.getElementById('deleteMapelKesantrianModal');
    deleteMapelModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const nama = button.getAttribute('data-nama');
        
        document.getElementById('delete_nama').textContent = nama;
        document.getElementById('deleteMapelForm').action = `/nilai-kesantrian/${id}`;
    });
</script>

@endsection