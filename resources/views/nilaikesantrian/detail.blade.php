@extends('layouts.app')

@section('page_title', 'Input Nilai Kesantrian')

@section('content')

<style>
/* 🎨 Gaya dari Nilai Akademik (disesuaikan untuk Kesantrian) */

/* Header Gradien & Sticky */
.table-header-fancy {
    /* Mengubah warna gradient agar berbeda dari Akademik (menggunakan Hijau untuk Kesantrian) */
    background: linear-gradient(45deg, #198754, #20c997); 
    color: #fff !important;
    text-transform: uppercase;
    letter-spacing: .6px;
    position: sticky;
    top: 0;
    z-index: 10;
    font-weight: 600; /* Dibuat lebih tebal */
}

/* Hover */
.table tbody tr:hover {
    background-color: #e6fff1; /* Warna hijau muda */
    transition: .2s;
}

/* Peningkatan untuk input nilai */
.nilai-input-kesantrian {
    text-align: center;
    text-transform: uppercase;
    font-weight: bold;
    border: 1px solid #ced4da; /* Beri border default */
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    
    /* === PERUBAHAN UTAMA: PERBESAR LEBAR INPUT NILAI === */
    width: 80px; /* Dibuat 60px agar lebih lebar daripada default Bootstrap */
    font-size: 14px; /* Perbesar font agar terlihat lebih penuh */
    /* ================================================= */
}
.nilai-input-kesantrian:focus {
    border-color: #198754 !important;
    box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
    background-color: #fff;
}


/* Scroll */
.table-responsive-nilai { 
    max-height: 55vh; 
    overflow-y: auto;
    border: 1px solid #dee2e6; /* Border di sekeliling area scroll */
    border-radius: 5px;
}
/* Hilangkan border tabel jika sudah ada border wrapper */
.table-responsive-nilai .table {
    margin-bottom: 0;
    border: none !important;
}

/* Floating Button mobile */
@media (max-width: 768px) {
    .save-floating {
        position: fixed;
        bottom: 12px;
        right: 12px;
        padding: 8px 18px;
        font-size: 14px;
        z-index: 200;
        border-radius: 30px;
        box-shadow: 0px 4px 10px rgba(0,0,0,0.3);
    }
    
    /* Mobile: mode tampilan input nilai (lebih agresif) */
    .nilai-input-kesantrian {
        width: 40px !important; /* HARUS KECIL */
        font-size: 11px !important;
        padding: 2px !important;
        background: transparent;
        border: 1px solid transparent !important; 
        text-align: center;
        text-transform: uppercase;
    }

    .nilai-input-kesantrian:focus {
        border: 1px solid #198754 !important; 
        background: #fff;
    }

    /* Perbaikan layout sel: padding harus minimal */
    .table td, .table th {
        padding: 4px !important; /* Dibuat 4px dari 6px agar lebih rapat lagi di mobile */
        white-space: nowrap; /* Penting untuk mencegah wrapping text */
    }

    /* Perbaikan layout sel */
    .table td, .table th {
        padding: 6px !important; /* sedikit diperbesar */
        white-space: nowrap;
    }
    
    /* Rapiin Nav Pills di mobile */
    .nav-pills .nav-item {
        margin: 2px 0;
    }
    .nav-pills .nav-link {
        font-size: 12px;
        padding: 5px 8px;
    }
}

/* Peningkatan Nav-pills (Sub-tab) */
.nav-pills .nav-link.active {
    background-color: #198754 !important; /* Hijau Kesantrian */
}
.nav-pills .nav-link {
    color: #198754;
    font-weight: 500;
}
.nav-pills .nav-link:hover {
    color: #198754;
    background-color: #e6fff1;
}

</style>

<div class="container mt-4"> 

    {{-- A. HEADER DENGAN TOMBOL KEMBALI --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">📝 Nilai Kesantrian: {{ $mapel->nama_matapelajaran }}</h3>
        <a href="{{ route('nilaikesantrian.index', ['id_tahunAjaran' => $mapel->id_tahunAjaran]) }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Mapel
        </a>
    </div>
    
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5><strong>{{ $mapel->nama_matapelajaran }}</strong></h5>

            <p class="mb-1">Tahun Ajaran:
                <strong>{{ $tahunAjaran->tahun }} - Semester {{ strtoupper($tahunAjaran->semester) }}</strong>
            </p>

            <p class="mb-0">Pendidik: <strong>{{ $mapel->pendidik->nama ?? '-' }}</strong></p>
        </div>
    </div>


    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
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
            <a class="nav-link active" id="input-tab" data-bs-toggle="tab" href="#inputNilai" role="tab" aria-controls="inputNilai" aria-selected="true">
                <i class="bi bi-pencil-square"></i> 1. Input Nilai ({{ $nilaiSantri->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="assign-tab" data-bs-toggle="tab" href="#assignSantri" role="tab" aria-controls="assignSantri" aria-selected="false">
                <i class="bi bi-person-plus"></i> 2. Assign Santri ({{ $santriBelumAssign->count() }} Belum Di-assign)
            </a>
        </li>
    </ul>

    <div class="tab-content card shadow-sm p-3">
        
        {{-- TAB 1: INPUT NILAI (Berisi Sub-Tabs) --}}
        <div class="tab-pane fade show active" id="inputNilai" role="tabpanel" aria-labelledby="input-tab">
            
            {{-- SUB-TAB NAVIGATION --}}
            <ul class="nav nav-pills nav-fill mb-3 pt-2" id="subNilaiTabs" role="tablist" style="border-bottom: 1px solid #dee2e6;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="akhlak-tab" data-bs-toggle="pill" data-bs-target="#akhlak" type="button" role="tab" aria-controls="akhlak" aria-selected="true"><i class="bi bi-heart-fill"></i> Akhlak</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="ibadah-tab" data-bs-toggle="pill" data-bs-target="#ibadah" type="button" role="tab" aria-controls="ibadah" aria-selected="false"><i class="bi bi-book"></i> Ibadah</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="kerapian-tab" data-bs-toggle="pill" data-bs-target="#kerapian" type="button" role="tab" aria-controls="kerapian" aria-selected="false"><i class="bi bi-scissors"></i> Kerapian</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="kedisiplinan-tab" data-bs-toggle="pill" data-bs-target="#kedisiplinan" type="button" role="tab" aria-controls="kedisiplinan" aria-selected="false"><i class="bi bi-clock"></i> Kedisiplinan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="ekstrakulikuler-tab" data-bs-toggle="pill" data-bs-target="#ekstrakulikuler" type="button" role="tab" aria-controls="ekstrakulikuler" aria-selected="false"><i class="bi bi-activity"></i> Ekstra</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="buku_pegangan-tab" data-bs-toggle="pill" data-bs-target="#buku_pegangan" type="button" role="tab" aria-controls="buku_pegangan" aria-selected="false"><i class="bi bi-journal-check"></i> Buku Peg.</button>
                </li>
            </ul>

            @if($nilaiSantri->isEmpty())
                <div class="alert alert-warning">Belum ada santri yang di-assign untuk mata pelajaran ini. Silakan pindah ke tab "Assign Santri".</div>
            @else
                <form action="{{ route('nilaikesantrian.update.massal') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_matapelajaran" value="{{ $mapel->id_matapelajaran }}">
                    <input type="hidden" name="id_tahunAjaran" value="{{ $tahunAjaran->id_tahunAjaran }}">
                    
                    {{-- SUB-TAB CONTENT --}}
                    <div class="tab-content" id="subNilaiTabsContent">
                        
                        {{-- TEMPLATE UNTUK TAB NILAI --}}
                        {{-- TEMPLATE UNTUK TAB NILAI --}}
@php
    $categories = [
        'akhlak' => ['title' => 'Akhlak', 'icon' => 'bi bi-heart-fill'],
        'ibadah' => ['title' => 'Ibadah', 'icon' => 'bi bi-book'],
        'kerapian' => ['title' => 'Kerapian', 'icon' => 'bi bi-scissors'],
        'kedisiplinan' => ['title' => 'Kedisiplinan', 'icon' => 'bi bi-clock'],
        'ekstrakulikuler' => ['title' => 'Ekstra', 'icon' => 'bi bi-activity'],
        'buku_pegangan' => ['title' => 'Buku Peg.', 'icon' => 'bi bi-journal-check']
    ];
@endphp

@foreach($categories as $key => $category)
<div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $key }}" role="tabpanel" aria-labelledby="{{ $key }}-tab">
    <div class="table-responsive table-responsive-nilai">
        <table class="table table-striped table-hover text-center align-middle">
            <thead class="table-header-fancy">
                <tr>
                    <th style="width: 20px;">#</th>
                    
                    {{-- 1. HEADER NIS (Hanya Tampil di DESKTOP/Tablet ke atas) --}}
                    <th class="d-none d-md-table-cell" style="width: 75px;">NIS</th> 
                    
                    {{-- 2. HEADER NAMA SANTRI (Berbeda lebar untuk mobile/desktop) --}}
                    {{-- Di Desktop, Nama Santri mengambil sisa ruang. Di Mobile, ini adalah header utama. --}}
                    <th style="text-align: left;" class="w-100">Nama Santri</th> 
                    
                    {{-- Menggunakan width yang kecil dan sama untuk semua kolom nilai --}}
                    <th style="width: 360px;">Nilai {{ $category['title'] }} (A/B/C)</th>
                    
                    <th style="width: 50px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nilaiSantri as $nilai)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        
                        {{-- 1. DATA NIS (Hanya Tampil di DESKTOP) --}}
                        <td class="d-none d-md-table-cell"><small>{{ $nilai->santri->nis ?? 'N/A' }}</small></td> 

                        {{-- 2. DATA NAMA SANTRI (Memiliki dua tampilan berbeda) --}}
                        <td style="text-align: left;">
                            <strong>{{ $nilai->santri->nama ?? 'N/A' }}</strong>
                            
                            {{-- NIS DI BAWAH NAMA (Hanya Tampil di MOBILE) --}}
                            <small class="text-muted d-block d-md-none">NIS: {{ $nilai->santri->nis ?? 'N/A' }}</small>
                        </td>
                        
                        {{-- Kolom Input Nilai DINAMIS --}}
                        <td>
                            <input type="text" 
                                   name="nilai[{{ $nilai->id_nilai_kesantrian }}][nilai_{{ $key }}]" 
                                   value="{{ old('nilai.' . $nilai->id_nilai_kesantrian . '.nilai_' . $key, $nilai->{'nilai_' . $key}) }}" 
                                   class="form-control form-control-sm nilai-input-kesantrian" 
                                   maxlength="1"
                                   placeholder="A/B/C">
                        </td>
                        
                        {{-- TOMBOL HAPUS/UN-ASSIGN --}}
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm p-1" 
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
                    
                    <button type="submit" class="btn btn-primary mt-3 float-end d-none d-md-inline">💾 Simpan Semua Nilai</button>
                    <button class="btn btn-primary save-floating d-md-none">💾 Simpan</button>
                </form>
            @endif
        </div>

        {{-- TAB 2: ASSIGN SANTRI --}}
        <div class="tab-pane fade" id="assignSantri" role="tabpanel" aria-labelledby="assign-tab">
            <h4>Pilih Santri yang Belum Di-assign</h4>

            {{-- Form Filter --}}
            <form method="GET" action="{{ route('nilaikesantrian.show', ['id_matapelajaran' => $mapel->id_matapelajaran, 'id_tahunAjaran' => $tahunAjaran->id_tahunAjaran]) }}" class="row g-2 align-items-end mb-3">
                <input type="hidden" name="tab" value="assign">
                
                <div class="col-md-auto col-12">
                    <label for="angkatan" class="form-label mb-0">Angkatan:</label>
                    <select name="angkatan" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">Semua</option>
                        @foreach($angkatanList as $angkatan)
                            <option value="{{ $angkatan }}" {{ request('angkatan') == $angkatan ? 'selected' : '' }}>{{ $angkatan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 col-12">
                    <label for="search_nama" class="form-label mb-0">Cari Nama:</label>
                    <div class="input-group input-group-sm">
                         <input type="text" name="search_nama" value="{{ request('search_nama') }}" class="form-control" placeholder="Cari nama santri...">
                         <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-search"></i> Cari</button>
                    </div>
                </div>
                
                @if(request('angkatan') || request('search_nama'))
                    <div class="col-auto">
                        <a href="{{ route('nilaikesantrian.show', ['id_matapelajaran' => $mapel->id_matapelajaran, 'id_tahunAjaran' => $tahunAjaran->id_tahunAjaran]) }}?tab=assign" class="btn btn-sm btn-outline-danger">Reset</a>
                    </div>
                @endif
            </form>
            
            <hr>

            {{-- Form Assign Santri --}}
            <form action="{{ route('nilaikesantrian.assign.store', ['id_matapelajaran' => $mapel->id_matapelajaran, 'id_tahunAjaran' => $tahunAjaran->id_tahunAjaran]) }}" method="POST">
                @csrf
                
                <div class="list-group mb-3" style="max-height: 400px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 5px;">
                    @forelse($santriBelumAssign as $santri)
                        <label class="form-check-label list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2" for="santri-{{ $santri->nis }}">
                             <div class="d-flex align-items-center">
                                <input class="form-check-input me-3" type="checkbox" name="nis[]" value="{{ $santri->nis }}" id="santri-{{ $santri->nis }}">
                                <div>
                                    <strong class="text-success">{{ $santri->nama }}</strong> 
                                    <small class="text-muted d-block">NIS: {{ $santri->nis }}, Angkatan: {{ $santri->angkatan }}</small>
                                </div>
                             </div>
                        </label>
                    @empty
                        <div class="alert alert-success m-0 rounded-0">Semua santri sudah di-assign ke mata pelajaran ini.</div>
                    @endforelse
                </div>

                @if($santriBelumAssign->isNotEmpty())
                    <button type="submit" class="btn btn-success mt-1">➕ Assign Santri Terpilih ({{ $santriBelumAssign->count() }})</button>
                @endif
            </form>
        </div>
    </div>
</div>


{{-- HIDDEN FORM UNTUK DELETE (UN-ASSIGN) SANTRI --}}
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
    // Pastikan Bootstrap 5 tersedia untuk menggunakan Tab dan Pill.
    if (typeof bootstrap === 'undefined') {
        console.error("Bootstrap 5 JS is required for tabs/pills functionality.");
    }
    
    function confirmDelete(nama, id_nilai_kesantrian) {
        if (confirm(`Yakin ingin MENGHAPUS (Un-assign) santri atas nama ${nama} dari mata pelajaran ini?`)) {
            const form = document.getElementById('delete-form');
            // Pastikan rute yang digunakan benar, jika Anda menggunakan Laravel resource, ini mungkin perlu disesuaikan.
            // Asumsi route: /nilai-kesantrian/unassign/{id_nilai_kesantrian}
            form.action = `/nilai-kesantrian/unassign/${id_nilai_kesantrian}`; 
            form.submit();
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        
        // --- LOGIKA TABS UTAMA ---
        const activeTabParam = urlParams.get('tab');
        if (activeTabParam === 'assign') {
            const assignTabEl = document.getElementById('assign-tab');
            if (assignTabEl) {
                // Aktifkan tab Bootstrap
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
                // Hapus sub_tab saat pindah ke tab utama selain input nilai
                if (tabId !== 'inputNilai') {
                     newUrl.searchParams.delete('sub_tab');
                }
                window.history.pushState({path: newUrl.href}, '', newUrl.href);
            });
        });
        
        // --- LOGIKA SUB-TABS (NILAI) ---
        // Jika ada parameter sub_tab di URL, aktifkan sub-tab yang sesuai
        const activeSubTabParam = urlParams.get('sub_tab');
        if (activeSubTabParam) {
            const subTabEl = document.getElementById(activeSubTabParam + '-tab');
            if (subTabEl) {
                // Aktifkan tab utama 'inputNilai' dulu (jika belum)
                const inputTabEl = document.getElementById('input-tab');
                if (inputTabEl && !inputTabEl.classList.contains('active')) {
                    new bootstrap.Tab(inputTabEl).show();
                }
                // Aktifkan sub-tab
                const subTab = new bootstrap.Tab(subTabEl);
                subTab.show();
            }
        }
        
        // Event listener untuk menyimpan status sub-tab di URL
        const subTabTriggers = document.querySelectorAll('#subNilaiTabs button[data-bs-toggle="pill"]');
        subTabTriggers.forEach(function(trigger) {
            trigger.addEventListener('shown.bs.tab', function (event) {
                const newUrl = new URL(window.location.href);
                // Mendapatkan ID tab content (cth: 'akhlak')
                const tabId = event.target.getAttribute('data-bs-target').substring(1); 
                
                newUrl.searchParams.set('sub_tab', tabId);
                newUrl.searchParams.delete('tab'); // Pastikan tab utama kembali ke 'inputNilai'
                
                window.history.pushState({path: newUrl.href}, '', newUrl.href);
            });
        });
        
    });
</script>
@endpush
@endsection