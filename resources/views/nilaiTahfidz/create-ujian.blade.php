@extends('layouts.app')

@section('page_title', 'Ujian Baru - Nilai Tahfidz')

@section('content')
    <div class="card-header text-white d-flex justify-content-between align-items-center"
        style="
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            display: flex;
            font-size: 1.5rem;
            background-color: #1f4b2c;
        ">
        <h5 class="mb-0 p-4 w-100 fw-bold">Ujian Baru</h5>
    </div>

    <div class="container-fluid bg-light p-4">
        <div class="card shadow-sm border">
            <div class="card-body">
                <form action="{{ route('nilaiTahfidz.storeUjianBaru') }}" method="POST">
                    @csrf

                    <!-- Tahun Ajaran -->
                    <div class="mb-3">
                        <label for="tahun_ajaran_id" class="form-label fw-bold">Tahun Ajaran <span class="text-danger">*</span></label>
                        <select class="form-select @error('tahun_ajaran_id') is-invalid @enderror" id="tahun_ajaran_id" name="tahun_ajaran_id" required>
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach($tahunAjaranList as $tahun)
                                <option value="{{ $tahun->id_tahunAjaran }}" {{ old('tahun_ajaran_id') == $tahun->id_tahunAjaran ? 'selected' : '' }}>
                                    {{ $tahun->tahun }} - {{ $tahun->semester }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jenis Ujian -->
                    <div class="mb-3">
                        <label for="jenis_ujian" class="form-label fw-bold">Jenis Ujian <span class="text-danger">*</span></label>
                        <select class="form-select @error('jenis_ujian') is-invalid @enderror" id="jenis_ujian" name="jenis_ujian" required>
                            <option value="">Pilih Jenis Ujian</option>
                            <option value="UTS" {{ old('jenis_ujian') == 'UTS' ? 'selected' : '' }}>UTS</option>
                            <option value="UAS" {{ old('jenis_ujian') == 'UAS' ? 'selected' : '' }}>UAS</option>
                        </select>
                        @error('jenis_ujian')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sekali Duduk -->
                    <div class="mb-3">
                        <label class="form-label fw-bold d-block">Sekali Duduk <span class="text-danger">*</span></label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('sekali_duduk') is-invalid @enderror" type="radio" name="sekali_duduk" id="sekali_duduk_ya" value="ya" {{ old('sekali_duduk') == 'ya' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="sekali_duduk_ya">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('sekali_duduk') is-invalid @enderror" type="radio" name="sekali_duduk" id="sekali_duduk_tidak" value="tidak" {{ old('sekali_duduk') == 'tidak' || old('sekali_duduk') == null ? 'checked' : '' }}>
                            <label class="form-check-label" for="sekali_duduk_tidak">Tidak</label>
                        </div>
                        @error('sekali_duduk')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Penguji -->
                    <div class="mb-3">
                        <label for="id_penguji" class="form-label fw-bold">Penguji <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_penguji') is-invalid @enderror" id="id_penguji" name="id_penguji" required>
                            <option value="">Pilih Penguji</option>
                            @foreach($pendidikList as $pendidik)
                                <option value="{{ $pendidik->id_pendidik }}" {{ old('id_penguji') == $pendidik->id_pendidik ? 'selected' : '' }}>
                                    {{ $pendidik->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_penguji')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Santri -->
                    <div class="mb-3">
                        <label for="nis" class="form-label fw-bold">Nama Santri <span class="text-danger">*</span></label>
                        <select class="form-select @error('nis') is-invalid @enderror" id="nis" name="nis" required>
                            <option value="">Pilih Santri</option>
                            @foreach($santriList as $santri)
                                <option value="{{ $santri->nis }}" {{ old('nis') == $santri->nis ? 'selected' : '' }}>
                                    {{ $santri->nama }} ({{ $santri->nis }})
                                </option>
                            @endforeach
                        </select>
                        @error('nis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('nilaiTahfidz.index') }}" class="btn btn-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="white" class="me-2">
                                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                            </svg>
                            Kembali
                        </a>
                        <button type="submit" class="btn text-white" style="background-color:#1f4b2c;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="white" class="me-1">
                                <path d="M17 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

