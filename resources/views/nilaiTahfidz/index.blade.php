@extends('layouts.app')

@section('page_title', 'Nilai Tahfidz')

@section('content')

    <div class="card-header text-white d-flex justify-content-between align-items-center"
        style="
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            display: flex;
            font-size: 1.5rem;
            background-color: #1f4b2c;
        ">
        <h5 class="mb-0 p-4 w-100 fw-bold">Nilai Tahfidz</h5>
        <a href="{{ route('nilaiTahfidz.createUjianBaru') }}" class="btn btn-light me-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
            </svg>
            Ujian Baru
        </a>
    </div>

    <div class="container-fluid bg-light p-4" style="position: relative; z-index: 1;">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Filter Form -->
<form method="GET" action="{{ url()->current() }}" class="mb-4" id="filterForm">
    <div class="row align-items-center">

        <div class="col-md-4 mb-2">
            <input type="text" name="search" class="form-control" placeholder="Search..."
                value="{{ request('search') }}" oninput="this.form.submit()">
        </div>

        <div class="col-md-3 mb-2">
            <select name="semester" class="form-select" onchange="this.form.submit()">
                <option value="">Semester</option>
                <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
            </select>
        </div>

        <div class="col-md-3 mb-2">
            <select name="tahun" class="form-select" onchange="this.form.submit()">
                <option value="">Tahun Ajaran</option>
                @foreach($tahunList as $t)
                    <option value="{{ $t->id_tahunAjaran }}"
                        {{ request('tahun') == $t->id_tahunAjaran ? 'selected' : '' }}>
                        {{ $t->tahun }}
                    </option>
                @endforeach
            </select>
        </div>

    </div> <!-- ✅ Penutup row yang sebelumnya hilang -->
