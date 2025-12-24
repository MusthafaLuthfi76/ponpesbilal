@extends('layouts.app')

@section('page_title', 'Edit Nilai Kesantrian')

@section('content')
<div class="container mt-4">
    <h3>Edit Nilai Kesantrian</h3>

    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('nilaikesantrian.update', $nilai->id_nilai_kesantrian) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- PILIH SANTRI --}}
                <div class="mb-3">
                    <label class="form-label">Nama Santri</label>
                    <select name="nis" class="form-control" required>
                        <option value="">-- Pilih Santri --</option>
                        @foreach($santri as $s)
                            <option value="{{ $s->nis }}"
                                {{ $nilai->nis == $s->nis ? 'selected' : '' }}>
                                {{ $s->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- PILIH MATA PELAJARAN --}}
                <div class="mb-3">
                    <label class="form-label">Mata Pelajaran</label>
                    <select name="id_matapelajaran" class="form-control" required>
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        @foreach($mapel as $m)
                            <option value="{{ $m->id_matapelajaran }}"
                                {{ $nilai->id_matapelajaran == $m->id_matapelajaran ? 'selected' : '' }}>
                                {{ $m->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- PILIH TAHUN AJARAN --}}
                <div class="mb-3">
                    <label class="form-label">Tahun Ajaran</label>
                    <select name="id_tahunAjaran" class="form-control" required>
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        @foreach($tahunAjaran as $ta)
                            <option value="{{ $ta->id_tahunAjaran }}"
                                {{ $nilai->id_tahunAjaran == $ta->id_tahunAjaran ? 'selected' : '' }}>
                                {{ $ta->tahun }} - Semester {{ strtoupper($ta->semester) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- NILAI --}}
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Akhlak</label>
                        <input type="text" name="nilai_akhlak" class="form-control" value="{{ $nilai->nilai_akhlak }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Ibadah</label>
                        <input type="text" name="nilai_ibadah" class="form-control" value="{{ $nilai->nilai_ibadah }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Kerapian</label>
                        <input type="text" name="nilai_kerapian" class="form-control" value="{{ $nilai->nilai_kerapian }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Kedisiplinan</label>
                        <input type="text" name="nilai_kedisiplinan" class="form-control" value="{{ $nilai->nilai_kedisiplinan }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Ekstrakulikuler</label>
                        <input type="text" name="nilai_ekstrakulikuler" class="form-control" value="{{ $nilai->nilai_ekstrakulikuler }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Buku Pegangan</label>
                        <input type="text" name="nilai_buku_pegangan" class="form-control" value="{{ $nilai->nilai_buku_pegangan }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">💾 Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection
