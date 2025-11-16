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
    </div>

    <div class="container-fluid bg-light p-4" style="position: relative; z-index: 1;">

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
             </form>

        <!-- Data List -->
        @forelse ($santri as $s)
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
                                <h6 class="fw-bold mb-2">{{ $s->nama }}</h6>

                                <div class="row g-3">

                                    <div class="col-auto">
                                        <small class="text-muted">
                                            <small class="fw-bold">Sekolah: </small>{{ $s->status ?? '-' }}
                                        </small>
                                    </div>

                                    <div class="col-auto">
                                        <small class="text-muted">
                                            <small class="fw-bold">NIS: </small>{{ $s->nis ?? '-' }}
                                        </small>
                                    </div>

                                    <div class="col-auto">
                                        <small class="text-muted">
                                            <small class="fw-bold">Penguji: Ust. </small>
                                            {{ $s->kelompokHalaqah->pendidik->nama ?? 'Belum ditentukan' }}
                                        </small>
                                    </div>

                                    <div class="col-auto">
                                        <small class="text-muted">
                                            <small class="fw-bold">Kelompok Halaqah:</small>
                                            {{ $s->kelompokHalaqah->nama_kelompok ?? 'Belum ditentukan' }}
                                        </small>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-end gap-3">
                            <div class="d-flex flex-column align-items-center text-center">
                                @if ($s->tahunAjaran)
                                    <span class="badge bg-success mb-1 px-3 py-2">
                                        Semester {{ $s->tahunAjaran->semester }}
                                    </span>
                                    <small class="text-muted fw-bold">{{ $s->tahunAjaran->tahun }}</small>
                                @else
                                    <span class="badge bg-secondary mb-0 px-3 py-2">Belum ada tahun ajaran</span>
                                @endif
                            </div>

                            <!-- Tombol Lihat -->
                            <a href="{{ route('nilaiTahfidz.show', $s->nis) }}"
                                class="d-flex align-items-center justify-content-center bg-success text-white rounded-circle shadow-sm"
                                style="width: 40px; height: 40px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="white">
                                    <path
                                        d="M11.5 18c4 0 7.46-2.22 9.24-5.5C18.96 9.22 15.5 7 11.5 7S4.04 9.22 2.26 12.5C4.04 15.78 7.5 18 11.5 18m0-12c4.56 0 8.5 2.65 10.36 6.5C20 16.35 16.06 19 11.5 19S3 16.35 1.14 12.5C3 8.65 6.94 6 11.5 6m0 2C14 8 16 10 16 12.5S14 17 11.5 17 7 15 7 12.5 9 8 11.5 8m0 1A3.5 3.5 0 0 0 8 12.5a3.5 3.5 0 0 0 3.5 3.5a3.5 3.5 0 0 0 3.5-3.5A3.5 3.5 0 0 0 11.5 9" />
                                </svg>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center">
                Tidak ada data santri ditemukan.
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-4">
            {{ $santri->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>

    </div> <!-- penutup container -->

    <style>
        .badge.bg-success {
            font-size: 0.85rem;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            transition: all 0.3s ease;
        }
    </style>

@endsection
