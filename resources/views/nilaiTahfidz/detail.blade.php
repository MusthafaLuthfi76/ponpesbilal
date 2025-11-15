@extends('layouts.app')

@section('page_title', 'Detail Nilai Tahfidz')

@section('content')
    <div class="card-header text-white d-flex justify-content-between align-items-center"
        style="
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            display: flex;
            font-size: 1.5rem;
            background-color: #1f4b2c;
        ">
        <h5 class="mb-0 p-4 w-100 fw-bold">Detail Nilai Tahfidz</h5>
    </div>

    <div class="container-fluid bg-light p-4">
        <!-- Header Info Santri -->
        <div class="card mb-4 shadow-sm border">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="62" height="62" fill="currentColor"
                        viewBox="0 0 24 24" class="me-3">
                        <path d="M12 2a5 5 0 1 1 0 10a5 5 0 0 1 0-10m0 12c-4.97 0-9 2.69-9 6v2h18v-2c0-3.31-4.03-6-9-6z" />
                    </svg>

                    <div class="flex-grow-1">
                        <h4 class="fw-bold mb-3">{{ $santri->nama }}</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="me-2"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 2 2 7v2h2v9h6v-6h4v6h6V9h2V7l-10-5zM10 18H6v-7.2l4-2.05V18zm8 0h-4v-9.25l4 2.05V18z" />
                                    </svg>
                                    <span><strong>Sekolah:</strong> {{ $santri->status ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="me-2"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M3 5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H3zm2 3h14v2H5V8zm0 4h6v5H5v-5zm8 0h6v5h-6v-5z" />
                                    </svg>
                                    <span><strong>NIS:</strong> {{ $santri->nis ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="me-2"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 12a4 4 0 1 0-0.001-8.001A4 4 0 0 0 12 12zm6 8v-1.5c0-1.93-3.582-3.5-6-3.5s-6 1.57-6 3.5V20h12zM7.5 11.5l2.5 1.5 2-3 2 3 2.5-1.5-3-5H10.5l-3 5z" />
                                    </svg>
                                    <span><strong>Penguji:</strong> Ust.
                                        {{ $santri->halaqah->pendidik->nama ?? 'Belum ditentukan' }}

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="me-2"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M16 2h-4l-1 1H8a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm-4 1h2v2h-2V3zM9 9h6v2H9V9zm0 4h6v2H9v-2z" />
                                    </svg>
                                    <span><strong>Kelompok Halaqah:</strong>
                                        {{ $santri->halaqah->nama_kelompok ?? 'Belum ditentukan' }}

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column align-items-center text-center ms-3">
                        @if ($santri->tahunAjaran)
                            <span class="badge bg-success mb-1 px-3 py-2">
                                Semester {{ $santri->tahunAjaran->semester }}
                            </span>
                            <small class="text-muted fw-bold">{{ $santri->tahunAjaran->tahun }}</small>
                        @else
                            <span class="badge bg-secondary px-3 py-2">Belum ada tahun ajaran</span>
                        @endif


                    </div>
                </div>

                <!-- Filter UTS/UAS -->
                <div class="mt-3 d-flex justify-content-end align-items-center gap-2">
                    <select class="form-select" style="width: auto;" id="filterUjian" onchange="filterData()">
                        <option value="">UTS / UAS</option>
                        <option value="UTS">UTS</option>
                        <option value="UAS">UAS</option>
                    </select>
                    <button class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal"
                        data-bs-target="#modalTambahUjian">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="white">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                        </svg>
                        Tambah Ujian
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabel Data Ujian -->
        <div class="card shadow-sm border">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 5%;">NO</th>
                                <th class="text-center" style="width: 10%;">JENIS</th>
                                <th class="text-center" style="width: 10%;">JUZ</th>
                                <th class="text-center" style="width: 15%;">TAJWID</th>
                                <th class="text-center" style="width: 15%;">ITQAN</th>
                                <th class="text-center" style="width: 15%;">SEKALI DUDUK</th>
                                <th class="text-center" style="width: 20%;">TOTAL KESALAHAN</th>
                                <th class="text-center" style="width: 15%;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ujianList as $index => $ujian)
                                <tr class="ujian-row" data-jenis="{{ $ujian->jenis_ujian }}">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $ujian->jenis_ujian == 'UTS' ? 'bg-info' : 'bg-warning' }}">
                                            {{ $ujian->jenis_ujian }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $ujian->juz }}</td>
                                    <td class="text-center">{{ $ujian->tajwid }}</td>
                                    <td class="text-center">{{ $ujian->itqan }}</td>
                                    <td class="text-center">{{ $ujian->sekali_duduk }}</td>
                                    <td class="text-center"><strong>{{ $ujian->total_kesalahan }}</strong></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Tombol Edit -->
                                            <button
                                                class="btn btn-sm btn-warning rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 32px; height: 32px;" title="Edit"
                                                onclick="editUjian({{ $ujian->id }}, '{{ $ujian->jenis_ujian }}', {{ $ujian->juz }}, {{ $ujian->tajwid }}, {{ $ujian->itqan }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="white">
                                                    <path
                                                        d="M21 12a1 1 0 0 0-1 1v6a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h6a1 1 0 0 0 0-2H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-6a1 1 0 0 0-1-1m-15 .76V17a1 1 0 0 0 1 1h4.24a1 1 0 0 0 .71-.29l6.92-6.93L21.71 8a1 1 0 0 0 0-1.42l-4.24-4.29a1 1 0 0 0-1.42 0l-2.82 2.83l-6.94 6.93a1 1 0 0 0-.29.71m10.76-8.35l2.83 2.83l-1.42 1.42l-2.83-2.83ZM8 13.17l5.93-5.93l2.83 2.83L10.83 16H8Z" />
                                                </svg>
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <button type="button"
                                                class="btn btn-sm btn-danger rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 32px; height: 32px;" title="Hapus"
                                                onclick="confirmDelete({{ $ujian->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="white">
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-info-circle me-2"></i>Tidak ada data ujian ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Penilaian Summary -->
        <div class="card mt-4 shadow-sm border">
            <div class="card-body">
                <h5 class="fw-bold mb-3">PENILAIAN</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Total Kesalahan Tajwid</span>
                                <span class="badge bg-primary fs-6">{{ $totalTajwid ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Total Kesalahan Itqan</span>
                                <span class="badge bg-primary fs-6">{{ $totalItqan ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-success text-white rounded">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">TOTAL KESALAHAN KESELURUHAN</span>
                                <span class="badge bg-white text-success fs-6">{{ $totalKeseluruhan ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-4">
            <a href="{{ route('nilaiTahfidz.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                    fill="white" class="me-2">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Modal Tambah Ujian -->
    <div class="modal fade" id="modalTambahUjian" tabindex="-1" aria-labelledby="modalTambahUjianLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-black">
                    <h5 class="modal-title" id="modalTambahUjianLabel">
                        Tambah Data Ujian
                    </h5>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('nilaiTahfidz.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="nis" value="{{ $santri->nis }}">
                    <input type="hidden" name="tahunAjaran" value="{{ $santri->id_tahunAjaran }}">

                    <div class="modal-body">

                        <!-- Jenis Ujian -->
                        <div class="mb-3">
                            <label for="jenis_ujian" class="form-label fw-bold">Jenis Ujian <span
                                    class="text-danger">*</span></label>
                            <select class="form-select border-gray-300 rounded-lg shadow-sm" id="jenis_ujian"
                                name="jenis_ujian" required>
                                <option value="">Pilih Jenis Ujian</option>
                                <option value="UTS">UTS</option>
                                <option value="UAS">UAS</option>
                            </select>
                        </div>

                        <!-- Juz -->
                        <div class="mb-3">
                            <label for="juz" class="form-label fw-bold">Juz <span
                                    class="text-danger">*</span></label>
                            <select class="form-select border-gray-300 rounded-lg shadow-sm" id="juz"
                                name="juz" required>
                                <option value="">Masukkan Juz</option>
                                @for ($i = 1; $i <= 30; $i++)
                                    <option value="{{ $i }}">Juz {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- Tajwid & Itqan sejajar -->
                        <div class="mb-3">
                            <div class="row">
                                <!-- Tajwid -->
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="tajwid" class="form-label fw-bold">Kesalahan Tajwid <span
                                            class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <button type="button" class="btn btn-success border" style="width:40px;"
                                            onclick="ubahNilai('tajwid', -1)">−</button>
                                        <input type="number"
                                            class="form-control text-center border-gray-300 rounded-lg shadow-sm mx-2"
                                            style="max-width: 100px;" id="tajwid" name="tajwid" value="0"
                                            min="0" required oninput="hitungTotal()">
                                        <button type="button" class="btn btn-success border" style="width:40px;"
                                            onclick="ubahNilai('tajwid', 1)">+</button>
                                    </div>
                                </div>

                                <!-- Itqan -->
                                <div class="col-md-6">
                                    <label for="itqan" class="form-label fw-bold">Kesalahan Itqan <span
                                            class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <button type="button" class="btn btn-success border" style="width:40px;"
                                            onclick="ubahNilai('itqan', -1)">−</button>
                                        <input type="number"
                                            class="form-control text-center border-gray-300 rounded-lg shadow-sm mx-2"
                                            style="max-width: 100px;" id="itqan" name="itqan" value="0"
                                            min="0" required oninput="hitungTotal()">
                                        <button type="button" class="btn btn-success border" style="width:40px;"
                                            onclick="ubahNilai('itqan', 1)">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <!-- Total Kesalahan -->
                        <div class="mb-3">
                            <label for="total_kesalahan" class="form-label fw-bold">Total Kesalahan</label>
                            <input type="number" class="form-control bg-light border-gray-300 rounded-lg shadow-sm"
                                id="total_kesalahan" name="total_kesalahan" readonly>
                        </div>

                        <!-- Sekali Duduk -->
                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Sekali Duduk <span
                                    class="text-danger">*</span></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sekali_duduk" id="sekali_duduk_ya"
                                    value="ya" required>
                                <label class="form-check-label" for="sekali_duduk_ya">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sekali_duduk"
                                    id="sekali_duduk_tidak" value="tidak">
                                <label class="form-check-label" for="sekali_duduk_tidak">Tidak</label>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn text-white" style="background-color:#1f4b2c;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="white" class="me-1">
                                <path
                                    d="M17 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Modal Edit Ujian -->
    <div class="modal fade" id="modalEditUjian" tabindex="-1" aria-labelledby="modalEditUjianLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header  text-black">
                    <h5 class="modal-title" id="modalEditUjianLabel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="black" class="me-2">
                            <path
                                d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                        </svg>
                        Edit Data Ujian
                    </h5>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form id="formEditUjian" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">

                        <!-- Jenis Ujian -->
                        <div class="mb-3">
                            <label for="edit_jenis_ujian" class="form-label fw-bold">Jenis Ujian
                                <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_jenis_ujian" name="jenis_ujian" required>
                                <option value="">Pilih Jenis Ujian</option>
                                <option value="UTS">UTS</option>
                                <option value="UAS">UAS</option>
                            </select>
                        </div>

                        <!-- Juz -->
                        <div class="mb-3">
                            <label for="edit_juz" class="form-label fw-bold">Juz
                                <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_juz" name="juz" min="1"
                                max="30" required>
                        </div>

                        <!-- Tajwid & Itqan sejajar -->
                        <div class="mb-3">
                            <div class="row">
                                <!-- Tajwid -->
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="edit_tajwid" class="form-label fw-bold">Kesalahan Tajwid
                                        <span class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <button type="button" class="btn btn-success border" style="width:40px;"
                                            onclick="ubahNilaiEdit('edit_tajwid', -1)">−</button>
                                        <input type="number"
                                            class="form-control text-center border-gray-300 rounded-lg shadow-sm mx-2"
                                            style="max-width: 100px;" id="edit_tajwid" name="tajwid" value="0"
                                            min="0" required oninput="hitungTotalEdit()">
                                        <button type="button" class="btn btn-success border" style="width:40px;"
                                            onclick="ubahNilaiEdit('edit_tajwid', 1)">+</button>
                                    </div>
                                </div>

                                <!-- Itqan -->
                                <div class="col-md-6">
                                    <label for="edit_itqan" class="form-label fw-bold">Kesalahan Itqan
                                        <span class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <button type="button" class="btn btn-light border" style="width:40px;"
                                            onclick="ubahNilaiEdit('edit_itqan', -1)">−</button>
                                        <input type="number"
                                            class="form-control text-center border-gray-300 rounded-lg shadow-sm mx-2"
                                            style="max-width: 100px;" id="edit_itqan" name="itqan" value="0"
                                            min="0" required oninput="hitungTotalEdit()">
                                        <button type="button" class="btn btn-light border" style="width:40px;"
                                            onclick="ubahNilaiEdit('edit_itqan', 1)">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Kesalahan -->
                        <div class="mb-3">
                            <label for="edit_total_kesalahan" class="form-label fw-bold">Total Kesalahan</label>
                            <input type="number" class="form-control bg-light" id="edit_total_kesalahan"
                                name="total_kesalahan" readonly>
                        </div>

                        <!-- Sekali Duduk -->
                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Sekali Duduk
                                <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sekali_duduk"
                                    id="edit_sekali_duduk_ya" value="ya" required>
                                <label class="form-check-label" for="edit_sekali_duduk_ya">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sekali_duduk"
                                    id="edit_sekali_duduk_tidak" value="tidak">
                                <label class="form-check-label" for="edit_sekali_duduk_tidak">Tidak</label>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn border-success" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="white" class="me-1">
                                <path
                                    d="M17 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z" />
                            </svg>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="modalHapusUjian" tabindex="-1" aria-labelledby="modalHapusUjianLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center py-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                            fill="#1f4b2c" class="ml-auto">
                            <path
                                d="M13.435 2.075a3.33 3.33 0 0 0-2.87 0c-.394.189-.755.497-1.26.928l-.079.066a2.56 2.56 0 0 1-1.58.655l-.102.008c-.662.053-1.135.09-1.547.236a3.33 3.33 0 0 0-2.03 2.029c-.145.412-.182.885-.235 1.547l-.008.102a2.56 2.56 0 0 1-.655 1.58l-.066.078c-.431.506-.74.867-.928 1.261a3.33 3.33 0 0 0 0 2.87c.189.394.497.755.928 1.26l.066.079c.41.48.604.939.655 1.58l.008.102c.053.662.09 1.135.236 1.547a3.33 3.33 0 0 0 2.029 2.03c.412.145.885.182 1.547.235l.102.008c.629.05 1.09.238 1.58.655l.078.066c.506.431.867.74 1.261.928a3.33 3.33 0 0 0 2.87 0c.394-.189.755-.497 1.26-.928l.079-.066c.48-.41.939-.604 1.58-.655l.102-.008c.662-.053 1.135-.09 1.547-.236a3.33 3.33 0 0 0 2.03-2.029c.145-.412.182-.885.235-1.547l.008-.102c.05-.629.238-1.09.655-1.58l.066-.079c.431-.505.74-.866.928-1.26a3.33 3.33 0 0 0 0-2.87c-.189-.394-.497-.755-.928-1.26l-.066-.079a2.56 2.56 0 0 1-.655-1.58l-.008-.102c-.053-.662-.09-1.135-.236-1.547a3.33 3.33 0 0 0-2.029-2.03c-.412-.145-.885-.182-1.547-.235l-.102-.008a2.56 2.56 0 0 1-1.58-.655l-.079-.066c-.505-.431-.866-.74-1.26-.928M12 6.877a.75.75 0 0 1 .75.75v5.5a.75.75 0 0 1-1.5 0v-5.5a.75.75 0 0 1 .75-.75m.75 8.996v.5a.75.75 0 0 1-1.5 0v-.5a.75.75 0 0 1 1.5 0" />
                        </svg>
                        <h5 class="fw-bold">Apakah Anda yakin?</h5>
                        <p class="text-muted">Data ujian yang dihapus tidak dapat dikembalikan!</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn border-success" data-bs-dismiss="modal">Batal</button>
                    <form id="formHapusUjian" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="white">
                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"
                                    d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                            Ya, Hapus!
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table thead th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn-sm.rounded-circle {
            padding: 0;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            transition: all 0.3s ease;
        }

        .badge {
            font-size: 0.85rem;
        }

        .modal-content {
            border-radius: 15px;
            overflow: hidden;
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
        }
    </style>

    <script>
        // Filter Data Ujian
        function filterData() {
            const filter = document.getElementById('filterUjian').value;
            const rows = document.querySelectorAll('.ujian-row');

            rows.forEach(row => {
                row.style.display = (filter === '' || row.dataset.jenis === filter) ? '' : 'none';
            });
        }

        // Hitung Total Kesalahan untuk Modal Tambah
        function hitungTotal() {
            const tajwid = parseInt(document.getElementById('tajwid').value) || 0;
            const itqan = parseInt(document.getElementById('itqan').value) || 0;
            document.getElementById('total_kesalahan').value = tajwid + itqan;
        }

        // Hitung Total Kesalahan untuk Modal Edit
        function hitungTotalEdit() {
            const tajwid = parseInt(document.getElementById('edit_tajwid').value) || 0;
            const itqan = parseInt(document.getElementById('edit_itqan').value) || 0;
            document.getElementById('edit_total_kesalahan').value = tajwid + itqan;
        }

        // Edit Ujian
        function editUjian(id, jenisUjian, juz, tajwid, itqan) {
            document.getElementById('edit_jenis_ujian').value = jenisUjian;
            document.getElementById('edit_juz').value = juz;
            document.getElementById('edit_tajwid').value = tajwid;
            document.getElementById('edit_itqan').value = itqan;
            document.getElementById('edit_total_kesalahan').value = tajwid + itqan;

            // Gunakan base URL dari route helper
            const baseUrl = "{{ url('nilaiTahfidz') }}";
            document.getElementById('formEditUjian').action = `${baseUrl}/${id}`;

            // Tampilkan modal edit
            const modalEdit = new bootstrap.Modal(document.getElementById('modalEditUjian'));
            modalEdit.show();
        }

        // Konfirmasi Hapus
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

        function hitungTotal() {
            const tajwid = parseInt(document.getElementById('tajwid').value || 0);
            const itqan = parseInt(document.getElementById('itqan').value || 0);
            

            function ubahNilaiEdit(field, delta) {
                const input = document.getElementById(field);
                let value = parseInt(input.value) || 0;
                value = Math.max(0, value + delta);
                input.value = value;
                hitungTotalEdit();
            }

            function hitungTotalEdit() {
                const tajwid = parseInt(document.getElementById('edit_tajwid').value) || 0;
                const itqan = parseInt(document.getElementById('edit_itqan').value) || 0;
                document.getElementById('edit_total_kesalahan').value = tajwid + itqan;
            }
            document.getElementById('total_kesalahan').value = tajwid + itqan;
        }
    </script>

@endsection