</form> <!-- ✅ Penutup form yang benar -->

        <!-- Data List -->
        @forelse ($ujianList as $ujian)
            <div class="card mb-3 shadow-sm border">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">

                        <div class="d-flex align-items-start">
                            <!-- Avatar -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="62" height="62" fill="dark-green"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 2a5 5 0 1 1 0 10a5 5 0 0 1 0-10m0 12c-4.97 0-9 2.69-9 6v2h18v-2c0-3.31-4.03-6-9-6z" />
                            </svg>

                            <div>
                                <h6 class="fw-bold mb-2">{{ $ujian->santri->nama ?? '-' }}</h6>

                                <div class="row g-3">

                                    <div class="col-auto">
                                        <small class="text-muted">
                                            <small class="fw-bold">NIS: </small>{{ $ujian->santri->nis ?? '-' }}
                                        </small>
                                    </div>

                                    <div class="col-auto">
                                        <small class="text-muted">
                                            <small class="fw-bold">Jenis Ujian: </small>
                                            <span class="badge {{ $ujian->jenis_ujian == 'UTS' ? 'bg-info' : 'bg-warning' }}">
                                                {{ $ujian->jenis_ujian }}
                                            </span>
                                        </small>
                                    </div>

                                    <div class="col-auto">
                                        <small class="text-muted">
                                            <small class="fw-bold">Penguji: </small>
                                            {{ $ujian->penguji->nama ?? '-' }}
                                        </small>
                                    </div>

                                    <div class="col-auto">
                                        <small class="text-muted">
                                            <small class="fw-bold">Sekali Duduk: </small>
                                            <span class="badge {{ $ujian->sekali_duduk == 'ya' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ ucfirst($ujian->sekali_duduk) }}
                                            </span>
                                        </small>
                                    </div>

                                    @if($ujian->juz)
                                    <div class="col-auto">
                                        <small class="text-muted">
                                            <small class="fw-bold">Juz: </small>{{ $ujian->juz }}
                                        </small>
                                    </div>
                                    @endif

                                    @if($ujian->tajwid !== null && $ujian->itqan !== null)
                                    <div class="col-auto">
                                        <small class="text-muted">
                                            <small class="fw-bold">Total Kesalahan: </small>
                                            <span class="badge bg-danger">{{ $ujian->total_kesalahan }}</span>
                                        </small>
                                    </div>
                                    @endif

                                </div>

                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-end gap-3">
                            <div class="d-flex flex-column align-items-center text-center">
                                @if ($ujian->tahunAjaran)
                                    <span class="badge bg-success mb-1 px-3 py-2">
                                        Semester {{ $ujian->tahunAjaran->semester }}
                                    </span>
                                    <small class="text-muted fw-bold">{{ $ujian->tahunAjaran->tahun }}</small>
                                @else
                                    <span class="badge bg-secondary mb-0 px-3 py-2">Belum ada tahun ajaran</span>
                                @endif
                            </div>

                            <!-- Tombol Action -->
                            <div class="d-flex align-items-center gap-2">
                            <!-- Tombol Edit -->
                            <button type="button" class="btn btn-warning btn-sm d-flex align-items-center gap-1 text-white" 
                                onclick="editUjian({{ $ujian->id }}, '{{ $ujian->jenis_ujian }}', '{{ $ujian->sekali_duduk }}', '{{ $ujian->nis }}', {{ $ujian->tahun_ajaran_id ?? 'null' }}, {{ $ujian->id_penguji ?? 'null' }})"
                                title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="white">
                                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                    </svg>
                                    Edit
                                </button>

                                <!-- Tombol Delete -->
                                <button type="button" class="btn btn-danger btn-sm d-flex align-items-center gap-1" 
                                    onclick="confirmDelete({{ $ujian->id }})"
                                    title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="white">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                    Hapus
                                </button>

                                <!-- Tombol Input Nilai / Lihat Detail -->
                                <a href="{{ route('nilaiTahfidz.show', $ujian->santri->nis) }}"
                                    class="btn {{ ($ujian->juz === null || $ujian->tajwid === null || $ujian->itqan === null) ? 'btn-success' : 'btn-info' }} btn-sm d-flex align-items-center gap-1 text-white">
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
            <div class="alert alert-info text-center">
                Tidak ada data ujian ditemukan.
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-4">
            {{ $ujianList->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>

    </div> <!-- penutup container -->

    <!-- Modal Edit Ujian -->
    <div class="modal fade" id="modalEditUjian" tabindex="-1" aria-labelledby="modalEditUjianLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-black">
                    <h5 class="modal-title" id="modalEditUjianLabel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="black" class="me-2">
                            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                        </svg>
                        Edit Data Ujian
                    </h5>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formEditUjian" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <!-- Tahun Ajaran -->
                        <div class="mb-3">
                            <label for="edit_tahun_ajaran_id" class="form-label fw-bold">Tahun Ajaran <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_tahun_ajaran_id" name="tahun_ajaran_id" required>
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach($tahunList as $tahun)
                                    <option value="{{ $tahun->id_tahunAjaran }}">{{ $tahun->tahun }} - {{ $tahun->semester }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama Santri -->
                        <div class="mb-3">
                            <label for="edit_nis" class="form-label fw-bold">Nama Santri <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_nis" name="nis" required>
                                <option value="">Pilih Santri</option>
                                @foreach($santriList as $santri)
                                    <option value="{{ $santri->nis }}">{{ $santri->nama }} ({{ $santri->nis }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jenis Ujian -->
                        <div class="mb-3">
                            <label for="edit_jenis_ujian" class="form-label fw-bold">Jenis Ujian <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_jenis_ujian" name="jenis_ujian" required>
                                <option value="">Pilih Jenis Ujian</option>
                                <option value="UTS">UTS</option>
                                <option value="UAS">UAS</option>
                            </select>
                        </div>

                        <!-- Penguji -->
                        <div class="mb-3">
                            <label for="edit_id_penguji" class="form-label fw-bold">Penguji <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_id_penguji" name="id_penguji" required>
                                <option value="">Pilih Penguji</option>
                                @foreach($pendidikList as $pendidik)
                                    <option value="{{ $pendidik->id_pendidik }}">{{ $pendidik->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sekali Duduk -->
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

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn text-white" style="background-color:#1f4b2c;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="white" class="me-1">
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
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center py-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="#dc3545" class="mb-3">
                            <path d="M13.435 2.075a3.33 3.33 0 0 0-2.87 0c-.394.189-.755.497-1.26.928l-.079.066a2.56 2.56 0 0 1-1.58.655l-.102.008c-.662.053-1.135.09-1.547.236a3.33 3.33 0 0 0-2.03 2.029c-.145.412-.182.885-.235 1.547l-.008.102a2.56 2.56 0 0 1-.655 1.58l-.066.078c-.431.506-.74.867-.928 1.261a3.33 3.33 0 0 0 0 2.87c.189.394.497.755.928 1.26l.066.079c.41.48.604.939.655 1.58l.008.102c.053.662.09 1.135.236 1.547a3.33 3.33 0 0 0 2.029 2.03c.412.145.885.182 1.547.235l.102.008c.629.05 1.09.238 1.58.655l.078.066c.506.431.867.74 1.261.928a3.33 3.33 0 0 0 2.87 0c.394-.189.755-.497 1.26-.928l.079-.066c.48-.41.939-.604 1.58-.655l.102-.008c.662-.053 1.135-.09 1.547-.236a3.33 3.33 0 0 0 2.03-2.029c.145-.412.182-.885.235-1.547l.008-.102c.05-.629.238-1.09.655-1.58l.066-.079c.431-.505.74-.866.928-1.26a3.33 3.33 0 0 0 0-2.87c-.189-.394-.497-.755-.928-1.26l-.066-.079a2.56 2.56 0 0 1-.655-1.58l-.008-.102c-.053-.662-.09-1.135-.236-1.547a3.33 3.33 0 0 0-2.029-2.03c-.412-.145-.885-.182-1.547-.235l-.102-.008a2.56 2.56 0 0 1-1.58-.655l-.079-.066c-.505-.431-.866-.74-1.26-.928M12 6.877a.75.75 0 0 1 .75.75v5.5a.75.75 0 0 1-1.5 0v-5.5a.75.75 0 0 1 .75-.75m.75 8.996v.5a.75.75 0 0 1-1.5 0v-.5a.75.75 0 0 1 1.5 0" />
                        </svg>
                        <h5 class="fw-bold">Apakah Anda yakin?</h5>
                        <p class="text-muted">Data ujian yang dihapus tidak dapat dikembalikan!</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <form id="formHapusUjian" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="white">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                            Ya, Hapus!
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .badge.bg-success {
            font-size: 0.85rem;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            transition: all 0.3s ease;
        }
    </style>

    <script>
        // Edit Ujian
        function editUjian(id, jenisUjian, sekaliDuduk, nis, tahunAjaranId, idPenguji) {
            // Handle null values
            jenisUjian = jenisUjian === 'null' ? '' : jenisUjian;
            sekaliDuduk = sekaliDuduk || 'tidak';
            nis = nis === 'null' ? '' : nis;
            tahunAjaranId = (tahunAjaranId === 'null' || tahunAjaranId === null) ? '' : tahunAjaranId;
            idPenguji = (idPenguji === 'null' || idPenguji === null) ? '' : idPenguji;

            // Set form values
            document.getElementById('edit_jenis_ujian').value = jenisUjian || '';
            document.getElementById('edit_nis').value = nis || '';
            document.getElementById('edit_tahun_ajaran_id').value = tahunAjaranId || '';
            document.getElementById('edit_id_penguji').value = idPenguji || '';
            
            // Set radio button sekali duduk
            if (sekaliDuduk === 'ya') {
                document.getElementById('edit_sekali_duduk_ya').checked = true;
            } else {
                document.getElementById('edit_sekali_duduk_tidak').checked = true;
            }

            // Set form action
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
    </script>

@endsection
