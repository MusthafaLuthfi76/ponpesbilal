@extends('layouts.app')

@section('page_title', 'Nilai Mata Pelajaran')

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
        --bg-light: #f8f9fa;
    }

    body {
        background-color: #e8f5e9;
    }

    .container-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px 15px;
    }

    .page-header {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px 25px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .page-header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .page-header h4 {
        margin: 0;
        color: var(--primary-color);
        font-weight: 600;
    }

    .back-btn, .assign-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
        padding: 8px 16px;
        border: 1px solid var(--primary-color);
        border-radius: 5px;
        background: white;
    }

    .back-btn:hover, .assign-btn:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .assign-btn {
        background-color: var(--primary-color);
        color: white;
    }

    .assign-btn:hover {
        background-color: #1e7e34;
    }

    .mapel-info-card {
        background: linear-gradient(135deg, var(--primary-color) 0%, #1e7e34 100%);
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 20px;
        color: white;
    }

    .mapel-info-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .mapel-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .mapel-details h5 {
        margin: 0 0 5px 0;
        font-weight: 600;
        font-size: 22px;
        line-height: 1.2;
    }

    .mapel-details p {
        margin: 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .mapel-stats {
        display: flex;
        gap: 30px;
        padding-top: 15px;
        border-top: 1px solid rgba(255, 255, 255, 0.3);
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .stat-item i {
        font-size: 20px;
        opacity: 0.9;
    }

    .stat-item div {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12px;
        opacity: 0.8;
    }

    .stat-value {
        font-size: 18px;
        font-weight: 600;
    }

    .nilai-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .nilai-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        background-color: var(--bg-light);
        border-bottom: 1px solid var(--border-color);
    }

    .nilai-header h5 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .save-btn-wrapper {
        padding: 15px 25px;
        display: flex;
        justify-content: flex-end;
        border-top: 1px solid var(--border-color);
        background-color: var(--bg-light);
    }

    .save-btn {
        background-color: var(--primary-color);
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .save-btn:hover {
        background-color: #1e7e34;
        transform: translateY(-1px);
    }

    /* Table Styling */
    .table-responsive {
        max-height: 70vh;
        overflow-y: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead th {
        background: linear-gradient(135deg, var(--primary-color) 0%, #1e7e34 100%);
        color: white !important;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 12px 15px;
        border-bottom: 2px solid var(--border-color);
        font-weight: 600;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    tbody td {
        padding: 12px 10px;
        border-bottom: 1px solid var(--border-color);
        text-align: center;
    }

    tbody tr:hover {
        background-color: #eef6ff;
        transition: .2s;
    }

    .nilai-input {
        width: 80px;
        padding: 8px;
        border: 2px solid var(--border-color);
        border-radius: 5px;
        text-align: center;
        font-weight: 500;
    }

    .nilai-input:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
    }

    .rata-input {
        background-color: var(--bg-light);
        font-weight: 600;
        color: var(--primary-color);
    }

    /* Predikat Badges */
    .predikat {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .predikat-A {
        background-color: #d4edda;
        color: #155724;
    }

    .predikat-B {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .predikat-C {
        background-color: #fff3cd;
        color: #856404;
    }

    .predikat-D {
        background-color: #f8d7da;
        color: #721c24;
    }

    .action-btn {
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        color: #fff;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--delete-color);
    }

    .action-btn:hover {
        opacity: 0.85;
        transform: scale(1.05);
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        body {
            background-color: #f5f5f5;
        }

        .container-wrapper {
            padding: 0 0 20px 0;
        }

        .page-header {
            border-radius: 0;
            flex-direction: column;
            align-items: flex-start;
            padding: 15px;
            margin-bottom: 15px;
        }

        .page-header-left {
            margin-bottom: 10px;
            width: 100%;
        }

        .page-header h4 {
            font-size: 18px;
        }

        .back-btn, .assign-btn {
            width: 100%;
            justify-content: center;
            margin-bottom: 8px;
        }

        .mapel-info-card {
            border-radius: 0;
            padding: 20px 15px;
            margin-bottom: 15px;
        }

        .mapel-icon {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }

        .mapel-details h5 {
            font-size: 18px;
        }

        .mapel-stats {
            flex-wrap: wrap;
            gap: 15px;
        }

        .stat-item {
            flex: 1;
            min-width: calc(50% - 8px);
        }

        .nilai-card {
            border-radius: 0;
        }

        .nilai-header {
            padding: 15px;
        }

        .nilai-header h5 {
            font-size: 16px;
        }

        .save-btn {
            position: fixed;
            bottom: 12px;
            right: 12px;
            z-index: 200;
            border-radius: 30px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.3);
            padding: 12px 20px;
        }

        .nilai-input {
            width: 50px;
            font-size: 12px;
            padding: 4px;
        }

        thead th {
            font-size: 10px;
            padding: 8px 4px;
        }

        tbody td {
            padding: 8px 4px;
            font-size: 12px;
        }
    }
</style>

@section('content')

<div class="container-wrapper">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left">
            <h4>
                <i class="fas fa-graduation-cap"></i> Nilai Mata Pelajaran
            </h4>
        </div>
        <div>
            <a href="{{ route('nilaiakademik.mapel.assign.form', $mapel->id_matapelajaran) }}" class="assign-btn">
                <i class="fas fa-user-plus"></i> Assign Santri
            </a>
            <a href="{{ route('nilaiakademik.mapel.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Mapel Info Card -->
    <div class="mapel-info-card">
        <div class="mapel-info-header">
            <div class="mapel-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="mapel-details">
                <h5>{{ $mapel->nama_matapelajaran }}</h5>
                <p><i class="fas fa-calendar-alt me-2"></i>Tahun Ajaran: {{ $mapel->tahunAjaran->tahun }} - Semester {{ strtoupper($mapel->tahunAjaran->semester) }}</p>
            </div>
        </div>
        <div class="mapel-stats">
            <div class="stat-item">
                <i class="fas fa-chalkboard-teacher"></i>
                <div>
                    <span class="stat-label">Pendidik</span>
                    <span class="stat-value">{{ $mapel->pendidik->nama ?? '-' }}</span>
                </div>
            </div>
            <div class="stat-item">
                <i class="fas fa-users"></i>
                <div>
                    <span class="stat-label">Total Santri</span>
                    <span class="stat-value">{{ $nilai->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Nilai Card -->
    <div class="nilai-card">
        <div class="nilai-header">
            <h5><i class="fas fa-clipboard-list"></i> Daftar Nilai</h5>
        </div>

        <form action="{{ route('nilaiakademik.mapel.updateAll', $mapel->id_matapelajaran) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Santri</th>
                            <th>UTS</th>
                            <th>UAS</th>
                            <th>Praktik</th>
                            <th>Izin</th>
                            <th>Sakit</th>
                            <th>Ghaib</th>
                            <th>Rata-rata</th>
                            <th>Predikat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($nilai as $n)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $n->santri->nama }}</td>

                            <td>
                                <input oninput="updateRow(this)" type="number" 
                                       name="nilai[{{ $n->id_nilai_akademik }}][uts]" 
                                       value="{{ $n->nilai_UTS }}" 
                                       class="nilai-input">
                            </td>
                            <td>
                                <input oninput="updateRow(this)" type="number" 
                                       name="nilai[{{ $n->id_nilai_akademik }}][uas]" 
                                       value="{{ $n->nilai_UAS }}" 
                                       class="nilai-input">
                            </td>
                            <td>
                                <input oninput="updateRow(this)" type="number" 
                                       name="nilai[{{ $n->id_nilai_akademik }}][praktik]" 
                                       value="{{ $n->nilai_praktik }}" 
                                       class="nilai-input">
                            </td>

                            <td>
                                <input type="number" 
                                       name="nilai[{{ $n->id_nilai_akademik }}][izin]" 
                                       value="{{ $n->jumlah_izin }}" 
                                       class="nilai-input">
                            </td>
                            <td>
                                <input type="number" 
                                       name="nilai[{{ $n->id_nilai_akademik }}][sakit]" 
                                       value="{{ $n->jumlah_sakit }}" 
                                       class="nilai-input">
                            </td>
                            <td>
                                <input type="number" 
                                       name="nilai[{{ $n->id_nilai_akademik }}][ghaib]" 
                                       value="{{ $n->jumlah_ghaib }}" 
                                       class="nilai-input">
                            </td>

                            <td>
                                <input type="text" class="nilai-input rata-input rata" 
                                       readonly value="{{ number_format($n->nilai_rata_rata, 2) }}">
                            </td>

                            <td>
                                <span class="predikat predikat-{{ $n->predikat }}">
                                    {{ $n->predikat }}
                                </span>
                            </td>

                            <td>
                                <button type="button" class="action-btn" 
                                        onclick="deleteNilai('{{ $n->id_nilai_akademik }}')" 
                                        title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="white" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2">
                                        <path d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="save-btn-wrapper">
                <button type="submit" class="save-btn">
                    <i class="fas fa-save"></i> Simpan Semua
                </button>
            </div>

        </form>
    </div>
</div>

<!-- DELETE FORM -->
<form id="deleteForm" method="POST" style="display:none;">
    @csrf @method('DELETE')
</form>

<script>
function deleteNilai(id) {
    if(confirm('Hapus data nilai ini?')) {
        const form = document.getElementById('deleteForm');
        form.action = "{{ route('nilaiakademik.mapel.destroy', ':id') }}".replace(':id', id);
        form.submit();
    }
}

// Auto Count
function updateRow(el) {
    const row = el.closest('tr');
    const uts = Number(row.querySelector('[name*="uts"]').value) || 0;
    const uas = Number(row.querySelector('[name*="uas"]').value) || 0;
    const praktik = Number(row.querySelector('[name*="praktik"]').value) || 0;

    const rata = ((uts + uas + praktik) / 3).toFixed(2);
    const rataEl = row.querySelector('.rata');
    rataEl.value = rata;

    const predEl = row.querySelector('.predikat');

    let predikat = 'D';
    if(rata >= 85) predikat = 'A';
    else if(rata >= 75) predikat = 'B';
    else if(rata >= 65) predikat = 'C';

    predEl.textContent = predikat;
    predEl.className = 'predikat predikat-' + predikat;
}
</script>

@endsection