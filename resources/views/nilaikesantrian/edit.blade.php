@extends('layouts.app')

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
                        @foreach($tahunAjaran as $t)
                            <option value="{{ $t->id_tahunAjaran }}"
                                {{ $nilai->id_tahunAjaran == $t->id_tahunAjaran ? 'selected' : '' }}>
                                {{ $t->tahun_ajaran }} ({{ $t->semester }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- NILAI-NILAI KESANTRIAN --}}
                <div class="row">
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nilai Akhlak</label>
                        <input type="text" name="nilai_akhlak" class="form-control"
                               value="{{ $nilai->nilai_akhlak }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nilai Ibadah</label>
                        <input type="text" name="nilai_ibadah" class="form-control"
                               value="{{ $nilai->nilai_ibadah }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nilai Kerapian</label>
                        <input type="text" name="nilai_kerapian" class="form-control"
                               value="{{ $nilai->nilai_kerapian }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nilai Kedisiplinan</label>
                        <input type="text" name="nilai_kedisiplinan" class="form-control"
                               value="{{ $nilai->nilai_kedisiplinan }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nilai Ekstrakurikuler</label>
                        <input type="text" name="nilai_ekstrakulikuler" class="form-control"
                               value="{{ $nilai->nilai_ekstrakulikuler }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nilai Buku Pegangan</label>
                        <input type="text" name="nilai_buku_pegangan" class="form-control"
                               value="{{ $nilai->nilai_buku_pegangan }}">
                    </div>

                </div>

                <button type="submit" class="btn btn-primary mt-3">Update</button>
                <a href="{{ route('nilaikesantrian.index') }}" class="btn btn-secondary mt-3">Kembali</a>

            </form>

        </div>
    </div>
</div>
@endsection
