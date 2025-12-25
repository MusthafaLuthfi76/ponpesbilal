@extends('layouts.app')

@section('page_title', auth()->user()->role == 'musyrif' ? 'Halaman Tahfidz' : 'Nilai Tahfidz')

@section('content')

    <!-- Header dengan Gradient Modern -->
    <div class="header-custom">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4 class="mb-1 fw-bold text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="white" class="me-2">
                            <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
                        </svg>
                        {{ auth()->user()->role == 'musyrif' ? 'Halaman Tahfidz' : 'Nilai Tahfidz' }}
                    </h4>
                    <p class="mb-0 text-white-50 small">
                        {{ auth()->user()->role == 'musyrif' ? 'Manajemen tahfidz dan ujian santri' : 'Manajemen nilai ujian tahfidz santri' }}
                    </p>
                </div>
                <a href="{{ route('nilaiTahfidz.createUjianBaru') }}" class="btn btn-light shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                    </svg>
                    Ujian Baru
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid p-3 p-md-4">

        <!-- Alert Messages -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2 flex-shrink-0">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2 flex-shrink-0">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Filter Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-3 p-md-4">
                <h6 class="fw-bold mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                        <path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"/>
                    </svg>
                    Filter Data
                </h6>
                <form method="GET" action="{{ url()->current() }}" id="filterForm">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.35-4.35"></path>
                                    </svg>
                                </span>
                                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama atau NIS..." value="{{ request('search') }}" oninput="this.form.submit()">
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <select name="semester" class="form-select" onchange="this.form.submit()">
                                <option value="">Semua Semester</option>
                                <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Semester Ganjil</option>
                                <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Semester Genap</option>
                            </select>
                        </div>

                        <div class="col-6 col-md-4">
                            <select name="tahun" class="form-select" onchange="this.form.submit()">
                                <option value="">Semua Tahun Ajaran</option>
                                @foreach($tahunList as $t)
                                    <option value="{{ $t->id_tahunAjaran }}" {{ request('tahun') == $t->id_tahunAjaran ? 'selected' : '' }}>
                                        {{ $t->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Cards -->
        @forelse ($ujianList as $ujian)
            <div class="card border-0 shadow-sm mb-3 card-hover" onclick="window.location.href='{{ route('nilaiTahfidz.show', $ujian->santri->nis) }}'" style="cursor: pointer;">
                <div class="card-body p-3 p-md-4">
                    
                    <!-- Mobile Layout -->
                    <div class="d-block d-lg-none">
                        <div class="d-flex align-items-start mb-3">
                            <div class="avatar-circle me-3 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
                                    <path d="M12 2a5 5 0 1 1 0 10a5 5 0 0 1 0-10m0 12c-4.97 0-9 2.69-9 6v2h18v-2c0-3.31-4.03-6-9-6z" />
                                </svg>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1">{{ $ujian->santri->nama ?? '-' }}</h6>
                                <small class="text-muted">NIS: {{ $ujian->santri->nis ?? '-' }}</small>
                            </div>
                        </div>

                        <div class="info-grid mb-3">
                            <div class="info-item">
                                <span class="info-label">Jenis Ujian</span>
                                <span class="badge badge-custom {{ $ujian->jenis_ujian == 'UTS' ? 'badge-info' : 'badge-warning' }}">
                                    {{ $ujian->jenis_ujian }}
                                </span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Penguji</span>
                                <span class="info-value">{{ $ujian->penguji->nama ?? '-' }}</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Sekali Duduk</span>
                                <span class="badge badge-custom {{ $ujian->sekali_duduk == 'ya' ? 'badge-success' : 'badge-secondary' }}">
                                    {{ ucfirst($ujian->sekali_duduk) }}
                                </span>
                            </div>

                            @if($ujian->juz)
                            <div class="info-item">
                                <span class="info-label">Juz</span>
                                <span class="info-value">{{ $ujian->juz }}</span>
                            </div>
                            @endif

                            @if($ujian->tajwid !== null && $ujian->itqan !== null)
                            <div class="info-item">
                                <span class="info-label">Total Kesalahan</span>
                                <span class="badge badge-custom badge-danger">{{ $ujian->total_kesalahan }}</span>
                            </div>
                            @endif

                            <div class="info-item">
                                <span class="info-label">Periode</span>
                                @if ($ujian->tahunAjaran)
                                    <div>
                                        <span class="badge badge-custom {{ strtoupper($ujian->tahunAjaran->semester) == 'GANJIL' ? 'semester-ganjil' : 'semester-genap' }} mb-1 px-3 py-2">
                                            Semester {{ $ujian->tahunAjaran->semester }}
                                        </span>
                                        <div class="small text-muted">{{ $ujian->tahunAjaran->tahun }}</div>
                                    </div>
                                @else
                                    <span class="badge badge-custom badge-secondary">Belum ada tahun ajaran</span>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex gap-2 flex-wrap" onclick="event.stopPropagation()">
                            <button type="button" class="btn btn-sm btn-warning text-white flex-fill" onclick="editUjian({{ $ujian->id }}, '{{ $ujian->jenis_ujian }}', '{{ $ujian->sekali_duduk }}', '{{ $ujian->nis }}', {{ $ujian->tahun_ajaran_id ?? 'null' }}, {{ $ujian->id_penguji ?? 'null' }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="white">
                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                </svg>
                                Edit
                            </button>

                            <button type="button" class="btn btn-sm btn-danger" onclick="event.stopPropagation(); confirmDelete({{ $ujian->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="white">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                                </svg>
                                Hapus
                            </button>

                            <a href="{{ route('nilaiTahfidz.show', $ujian->santri->nis) }}" class="btn btn-sm {{ ($ujian->juz === null || $ujian->tajwid === null || $ujian->itqan === null) ? 'btn-success' : 'btn-info' }} text-white flex-fill">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="white">
                                    @if($ujian->juz === null || $ujian->tajwid === null || $ujian->itqan === null)
                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                    @else
                                    <path d="M11.5 18c4 0 7.46-2.22 9.24-5.5C18.96 9.22 15.5 7 11.5 7S4.04 9.22 2.26 12.5C4.04 15.78 7.5 18 11.5 18m0-12c4.56 0 8.5 2.65 10.36 6.5C20 16.35 16.06 19 11.5 19S3 16.35 1.14 12.5C3 8.65 6.94 6 11.5 6m0 2C14 8 16 10 16 12.5S14 17 11.5 17 7 15 7 12.5 9 8 11.5 8m0 1A3.5 3.5 0 0 0 8 12.5a3.5 3.5 0 0 0 3.5 3.5a3.5 3.5 0 0 0 3.5-3.5A3.5 3.5 0 0 0 11.5 9" />
                                    @endif
                                </svg>
                                {{ ($ujian->juz === null || $ujian->tajwid === null || $ujian->itqan === null) ? 'Input Nilai' : 'Detail' }}
                            </a>
                        </div>
                    </div>

                    <!-- Desktop Layout -->
                    <div class="d-none d-lg-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-start flex-grow-1">
                            <div class="avatar-circle me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="white" viewBox="0 0 24 24">
                                    <path d="M12 2a5 5 0 1 1 0 10a5 5 0 0 1 0-10m0 12c-4.97 0-9 2.69-9 6v2h18v-2c0-3.31-4.03-6-9-6z" />
                                </svg>
                            </div>

                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-2">{{ $ujian->santri->nama ?? '-' }}</h6>

                                <div class="row g-3">
                                    <div class="col-auto">
                                        <small class="text-muted">
                                            <span class="fw-bold">NIS:</span> {{ $ujian->santri->nis ?? '-' }}
                                        </small>
                                    </div>

                                    <div class="col-auto">
                                        <small class="text-muted">
                                            <span class="fw-bold">Jenis Ujian:</span>
                                            <span class="badge badge-custom {{ $ujian->jenis_ujian == 'UTS' ? 'badge-info' : 'badge-warning' }} ms-1">
                                                {{ $ujian->jenis_ujian }}
                                            </span>
                                        </small>
                                    </div>

                                    <div class="col-auto">
                                        <small class="text-muted">
                                            <span class="fw-bold">Penguji:</span> {{ $ujian->penguji->nama ?? '-' }}
                                        </small>
                                    </div>

                                    <div class="col-auto">
                                        <small class="text-muted">
                                            <span class="fw-bold">Sekali Duduk:</span>
                                            <span class="badge badge-custom {{ $ujian->sekali_duduk == 'ya' ? 'badge-success' : 'badge-secondary' }} ms-1">
                                                {{ ucfirst($ujian->sekali_duduk) }}
                                            </span>
                                        </small>
                                    </div>

                                    @if($ujian->juz)
                                    <div class="col-auto">
                                        <small class="text-muted">
                                            <span class="fw-bold">Juz:</span> {{ $ujian->juz }}
                                        </small>
                                    </div>
                                    @endif

                                    @if($ujian->tajwid !== null && $ujian->itqan !== null)
                                    <div class="col-auto">
                                        <small class="text-muted">
                                            <span class="fw-bold">Total Kesalahan:</span>
                                            <span class="badge badge-custom badge-danger ms-1">{{ $ujian->total_kesalahan }}</span>
                                        </small>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3 ms-3">
                            <div class="text-center">
                                @if ($ujian->tahunAjaran)
                                    <span class="badge badge-custom {{ strtoupper($ujian->tahunAjaran->semester) == 'GANJIL' ? 'semester-ganjil' : 'semester-genap' }} mb-1 px-3 py-2">
                                        Semester {{ $ujian->tahunAjaran->semester }}
                                    </span>
                                    <div class="small text-muted fw-bold">{{ $ujian->tahunAjaran->tahun }}</div>
                                @else
                                    <span class="badge badge-custom badge-secondary px-3 py-2">Belum ada tahun ajaran</span>
                                @endif
                            </div>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-warning btn-sm text-white" onclick="event.stopPropagation(); editUjian({{ $ujian->id }}, '{{ $ujian->jenis_ujian }}', '{{ $ujian->sekali_duduk }}', '{{ $ujian->nis }}', {{ $ujian->tahun_ajaran_id ?? 'null' }}, {{ $ujian->id_penguji ?? 'null' }})" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="white">
                                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                    </svg>
                                </button>

                                <button type="button" class="btn btn-danger btn-sm" onclick="event.stopPropagation(); confirmDelete({{ $ujian->id }})" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="white">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>

                                <a href="{{ route('nilaiTahfidz.show', $ujian->santri->nis) }}" class="btn {{ ($ujian->juz === null || $ujian->tajwid === null || $ujian->itqan === null) ? 'btn-success' : 'btn-info' }} btn-sm text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="white">
                                        @if($ujian->juz === null || $ujian->tajwid === null || $ujian->itqan === null)
                                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                        @else
                                        <path d="M11.5 18c4 0 7.46-2.22 9.24-5.5C18.96 9.22 15.5 7 11.5 7S4.04 9.22 2.26 12.5C4.04 15.78 7.5 18 11.5 18m0-12c4.56 0 8.5 2.65 10.36 6.5C20 16.35 16.06 19 11.5 19S3 16.35 1.14 12.5C3 8.65 6.94 6 11.5 6m0 2C14 8 16 10 16 12.5S14 17 11.5 17 7 15 7 12.5 9 8 11.5 8m0 1A3.5 3.5 0 0 0 8 12.5a3.5 3.5 0 0 0 3.5 3.5a3.5 3.5 0 0 0 3.5-3.5A3.5 3.5 0 0 0 11.5 9" />
                                        @endif
                                    </svg>
                                    {{ ($ujian->juz === null || $ujian->tajwid === null || $ujian->itqan === null) ? 'Input Nilai' : 'Detail' }}
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#6c757d" stroke-width="1.5" class="mb-3">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M16 16s-1.5-2-4-2-4 2-4 2"></path>
                        <line x1="9" y1="9" x2="9.01" y2="9"></line>
                        <line x1="15" y1="9" x2="15.01" y2="9"></line>
                    </svg>
                    <h6 class="text-muted">Tidak ada data ujian ditemukan</h6>
                    <p class="text-muted small mb-0">Silakan tambahkan ujian baru atau sesuaikan filter pencarian</p>
                </div>
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-4">
            {{ $ujianList->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>

    </div>

    <!-- Modal Edit Ujian -->
    <div class="modal fade" id="modalEditUjian" tabindex="-1" aria-labelledby="modalEditUjianLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalEditUjianLabel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                        </svg>
                        Edit Data Ujian
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formEditUjian" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_tahun_ajaran_id" class="form-label fw-bold">Tahun Ajaran <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_tahun_ajaran_id" name="tahun_ajaran_id" required>
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach($tahunList as $tahun)
                                    <option value="{{ $tahun->id_tahunAjaran }}">{{ $tahun->tahun }} - {{ $tahun->semester }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="edit_nis" class="form-label fw-bold">Nama Santri <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_nis" name="nis" required>
                                <option value="">Pilih Santri</option>
                                @foreach($santriList as $santri)
                                    <option value="{{ $santri->nis }}">{{ $santri->nama }} ({{ $santri->nis }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="edit_jenis_ujian" class="form-label fw-bold">Jenis Ujian <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_jenis_ujian" name="jenis_ujian" required>
                                <option value="">Pilih Jenis Ujian</option>
                                <option value="UTS">UTS</option>
                                <option value="UAS">UAS</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="edit_id_penguji" class="form-label fw-bold">Penguji <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_id_penguji" name="id_penguji" required>
                                <option value="">Pilih Penguji</option>
                                @foreach($pendidikList as $pendidik)
                                    <option value="{{ $pendidik->id_pendidik }}">{{ $pendidik->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Sekali Duduk <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sekali_duduk" id="edit_sekali_duduk_ya" value="ya" required>
                                <label class="form-check-label" for="edit_sekali_duduk_ya">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sekali_duduk" id="edit_sekali_duduk_tidak" value="tidak">
                                <label class="form-check-label" for="edit_sekali_duduk_tidak">Tidak</label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn text-white" style="background-color:#1f4b2c;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="white" class="me-1">
                                <path d="M17 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z" />
                            </svg>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="modalHapusUjian" tabindex="-1" aria-labelledby="modalHapusUjianLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-body text-center py-5">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="#dc3545">
                            <path d="M13.435 2.075a3.33 3.33 0 0 0-2.87 0c-.394.189-.755.497-1.26.928l-.079.066a2.56 2.56 0 0 1-1.58.655l-.102.008c-.662.053-1.135.09-1.547.236a3.33 3.33 0 0 0-2.03 2.029c-.145.412-.182.885-.235 1.547l-.008.102a2.56 2.56 0 0 1-.655 1.58l-.066.078c-.431.506-.74.867-.928 1.261a3.33 3.33 0 0 0 0 2.87c.189.394.497.755.928 1.26l.066.079c.41.48.604.939.655 1.58l.008.102c.053.662.09 1.135.236 1.547a3.33 3.33 0 0 0 2.029 2.03c.412.145.885.182 1.547.235l.102.008c.629.05 1.09.238 1.58.655l.078.066c.506.431.867.74 1.261.928a3.33 3.33 0 0 0 2.87 0c.394-.189.755-.497 1.26-.928l.079-.066c.48-.41.939-.604 1.58-.655l.102-.008c.662-.053 1.135-.09 1.547-.236a3.33 3.33 0 0 0 2.03-2.029c.145-.412.182-.885.235-1.547l.008-.102c.05-.629.238-1.09.655-1.58l.066-.079c.431-.505.74-.866.928-1.26a3.33 3.33 0 0 0 0-2.87c-.189-.394-.497-.755-.928-1.26l-.066-.079a2.56 2.56 0 0 1-.655-1.58l-.008-.102c-.053-.662-.09-1.135-.236-1.547a3.33 3.33 0 0 0-2.029-2.03c-.412-.145-.885-.182-1.547-.235l-.102-.008a2.56 2.56 0 0 1-1.58-.655l-.079-.066c-.505-.431-.866-.74-1.26-.928M12 6.877a.75.75 0 0 1 .75.75v5.5a.75.75 0 0 1-1.5 0v-5.5a.75.75 0 0 1 .75-.75m.75 8.996v.5a.75.75 0 0 1-1.5 0v-.5a.75.75 0 0 1 1.5 0" />
                        </svg>
                    </div>
                    <h5 class="fw-bold mb-2">Konfirmasi Penghapusan</h5>
                    <p class="text-muted mb-0">Data ujian yang dihapus tidak dapat dikembalikan. Apakah Anda yakin ingin melanjutkan?</p>
                </div>
                <div class="modal-footer border-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <form id="formHapusUjian" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="white" class="me-1">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Header Custom */
        .header-custom {
            background: linear-gradient(135deg, #1f4b2c 0%, #2d6a3f 100%);
            padding: 2rem 0;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Avatar Circle */
        .avatar-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1f4b2c 0%, #2d6a3f 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Card Hover Effect */
        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15) !important;
        }

        /* Badge Custom */
        .badge-custom {
            font-weight: 500;
            padding: 0.35em 0.65em;
            font-size: 0.85em;
        }

        .badge-info {
            background-color: #17a2b8;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #000;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        .badge-secondary {
            background-color: #6c757d;
            color: white;
        }

        /* Semester badges - distinct colors */
        .semester-ganjil {
            background-color: #28a745; /* Green - for ODD semesters */
            color: #fff;
            font-weight: 500;
        }

        .semester-genap {
            background-color: #fd7e14; /* Orange - for EVEN semesters */
            color: #fff;
            font-weight: 500;
        }

        /* Info Grid for Mobile */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem;
            background-color: #f8f9fa;
            border-radius: 0.375rem;
        }

        .info-label {
            font-weight: 600;
            font-size: 0.875rem;
            color: #6c757d;
        }

        .info-value {
            font-size: 0.875rem;
            color: #212529;
        }

        /* Form Enhancements */
        .form-control:focus,
        .form-select:focus {
            border-color: #1f4b2c;
            box-shadow: 0 0 0 0.2rem rgba(31, 75, 44, 0.25);
        }

        .input-group-text {
            background-color: white;
        }

        /* Button Enhancements */
        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        /* Modal Enhancements */
        .modal-content {
            border-radius: 1rem;
            overflow: hidden;
        }

        .modal-header {
            background-color: #f8f9fa;
        }

        /* Alert Enhancements */
        .alert {
            border: none;
            border-radius: 0.75rem;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .header-custom {
                padding: 1.5rem 0;
            }

            .avatar-circle {
                width: 42px;
                height: 42px;
            }

            .card-body {
                padding: 1rem !important;
            }

            .info-grid {
                font-size: 0.875rem;
            }
        }

        @media (min-width: 768px) {
            .info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #1f4b2c;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #2d6a3f;
        }
    </style>

    <script>
        function editUjian(id, jenisUjian, sekaliDuduk, nis, tahunAjaranId, idPenguji) {
            jenisUjian = jenisUjian === 'null' ? '' : jenisUjian;
            sekaliDuduk = sekaliDuduk || 'tidak';
            nis = nis === 'null' ? '' : nis;
            tahunAjaranId = (tahunAjaranId === 'null' || tahunAjaranId === null) ? '' : tahunAjaranId;
            idPenguji = (idPenguji === 'null' || idPenguji === null) ? '' : idPenguji;

            document.getElementById('edit_jenis_ujian').value = jenisUjian || '';
            document.getElementById('edit_nis').value = nis || '';
            document.getElementById('edit_tahun_ajaran_id').value = tahunAjaranId || '';
            document.getElementById('edit_id_penguji').value = idPenguji || '';
            
            if (sekaliDuduk === 'ya') {
                document.getElementById('edit_sekali_duduk_ya').checked = true;
            } else {
                document.getElementById('edit_sekali_duduk_tidak').checked = true;
            }

            const baseUrl = "{{ url('nilaiTahfidz') }}";
            document.getElementById('formEditUjian').action = `${baseUrl}/${id}`;

            const modalEdit = new bootstrap.Modal(document.getElementById('modalEditUjian'));
            modalEdit.show();
        }

        function confirmDelete(id) {
            const baseUrl = "{{ url('nilaiTahfidz') }}";
            document.getElementById('formHapusUjian').action = `${baseUrl}/${id}`;

            const modalHapus = new bootstrap.Modal(document.getElementById('modalHapusUjian'));
            modalHapus.show();
        }
    </script>

@endsection