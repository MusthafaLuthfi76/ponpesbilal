@extends('layouts.app')

@section('page_title', 'Nilai Kesantrian')

@section('content')
<style>
    /* Tambahkan style yang sama dari NilaiAkademik */
    @media (max-width: 576px) {
        body, .container-fluid {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        .card {
            border-radius: 0;
        }
    }

    .table-header-fancy {
        /* Menggunakan warna yang lebih sesuai untuk Kesantrian (hijau/biru-hijau) */
        background: linear-gradient(45deg, #198754, #20c997); 
        color: #fff !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody tr:hover {
        background-color: #f1f8ff;
        transition: .2s;
    }
</style>

<div class="container-fluid mt-4 px-2"> <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">📚 Daftar Penilaian Kesantrian</h3>
        {{-- Tombol untuk menampilkan modal tambah --}}
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahMapelKesantrianModal">
            <i class="bi bi-plus-circle"></i> Tambah Data
        </button>
    </div>

    {{-- Filter (DIJAGA TETAP ADA) --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Filter Data Nilai Kesantrian</h5>
        </div>
        <div class="card-body py-2">
            <form method="GET" action="{{ route('nilaikesantrian.index') }}">
                <div class="form-group">
                    <label for="id_tahunAjaran">Pilih Tahun Ajaran:</label>
                    <select name="id_tahunAjaran" class="form-control" onchange="this.form.submit()">
                        <option value="">Semua Tahun Ajaran</option>
                        @foreach($tahunAjaran as $ta)
                            <option value="{{ $ta->id_tahunAjaran }}" {{ request('id_tahunAjaran') == $ta->id_tahunAjaran ? 'selected' : '' }}>
                                {{ $ta->tahun }} ({{ $ta->semester }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>
    
    <hr>
    
    {{-- Tabel Daftar Mata Pelajaran --}}
    <div class="card shadow-sm">
        <div class="card-body p-2">
            @if($matapelajaranKesantrian->isEmpty())
                <div class="alert alert-info mb-0">
                    <p class="mb-0">Tidak ada Mata Pelajaran Kesantrian ditemukan untuk filter yang dipilih.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="table-header-fancy">
                            <tr>
                                <th>#</th>
                                <th>Mata Pelajaran</th>
                                <th>Tahun Ajaran</th>
                                <th>Pendidik</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($matapelajaranKesantrian as $mapel)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $mapel->nama_matapelajaran }}</td>
                                <td>
                                    @if($mapel->tahunAjaran)
                                        {{ $mapel->tahunAjaran->tahun }}
                                        <span class="badge bg-info">
                                            Semester {{ strtoupper($mapel->tahunAjaran->semester) }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                {{-- Kolom Pendidik (Asumsi: di tabel mapel kesantrian, kolom id_pendidik juga ada) --}}
                                <td>{{ $mapel->pendidik->nama ?? '-' }}</td> 
                                <td class="text-center">
                                    <a href="{{ route('nilaikesantrian.show', ['id_matapelajaran' => $mapel->id_matapelajaran, 'id_tahunAjaran' => $mapel->id_tahunAjaran]) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-list-columns-reverse"></i> Lihat & Input Nilai
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- MODAL TAMBAH MATA PELAJARAN KESANTRIAN (Tetap sama) --}}
<div class="modal fade" id="tambahMapelKesantrianModal" tabindex="-1" aria-labelledby="tambahMapelKesantrianModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="tambahMapelKesantrianModalLabel">Tambah Data Nilai Kesantrian Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- PERHATIAN: Pastikan action route ini sudah diubah ke 'nilaikesantrian.go.to.detail' jika Anda mengimplementasikan solusi dari jawaban sebelumnya. Saya biarkan `store` sesuai kode awal Anda. --}}
            <form action="{{ route('nilaikesantrian.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    
                    {{-- Dropdown Mata Pelajaran Kesantrian (Template) --}}
                    <div class="mb-3">
                        <label for="id_matapelajaran_modal" class="form-label">Pilih Template Mata Pelajaran Kesantrian:</label>
                        <select name="id_matapelajaran_template" id="id_matapelajaran_modal" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Mata Pelajaran --</option>
                            @foreach($mapelKesantrianList as $mapel)
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

@endsection