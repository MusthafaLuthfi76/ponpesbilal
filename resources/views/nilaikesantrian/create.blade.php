@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3>Tambah Nilai Kesantrian</h3>

    <div class="card mt-3">
        <div class="card-body">

            <form action="{{ route('nilaikesantrian.store') }}" method="POST">
                @csrf

                {{-- PILIH SANTRI --}}
                <div class="mb-3">
                    <label for="santri_id" class="form-label">Nama Santri</label>
                    <select name="santri_id" id="santri_id" class="form-control" required>
                        <option value="">-- Pilih Santri --</option>
                        @foreach($santri as $s)
                            <option value="{{ $s->id }}">{{ $s->nama }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- PILIH TAHUN AJARAN --}}
                <div class="mb-3">
                    <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
                    <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-control" required>
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        @foreach($tahunAjaran as $t)
                            <option value="{{ $t->id }}">{{ $t->tahun }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- NILAI-NILAI --}}
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Nilai Akhlak</label>
                        <input type="number" name="akhlak" class="form-control" min="0" max="100" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Nilai Disiplin</label>
                        <input type="number" name="disiplin" class="form-control" min="0" max="100" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Nilai Kebersihan</label>
                        <input type="number" name="kebersihan" class="form-control" min="0" max="100" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Nilai Kerapian</label>
                        <input type="number" name="kerapian" class="form-control" min="0" max="100" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                <a href="{{ route('nilaikesantrian.index') }}" class="btn btn-secondary mt-3">Kembali</a>

            </form>

        </div>
    </div>
</div>
@endsection
