@extends('layouts.app')

@section('page_title', 'Input Nilai Kesantrian')

{{-- Bootstrap & Font Awesome --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css">

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

    .back-btn {
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

    .assign-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: white;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
        padding: 10px 16px;
        border: 1px solid var(--primary-color);
        border-radius: 8px;
        background: var(--primary-color);
    }

    .assign-btn-primary:hover {
        background-color: #1e7e34;
        color: white;
    }

    .back-btn:hover {
        background-color: var(--primary-color);
        color: white;
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

    /* Tabs Navigation */
    .nav-tabs {
        border-bottom: 2px solid var(--border-color);
        background: white;
        border-radius: 8px 8px 0 0;
        padding: 10px 15px 0;
        margin-bottom: 0;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #666;
        font-weight: 500;
        padding: 12px 20px;
        border-radius: 8px 8px 0 0;
        transition: all 0.2s;
    }

    .nav-tabs .nav-link:hover {
        background-color: #f8fff9;
        color: var(--primary-color);
    }

    .nav-tabs .nav-link.active {
        background-color: white;
        color: var(--primary-color);
        border-bottom: 3px solid var(--primary-color);
        font-weight: 600;
    }

    /* Tab Content */
    .tab-content {
        background: white;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 0;
    }

    /* Sub Pills Navigation */
    .nav-pills {
        padding: 15px 15px 0;
        gap: 8px;
        background-color: var(--bg-light);
        border-bottom: 1px solid var(--border-color);
    }

    .nav-pills .nav-link {
        color: var(--primary-color);
        font-weight: 500;
        border-radius: 20px;
        padding: 8px 16px;
        transition: all 0.2s;
        border: 1px solid transparent;
    }

    .nav-pills .nav-link:hover {
        background-color: #e8f5e9;
        border-color: var(--primary-color);
    }

    .nav-pills .nav-link.active {
        background-color: var(--primary-color);
        color: white;
    }

    /* Table Styling */
    .table-responsive-nilai {
        max-height: 55vh;
        overflow-y: auto;
        border: 1px solid var(--border-color);
        margin: 15px;
        border-radius: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
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
        background-color: #e6fff1;
        transition: .2s;
    }

    .nilai-input-kesantrian {
        width: 80px;
        padding: 8px;
        border: 2px solid var(--border-color);
        border-radius: 5px;
        text-align: center;
        text-transform: uppercase;
        font-weight: 600;
        font-size: 14px;
    }

    .nilai-input-kesantrian:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
        background-color: #fff;
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

    /* Assign Santri Section */
    .assign-section {
        padding: 20px;
    }

    .filter-section {
        background-color: var(--bg-light);
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .santri-assign-list {
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid var(--border-color);
        border-radius: 5px;
    }

    .santri-assign-item {
        padding: 12px 15px;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.2s;
        cursor: pointer;
    }

    .santri-assign-item:hover {
        background-color: #e8f5e9;
    }

    .santri-assign-item:last-child {
        border-bottom: none;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        body {
            background-color: #f5f5f5;
        }

        .container-wrapper {
            padding: 0 0 80px 0;
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

        .back-btn {
            width: 100%;
            justify-content: center;
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

        .nav-tabs {
            border-radius: 0;
            padding: 8px 10px 0;
        }

        .nav-tabs .nav-link {
            font-size: 13px;
            padding: 8px 12px;
        }

        .tab-content {
            border-radius: 0;
        }

        .nav-pills {
            padding: 10px;
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        .nav-pills .nav-link {
            font-size: 12px;
            padding: 6px 12px;
            white-space: nowrap;
        }

        .table-responsive-nilai {
            margin: 10px;
            max-height: 50vh;
        }

        thead th {
            font-size: 10px;
            padding: 8px 4px;
        }

        tbody td {
            padding: 8px 4px;
            font-size: 12px;
        }

        .nilai-input-kesantrian {
            width: 45px;
            font-size: 12px;
            padding: 4px;
        }

        .action-btn {
            width: 32px;
            height: 32px;
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

        .assign-section {
            padding: 15px;
        }
    }
</style>

@section('content')

<div class="container-wrapper">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left">
            <h4>
                <i class="fas fa-edit"></i> Input Nilai Kesantrian
            </h4>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('nilaikesantrian.index', ['id_tahunAjaran' => $mapel->id_tahunAjaran]) }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="button" class="assign-btn-primary" id="openAssignTab">
                <i class="bi bi-person-plus"></i> Tambah Santri
            </button>
        </div>
    </div>

    <!-- Mapel Info Card -->
    <div class="mapel-info-card">
        <div class="mapel-info-header">
            <div class="mapel-icon">
                <i class="fas fa-mosque"></i>
            </div>
            <div class="mapel-details">
                <h5>{{ $mapel->nama_matapelajaran }}</h5>
                <p><i class="fas fa-calendar-alt me-2"></i>Tahun Ajaran: {{ $tahunAjaran->tahun }} - Semester {{ strtoupper($tahunAjaran->semester) }}</p>
                <p><i class="fas fa-chalkboard-teacher me-2"></i>Pendidik: {{ $mapel->pendidik->nama ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success mx-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mx-3">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mx-3">
            <h6>Terdapat Kesalahan Input:</h6>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tabs Navigasi Utama --}}
    <ul class="nav nav-tabs" id="nilaiTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="input-tab" data-bs-toggle="tab" href="#inputNilai" role="tab">
                <i class="bi bi-pencil-square"></i> Input Nilai ({{ $nilaiSantri->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="assign-tab" data-bs-toggle="tab" href="#assignSantri" role="tab">
                <i class="bi bi-person-plus"></i> Assign Santri ({{ $santriBelumAssign->count() }})
            </a>
        </li>
    </ul>

    <div class="tab-content">
        
        {{-- TAB 1: INPUT NILAI --}}
        <div class="tab-pane fade show active" id="inputNilai" role="tabpanel">
            
            {{-- SUB-TAB NAVIGATION --}}
            <ul class="nav nav-pills nav-fill" id="subNilaiTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="akhlak-tab" data-bs-toggle="pill" data-bs-target="#akhlak" type="button">
                        <i class="bi bi-heart-fill"></i> Akhlak
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="ibadah-tab" data-bs-toggle="pill" data-bs-target="#ibadah" type="button">
                        <i class="bi bi-book"></i> Ibadah
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="kerapian-tab" data-bs-toggle="pill" data-bs-target="#kerapian" type="button">
                        <i class="bi bi-scissors"></i> Kerapian
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="kedisiplinan-tab" data-bs-toggle="pill" data-bs-target="#kedisiplinan" type="button">
                        <i class="bi bi-clock"></i> Kedisiplinan
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="ekstrakulikuler-tab" data-bs-toggle="pill" data-bs-target="#ekstrakulikuler" type="button">
                        <i class="bi bi-activity"></i> Ekstra
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="buku_pegangan-tab" data-bs-toggle="pill" data-bs-target="#buku_pegangan" type="button">
                        <i class="bi bi-journal-check"></i> Buku Pegangan
                    </button>
                </li>
            </ul>

            @if($nilaiSantri->isEmpty())
                <div class="alert alert-warning m-3">
                    Belum ada santri yang di-assign untuk mata pelajaran ini. Silakan pindah ke tab "Assign Santri".
                </div>
            @else
                <form action="{{ route('nilaikesantrian.update.massal') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_matapelajaran" value="{{ $mapel->id_matapelajaran }}">
                    <input type="hidden" name="id_tahunAjaran" value="{{ $tahunAjaran->id_tahunAjaran }}">
                    
                    {{-- SUB-TAB CONTENT --}}
                    <div class="tab-content" id="subNilaiTabsContent">
                        
@php
    $categories = [
        'akhlak' => ['title' => 'Akhlak', 'icon' => 'bi bi-heart-fill'],
        'ibadah' => ['title' => 'Ibadah', 'icon' => 'bi bi-book'],
        'kerapian' => ['title' => 'Kerapian', 'icon' => 'bi bi-scissors'],
        'kedisiplinan' => ['title' => 'Kedisiplinan', 'icon' => 'bi bi-clock'],
        'ekstrakulikuler' => ['title' => 'Ekstra', 'icon' => 'bi bi-activity'],
        'buku_pegangan' => ['title' => 'Buku Pegangan', 'icon' => 'bi bi-journal-check']
    ];
@endphp

@foreach($categories as $key => $category)
<div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $key }}" role="tabpanel">
    <div class="table-responsive-nilai">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 20px;">#</th>
                    <th class="d-none d-md-table-cell" style="width: 75px;">NIS</th>
                    <th style="text-align: left;">Nama Santri</th>
                    <th style="width: 120px;">Nilai {{ $category['title'] }}</th>
                    <th style="width: 50px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nilaiSantri as $nilai)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="d-none d-md-table-cell"><small>{{ $nilai->santri->nis ?? 'N/A' }}</small></td>
                        <td style="text-align: left;">
                            <div class="d-flex align-items-center gap-2">
                                <strong>{{ $nilai->santri->nama ?? 'N/A' }}</strong>
                                @php
                                    $sudahDinilai = !empty($nilai->{'nilai_' . $key});
                                @endphp
                                <span class="badge {{ $sudahDinilai ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $sudahDinilai ? 'Sudah dinilai' : 'Belum dinilai' }}
                                </span>
                            </div>
                            <small class="text-muted d-block d-md-none">NIS: {{ $nilai->santri->nis ?? 'N/A' }}</small>
                        </td>
                        <td>
                            <input type="text" 
                                   name="nilai[{{ $nilai->id_nilai_kesantrian }}][nilai_{{ $key }}]" 
                                   value="{{ old('nilai.' . $nilai->id_nilai_kesantrian . '.nilai_' . $key, $nilai->{'nilai_' . $key}) }}" 
                                   class="nilai-input-kesantrian" 
                                   maxlength="1"
                                   placeholder="A/B/C"
                                   oninput="validateNilaiKesantrian(this)">
                        </td>
                        <td>
                            <button type="button" class="action-btn" 
                                    title="Un-assign Santri"
                                    onclick="confirmDelete('{{ $nilai->santri->nama ?? $nilai->nis }}', '{{ $nilai->id_nilai_kesantrian }}')">
                                <i class="bi bi-x"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endforeach
                        
                    </div>
                    
                    <div class="save-btn-wrapper">
                        <button type="submit" class="save-btn">
                            <i class="fas fa-save"></i> Simpan Semua Nilai
                        </button>
                    </div>
                </form>
            @endif
        </div>

        {{-- TAB 2: ASSIGN SANTRI --}}
        <div class="tab-pane fade" id="assignSantri" role="tabpanel">
            <div class="assign-section">
                <h5 class="mb-3"><i class="bi bi-person-plus"></i> Pilih Santri yang Belum Di-assign</h5>

                {{-- Form Assign Santri - Single searchable multi-select --}}
                <form action="{{ route('nilaikesantrian.assign.store', ['id_matapelajaran' => $mapel->id_matapelajaran, 'id_tahunAjaran' => $tahunAjaran->id_tahunAjaran]) }}" method="POST">
                    @csrf

                    @if($santriBelumAssign->isEmpty())
                        <div class="alert alert-success m-0">
                            <i class="bi bi-check-circle"></i> Semua santri sudah di-assign ke mata pelajaran ini.
                        </div>
                    @else
                        <div class="mb-3">
                            <label for="santri_select" class="form-label fw-semibold">Pilih Santri (search untuk memfilter)</label>
                            <select id="santri_select" name="nis[]" multiple class="form-select" placeholder="Ketik nama/NIS untuk mencari...">
                                @foreach($santriBelumAssign as $santri)
                                    <option value="{{ $santri->nis }}">
                                        {{ $santri->nama }} ({{ $santri->nis }}) • Angkatan {{ $santri->angkatan }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Anda dapat memilih lebih dari satu santri.</div>
                        </div>

                        <button type="submit" id="btnTambahSantri" class="btn btn-success w-100">
                            Tambah Santri
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

{{-- HIDDEN FORM UNTUK DELETE (UN-ASSIGN) SANTRI --}}
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    // ===== VALIDASI NILAI KESANTRIAN A-E UPPERCASE =====
    function validateNilaiKesantrian(el) {
        let val = el.value.toUpperCase();
        // Hanya terima A, B, C, D, E
        if (val && !/^[A-E]$/.test(val)) {
            el.value = '';
            alert('Hanya nilai A, B, C, D, atau E yang diperbolehkan');
            return;
        }
        el.value = val;
    }

    function confirmDelete(nama, id_nilai_kesantrian) {
        if (confirm(`Yakin ingin MENGHAPUS (Un-assign) santri atas nama ${nama} dari mata pelajaran ini?`)) {
            const form = document.getElementById('delete-form');
            form.action = `/nilai-kesantrian/unassign/${id_nilai_kesantrian}`; 
            form.submit();
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);

        // Shortcut button to open assign tab
        const openAssignBtn = document.getElementById('openAssignTab');
        if (openAssignBtn) {
            openAssignBtn.addEventListener('click', function() {
                const assignTabEl = document.getElementById('assign-tab');
                if (assignTabEl) {
                    new bootstrap.Tab(assignTabEl).show();
                    const newUrl = new URL(window.location.href);
                    newUrl.searchParams.set('tab', 'assign');
                    window.history.pushState({path: newUrl.href}, '', newUrl.href);
                }
                document.getElementById('assignSantri')?.scrollIntoView({behavior: 'smooth'});
            });
        }
        
        // Tab utama
        const activeTabParam = urlParams.get('tab');
        if (activeTabParam === 'assign') {
            const assignTabEl = document.getElementById('assign-tab');
            if (assignTabEl) {
                const assignTab = new bootstrap.Tab(assignTabEl);
                assignTab.show();
            }
        }

        const tabTriggers = document.querySelectorAll('#nilaiTabs a[data-bs-toggle="tab"]');
        tabTriggers.forEach(function(trigger) {
            trigger.addEventListener('shown.bs.tab', function (event) {
                const newUrl = new URL(window.location.href);
                const tabId = event.target.getAttribute('href').substring(1);

                if (tabId === 'assignSantri') {
                    newUrl.searchParams.set('tab', 'assign');
                } else {
                    newUrl.searchParams.delete('tab');
                }
                if (tabId !== 'inputNilai') {
                     newUrl.searchParams.delete('sub_tab');
                }
                window.history.pushState({path: newUrl.href}, '', newUrl.href);
            });
        });
        
        // Sub-tabs
        const activeSubTabParam = urlParams.get('sub_tab');
        if (activeSubTabParam) {
            const subTabEl = document.getElementById(activeSubTabParam + '-tab');
            if (subTabEl) {
                const inputTabEl = document.getElementById('input-tab');
                if (inputTabEl && !inputTabEl.classList.contains('active')) {
                    new bootstrap.Tab(inputTabEl).show();
                }
                const subTab = new bootstrap.Tab(subTabEl);
                subTab.show();
            }
        }
        
        const subTabTriggers = document.querySelectorAll('#subNilaiTabs button[data-bs-toggle="pill"]');
        subTabTriggers.forEach(function(trigger) {
            trigger.addEventListener('shown.bs.tab', function (event) {
                const newUrl = new URL(window.location.href);
                const tabId = event.target.getAttribute('data-bs-target').substring(1); 
                
                newUrl.searchParams.set('sub_tab', tabId);
                newUrl.searchParams.delete('tab');
                
                window.history.pushState({path: newUrl.href}, '', newUrl.href);
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectEl = document.getElementById('santri_select');
        if (selectEl && window.TomSelect) {
            const ts = new TomSelect('#santri_select', {
                plugins: ['remove_button'],
                maxItems: null,
                create: false,
                persist: false,
                closeAfterSelect: false,
                placeholder: 'Ketik nama/NIS untuk mencari...',
                // Custom scoring untuk prefix match saja
                score: function(search) {
                    if (!search) return 0;
                    search = search.toLowerCase();
                    return function(option) {
                        let text = option.text.toLowerCase();
                        // Hanya match jika dimulai dengan search string (prefix match)
                        if (text.startsWith(search)) {
                            // Prioritas lebih tinggi jika match di awal nama
                            let nameMatch = text.match(/^([^(]+)/);
                            if (nameMatch && nameMatch[1].toLowerCase().trim().startsWith(search)) {
                                return 2; // Score lebih tinggi untuk nama
                            }
                            return 1; // Score untuk NIS atau angkatan
                        }
                        return 0; // Tidak match
                    };
                },
                render: {
                    option: function(data, escape) {
                        return `<div>${escape(data.text)}</div>`;
                    }
                }
            });

            const btn = document.getElementById('btnTambahSantri');
            const updateBtnText = () => {
                if (!btn) return;
                const count = ts.items.length;
                btn.textContent = count > 0 ? `Tambah Santri (${count})` : 'Tambah Santri';
            };
            selectEl.addEventListener('change', updateBtnText);
            updateBtnText();
        }
    });
</script>

@endsection