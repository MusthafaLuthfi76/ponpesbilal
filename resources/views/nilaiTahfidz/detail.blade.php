@extends('layouts.app')

@section('page_title', 'Detail Nilai Tahfidz')

@section('content')
    <!-- Header yang Lebih Modern -->
    <div class="custom-header">
        <div class="container-fluid">
            <div class="d-flex align-items-center py-3 px-2">
                <a href="{{ route('nilaiTahfidz.index') }}" class="btn btn-light btn-sm me-3 d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                    </svg>
                    <span class="d-none d-sm-inline">Kembali</span>
                </a>
                <h5 class="mb-0 fw-bold text-white flex-grow-1">Detail Nilai Tahfidz</h5>
            </div>
        </div>
    </div>

    <div class="container-fluid px-3 px-md-4 py-4">
        <!-- Card Info Santri - Redesigned -->
        <div class="card modern-card mb-4">
            <div class="card-body p-3 p-md-4">
                <div class="row g-3 g-md-4">
                    <!-- Avatar & Nama -->
                    <div class="col-12">
                        <div class="d-flex align-items-center flex-wrap">
                            <div class="avatar-circle me-3 mb-2 mb-sm-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2a5 5 0 1 1 0 10a5 5 0 0 1 0-10m0 12c-4.97 0-9 2.69-9 6v2h18v-2c0-3.31-4.03-6-9-6z" />
                                </svg>
                            </div>
                            <div class="flex-grow-1">
                                <h4 class="fw-bold mb-1">{{ $santri->nama }}</h4>
                                <span class="text-muted small">NIS: {{ $santri->nis ?? '-' }}</span>
                            </div>
                            <div class="mt-2 mt-sm-0">
                                @if ($santri->tahunAjaran)
                                    <span class="badge badge-semester">
                                        Semester {{ $santri->tahunAjaran->semester }}
                                    </span>
                                    <div class="text-muted small mt-1 text-center">{{ $santri->tahunAjaran->tahun }}</div>
                                @else
                                    <span class="badge bg-secondary">Belum ada tahun ajaran</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Info Detail Grid -->
                    <div class="col-12">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="info-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="mb-2">
                                        <path d="M12 2 2 7v2h2v9h6v-6h4v6h6V9h2V7l-10-5zM10 18H6v-7.2l4-2.05V18zm8 0h-4v-9.25l4 2.05V18z" />
                                    </svg>
                                    <div class="small text-muted">Sekolah</div>
                                    <div class="fw-semibold">{{ $santri->status ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="info-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="mb-2">
                                        <path d="M12 12a4 4 0 1 0-0.001-8.001A4 4 0 0 0 12 12zm6 8v-1.5c0-1.93-3.582-3.5-6-3.5s-6 1.57-6 3.5V20h12z" />
                                    </svg>
                                    <div class="small text-muted">Penguji</div>
                                    <div class="fw-semibold">
                                        @if(isset($ujianPertama) && $ujianPertama->penguji)
                                            {{ $ujianPertama->penguji->nama }}
                                        @else
                                            <span class="text-muted">Belum ditentukan</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="info-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="mb-2">
                                        <path d="M16 2h-4l-1 1H8a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm-4 1h2v2h-2V3zM9 9h6v2H9V9zm0 4h6v2H9v-2z" />
                                    </svg>
                                    <div class="small text-muted">Kelompok Halaqah</div>
                                    <div class="fw-semibold">{{ $santri->halaqah->nama_kelompok ?? 'Belum ditentukan' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter & Action Buttons -->
                    <div class="col-12">
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            @if(isset($ujianGroups) && $ujianGroups->count() > 1)
                            <form method="GET" action="{{ route('nilaiTahfidz.show', $santri->nis) }}" class="flex-grow-1" style="max-width: 300px;">
                                <select class="form-select form-select-sm" name="group" onchange="this.form.submit()">
                                    <option value="">Pilih Sesi Ujian</option>
                                    @foreach($ujianGroups as $groupKey => $groupUjian)
                                        @php
                                            $firstUjian = $groupUjian->first();
                                            $tanggal = $firstUjian->created_at ? $firstUjian->created_at->format('d/m/Y') : '-';
                                            $label = $firstUjian->jenis_ujian . ' - ' . ucfirst($firstUjian->sekali_duduk) . ' (' . $tanggal . ')';
                                        @endphp
                                        <option value="{{ $groupKey }}" {{ $selectedGroupKey == $groupKey ? 'selected' : '' }}>
                                            {{ $label }} ({{ $groupUjian->count() }} juz)
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                            @endif
                            <select class="form-select form-select-sm" style="max-width: 150px;" id="filterUjian" onchange="filterData()">
                                <option value="">Semua</option>
                                <option value="UTS">UTS</option>
                                <option value="UAS">UAS</option>
                            </select>
                            <button class="btn btn-primary btn-sm d-flex align-items-center gap-2 ms-auto" data-bs-toggle="modal" data-bs-target="#modalTambahUjian">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="white">
                                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                                </svg>
                                <span class="d-none d-sm-inline">Tambah Ujian</span>
                                <span class="d-inline d-sm-none">Tambah</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Data Ujian - Mobile Responsive -->
        <div class="card modern-card mb-4">
            <div class="card-body p-0">
                <!-- Desktop Table -->
                <div class="table-responsive d-none d-lg-block">
                    <table class="table table-hover mb-0 modern-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%;">NO</th>
                                <th class="text-center" style="width: 10%;">JENIS</th>
                                <th class="text-center" style="width: 10%;">JUZ</th>
                                <th class="text-center" style="width: 15%;">TAJWID</th>
                                <th class="text-center" style="width: 15%;">ITQAN</th>
                                <th class="text-center" style="width: 15%;">SEKALI DUDUK</th>
                                <th class="text-center" style="width: 15%;">TOTAL</th>
                                <th class="text-center" style="width: 15%;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ujianList as $index => $ujian)
                                <tr class="ujian-row" data-jenis="{{ $ujian->jenis_ujian }}">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $ujian->jenis_ujian == 'UTS' ? 'badge-uts' : 'badge-uas' }}">
                                            {{ $ujian->jenis_ujian }}
                                        </span>
                                    </td>
                                    <td class="text-center fw-semibold">{{ $ujian->juz }}</td>
                                    <td class="text-center">{{ $ujian->tajwid }}</td>
                                    <td class="text-center">{{ $ujian->itqan }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $ujian->sekali_duduk == 'ya' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($ujian->sekali_duduk) }}
                                        </span>
                                    </td>
                                    <td class="text-center"><strong class="text-primary">{{ $ujian->total_kesalahan }}</strong></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="btn btn-sm btn-warning btn-icon" title="Edit"
                                                onclick="editUjian({{ $ujian->id }}, '{{ $ujian->jenis_ujian }}', {{ $ujian->juz }}, {{ $ujian->tajwid }}, {{ $ujian->itqan }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="white">
                                                    <path d="M21 12a1 1 0 0 0-1 1v6a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h6a1 1 0 0 0 0-2H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-6a1 1 0 0 0-1-1m-15 .76V17a1 1 0 0 0 1 1h4.24a1 1 0 0 0 .71-.29l6.92-6.93L21.71 8a1 1 0 0 0 0-1.42l-4.24-4.29a1 1 0 0 0-1.42 0l-2.82 2.83l-6.94 6.93a1 1 0 0 0-.29.71m10.76-8.35l2.83 2.83l-1.42 1.42l-2.83-2.83ZM8 13.17l5.93-5.93l2.83 2.83L10.83 16H8Z" />
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger btn-icon" title="Hapus"
                                                onclick="confirmDelete({{ $ujian->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="white">
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" class="mb-2 opacity-50">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                                            </svg>
                                            <div>Tidak ada data ujian ditemukan</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="d-lg-none">
                    @forelse ($ujianList as $index => $ujian)
                        <div class="mobile-card ujian-row" data-jenis="{{ $ujian->jenis_ujian }}">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <span class="badge {{ $ujian->jenis_ujian == 'UTS' ? 'badge-uts' : 'badge-uas' }} me-2">
                                        {{ $ujian->jenis_ujian }}
                                    </span>
                                    <span class="badge {{ $ujian->sekali_duduk == 'ya' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($ujian->sekali_duduk) }}
                                    </span>
                                </div>
                                <span class="text-muted small">#{{ $index + 1 }}</span>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-4">
                                    <div class="mobile-stat">
                                        <div class="small text-muted">Juz</div>
                                        <div class="fw-bold fs-5">{{ $ujian->juz }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mobile-stat">
                                        <div class="small text-muted">Tajwid</div>
                                        <div class="fw-bold fs-5">{{ $ujian->tajwid }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mobile-stat">
                                        <div class="small text-muted">Itqan</div>
                                        <div class="fw-bold fs-5">{{ $ujian->itqan }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="small text-muted">Total Kesalahan:</span>
                                    <span class="fw-bold text-primary ms-1 fs-5">{{ $ujian->total_kesalahan }}</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-warning btn-icon"
                                        onclick="editUjian({{ $ujian->id }}, '{{ $ujian->jenis_ujian }}', {{ $ujian->juz }}, {{ $ujian->tajwid }}, {{ $ujian->itqan }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="white">
                                            <path d="M21 12a1 1 0 0 0-1 1v6a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h6a1 1 0 0 0 0-2H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-6a1 1 0 0 0-1-1m-15 .76V17a1 1 0 0 0 1 1h4.24a1 1 0 0 0 .71-.29l6.92-6.93L21.71 8a1 1 0 0 0 0-1.42l-4.24-4.29a1 1 0 0 0-1.42 0l-2.82 2.83l-6.94 6.93a1 1 0 0 0-.29.71m10.76-8.35l2.83 2.83l-1.42 1.42l-2.83-2.83ZM8 13.17l5.93-5.93l2.83 2.83L10.83 16H8Z" />
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger btn-icon"
                                        onclick="confirmDelete({{ $ujian->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="white">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" class="mb-2 opacity-50 text-muted">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                            </svg>
                            <div class="text-muted">Tidak ada data ujian ditemukan</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Penilaian Summary - Responsive -->
        <div class="card modern-card">
            <div class="card-body p-3 p-md-4">
                <h5 class="fw-bold mb-3">PENILAIAN</h5>
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <div class="summary-box summary-tajwid">
                            <div class="small text-muted mb-1">Total Kesalahan Tajwid</div>
                            <div class="fs-3 fw-bold">{{ $totalTajwid ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="summary-box summary-itqan">
                            <div class="small text-muted mb-1">Total Kesalahan Itqan</div>
                            <div class="fs-3 fw-bold">{{ $totalItqan ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="summary-box summary-total">
                            <div class="small mb-1">TOTAL KESELURUHAN</div>
                            <div class="fs-3 fw-bold">{{ $totalKeseluruhan ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Ujian -->
    <div class="modal fade" id="modalTambahUjian" tabindex="-1" aria-labelledby="modalTambahUjianLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content modern-modal">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalTambahUjianLabel">Tambah Data Ujian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('nilaiTahfidz.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="nis" value="{{ $santri->nis }}">
                    <input type="hidden" name="tahunAjaran" value="{{ $santri->id_tahunAjaran }}">
                    @if(isset($ujianPertama))
                        <input type="hidden" name="jenis_ujian" value="{{ $ujianPertama->jenis_ujian }}">
                        <input type="hidden" name="sekali_duduk" value="{{ $ujianPertama->sekali_duduk }}">
                        <input type="hidden" name="id_penguji" value="{{ $ujianPertama->id_penguji }}">
                    @endif

                    <div class="modal-body">
                        @if(isset($ujianPertama))
                            <div class="alert alert-info">
                                <div class="d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="16" x2="12" y2="12"></line>
                                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                    </svg>
                                    <div>
                                        <strong>Ujian:</strong> {{ $ujianPertama->jenis_ujian }} -
                                        <span class="badge {{ $ujianPertama->sekali_duduk == 'ya' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($ujianPertama->sekali_duduk) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mb-3">
                                <label for="jenis_ujian" class="form-label fw-semibold">Jenis Ujian <span class="text-danger">*</span></label>
                                <select class="form-select" id="jenis_ujian" name="jenis_ujian" required>
                                    <option value="">Pilih Jenis Ujian</option>
                                    <option value="UTS">UTS</option>
                                    <option value="UAS">UAS</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="id_penguji" class="form-label fw-semibold">Penguji <span class="text-danger">*</span></label>
                                <select class="form-select" id="id_penguji" name="id_penguji" required>
                                    <option value="">Pilih Penguji</option>
                                    @if(isset($pendidikList) && $pendidikList->count() > 0)
                                        @foreach($pendidikList as $pendidik)
                                            <option value="{{ $pendidik->id_pendidik }}">{{ $pendidik->nama }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="juz" class="form-label fw-semibold">Juz <span class="text-danger">*</span></label>
                            <select class="form-select" id="juz" name="juz" required>
                                <option value="">Pilih Juz</option>
                                @for ($i = 1; $i <= 30; $i++)
                                    <option value="{{ $i }}">Juz {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label for="tajwid" class="form-label fw-semibold">Kesalahan Tajwid <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-outline-success" onclick="ubahNilai('tajwid', -1)">−</button>
                                    <input type="number" class="form-control text-center" id="tajwid" name="tajwid" value="0" min="0" required oninput="hitungTotal()">
                                    <button type="button" class="btn btn-outline-success" onclick="ubahNilai('tajwid', 1)">+</button>
                                </div>
                            </div>

                            <div class="col-6">
                                <label for="itqan" class="form-label fw-semibold">Kesalahan Itqan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-outline-success" onclick="ubahNilai('itqan', -1)">−</button>
                                    <input type="number" class="form-control text-center" id="itqan" name="itqan" value="0" min="0" required oninput="hitungTotal()">
                                    <button type="button" class="btn btn-outline-success" onclick="ubahNilai('itqan', 1)">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="total_kesalahan" class="form-label fw-semibold">Total Kesalahan</label>
                            <input type="number" class="form-control bg-light" id="total_kesalahan" name="total_kesalahan" readonly>
                        </div>

                        @if(!isset($ujianPertama))
                            <div class="mb-3">
                                <label class="form-label fw-semibold d-block">Sekali Duduk <span class="text-danger">*</span></label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sekali_duduk" id="sekali_duduk_ya" value="ya" required>
                                    <label class="form-check-label" for="sekali_duduk_ya">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sekali_duduk" id="sekali_duduk_tidak" value="tidak">
                                    <label class="form-check-label" for="sekali_duduk_tidak">Tidak</label>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="white" class="me-1">
                                <path d="M17 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Ujian -->
    <div class="modal fade" id="modalEditUjian" tabindex="-1" aria-labelledby="modalEditUjianLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content modern-modal">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalEditUjianLabel">Edit Data Ujian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formEditUjian" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="nis" value="{{ $santri->nis }}">
                    <input type="hidden" name="tahun_ajaran_id" value="{{ $santri->id_tahunAjaran }}">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_jenis_ujian" class="form-label fw-semibold">Jenis Ujian <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_jenis_ujian" name="jenis_ujian" required>
                                <option value="">Pilih Jenis Ujian</option>
                                <option value="UTS">UTS</option>
                                <option value="UAS">UAS</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="edit_juz" class="form-label fw-semibold">Juz <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_juz" name="juz" min="1" max="30" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label for="edit_tajwid" class="form-label fw-semibold">Kesalahan Tajwid <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-outline-success" onclick="ubahNilaiEdit('edit_tajwid', -1)">−</button>
                                    <input type="number" class="form-control text-center" id="edit_tajwid" name="tajwid" value="0" min="0" required oninput="hitungTotalEdit()">
                                    <button type="button" class="btn btn-outline-success" onclick="ubahNilaiEdit('edit_tajwid', 1)">+</button>
                                </div>
                            </div>

                            <div class="col-6">
                                <label for="edit_itqan" class="form-label fw-semibold">Kesalahan Itqan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-outline-success" onclick="ubahNilaiEdit('edit_itqan', -1)">−</button>
                                    <input type="number" class="form-control text-center" id="edit_itqan" name="itqan" value="0" min="0" required oninput="hitungTotalEdit()">
                                    <button type="button" class="btn btn-outline-success" onclick="ubahNilaiEdit('edit_itqan', 1)">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_total_kesalahan" class="form-label fw-semibold">Total Kesalahan</label>
                            <input type="number" class="form-control bg-light" id="edit_total_kesalahan" name="total_kesalahan" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold d-block">Sekali Duduk <span class="text-danger">*</span></label>
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

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
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
            <div class="modal-content modern-modal">
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="#dc3545" class="mb-2">
                            <path d="M13.435 2.075a3.33 3.33 0 0 0-2.87 0c-.394.189-.755.497-1.26.928l-.079.066a2.56 2.56 0 0 1-1.58.655l-.102.008c-.662.053-1.135.09-1.547.236a3.33 3.33 0 0 0-2.03 2.029c-.145.412-.182.885-.235 1.547l-.008.102a2.56 2.56 0 0 1-.655 1.58l-.066.078c-.431.506-.74.867-.928 1.261a3.33 3.33 0 0 0 0 2.87c.189.394.497.755.928 1.26l.066.079c.41.48.604.939.655 1.58l.008.102c.053.662.09 1.135.236 1.547a3.33 3.33 0 0 0 2.029 2.03c.412.145.885.182 1.547.235l.102.008c.629.05 1.09.238 1.58.655l.078.066c.506.431.867.74 1.261.928a3.33 3.33 0 0 0 2.87 0c.394-.189.755-.497 1.26-.928l.079-.066c.48-.41.939-.604 1.58-.655l.102-.008c.662-.053 1.135-.09 1.547-.236a3.33 3.33 0 0 0 2.03-2.029c.145-.412.182-.885.235-1.547l.008-.102c.05-.629.238-1.09.655-1.58l.066-.079c.431-.505.74-.866.928-1.26a3.33 3.33 0 0 0 0-2.87c-.189-.394-.497-.755-.928-1.26l-.066-.079a2.56 2.56 0 0 1-.655-1.58l-.008-.102c-.053-.662-.09-1.135-.236-1.547a3.33 3.33 0 0 0-2.029-2.03c-.412-.145-.885-.182-1.547-.235l-.102-.008a2.56 2.56 0 0 1-1.58-.655l-.079-.066c-.505-.431-.866-.74-1.26-.928M12 6.877a.75.75 0 0 1 .75.75v5.5a.75.75 0 0 1-1.5 0v-5.5a.75.75 0 0 1 .75-.75m.75 8.996v.5a.75.75 0 0 1-1.5 0v-.5a.75.75 0 0 1 1.5 0" />
                        </svg>
                    </div>
                    <h5 class="fw-bold mb-2">Konfirmasi Hapus</h5>
                    <p class="text-muted">Data ujian yang dihapus tidak dapat dikembalikan!</p>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="formHapusUjian" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Ya, Hapus!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-color: #1f4b2c;
            --primary-light: #2d6b42;
            --secondary-color: #f8f9fa;
            --border-radius: 12px;
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.12);
        }

        body {
            background-color: #f5f7fa;
        }

        .custom-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border-bottom-left-radius: 24px;
            border-bottom-right-radius: 24px;
            box-shadow: var(--shadow-md);
            margin-bottom: 1.5rem;
        }

        .modern-card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .modern-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .avatar-circle {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }

        .info-box {
            padding: 1rem;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            border-radius: 10px;
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s ease;
        }

        .info-box:hover {
            transform: translateX(4px);
            box-shadow: var(--shadow-sm);
        }

        .badge-semester {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .badge-uts {
            background: linear-gradient(135deg, #36d1dc 0%, #5b86e5 100%);
            color: white;
            font-weight: 600;
        }

        .badge-uas {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            font-weight: 600;
        }

        .modern-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .modern-table thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 1rem;
            border: none;
        }

        .modern-table tbody tr {
            transition: all 0.2s ease;
        }

        .modern-table tbody tr:hover {
            background-color: #f8f9fc;
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .modern-table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-icon:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .mobile-card {
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
            transition: all 0.2s ease;
        }

        .mobile-card:hover {
            background-color: #f8f9fc;
        }

        .mobile-card:last-child {
            border-bottom: none;
        }

        .mobile-stat {
            text-align: center;
            padding: 0.75rem;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            border-radius: 8px;
        }

        .summary-box {
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .summary-tajwid {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .summary-itqan {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .summary-total {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .summary-box:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .modern-modal .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            border-bottom: none;
        }

        .modern-modal .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .modern-modal .modal-footer {
            border-top: 1px solid #e9ecef;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(31, 75, 44, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Responsive Improvements */
        @media (max-width: 768px) {
            .custom-header .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .modern-card .card-body {
                padding: 1rem !important;
            }

            .info-box {
                padding: 0.75rem;
            }

            .summary-box {
                padding: 1rem;
            }

            .avatar-circle {
                width: 48px;
                height: 48px;
            }

            .btn-icon {
                width: 28px;
                height: 28px;
            }

            .badge-semester {
                padding: 0.35rem 0.75rem;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 576px) {
            .custom-header h5 {
                font-size: 1.1rem;
            }

            .modern-card .card-body h4 {
                font-size: 1.25rem;
            }

            .fs-3 {
                font-size: 1.5rem !important;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modern-card {
            animation: fadeInUp 0.5s ease-out;
        }

        .modern-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .modern-card:nth-child(3) {
            animation-delay: 0.2s;
        }
    </style>

    <script>
        function filterData() {
            const filter = document.getElementById('filterUjian').value;
            const rows = document.querySelectorAll('.ujian-row');
            rows.forEach(row => {
                row.style.display = (filter === '' || row.dataset.jenis === filter) ? '' : 'none';
            });
        }

        function hitungTotal() {
            const tajwid = parseInt(document.getElementById('tajwid').value) || 0;
            const itqan = parseInt(document.getElementById('itqan').value) || 0;
            document.getElementById('total_kesalahan').value = tajwid + itqan;
        }

        function hitungTotalEdit() {
            const tajwid = parseInt(document.getElementById('edit_tajwid').value) || 0;
            const itqan = parseInt(document.getElementById('edit_itqan').value) || 0;
            document.getElementById('edit_total_kesalahan').value = tajwid + itqan;
        }

        function editUjian(id, jenisUjian, juz, tajwid, itqan) {
            document.getElementById('edit_jenis_ujian').value = jenisUjian;
            document.getElementById('edit_juz').value = juz;
            document.getElementById('edit_tajwid').value = tajwid;
            document.getElementById('edit_itqan').value = itqan;
            document.getElementById('edit_total_kesalahan').value = tajwid + itqan;

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

        function ubahNilai(id, delta) {
            const input = document.getElementById(id);
            let val = parseInt(input.value || 0);
            val = Math.max(0, val + delta);
            input.value = val;
            hitungTotal();
        }

        function ubahNilaiEdit(field, delta) {
            const input = document.getElementById(field);
            let value = parseInt(input.value) || 0;
            value = Math.max(0, value + delta);
            input.value = value;
            hitungTotalEdit();
        }
    </script>

@endsection
