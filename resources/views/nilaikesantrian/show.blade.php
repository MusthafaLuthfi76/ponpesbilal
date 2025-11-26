@extends('layouts.app')

@section('page_title', 'Santri Tahun Ajaran')

@section('content')
<div class="container mt-4">
    <h3>📖 Santri Tahun Ajaran {{ $tahunAjaran->tahun }} Semester {{ strtoupper($tahunAjaran->semester) }}</h3>
    
    <a href="{{ route('nilaikesantrian.assignForm', $tahunAjaran->id_tahunAjaran) }}" class="btn btn-success mb-3">
        ➕ Assign Santri Baru
    </a>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Santri</th>
                        <th>Akhlak</th>
                        <th>Ibadah</th>
                        <th>Kerapian</th>
                        <th>Kedisiplinan</th>
                        <th>Ekstrakulikuler</th>
                        <th>Buku Pegangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($nilai as $n)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $n->santri->nama ?? '-' }}</td>
                        <td>{{ $n->nilai_akhlak }}</td>
                        <td>{{ $n->nilai_ibadah }}</td>
                        <td>{{ $n->nilai_kerapian }}</td>
                        <td>{{ $n->nilai_kedisiplinan }}</td>
                        <td>{{ $n->nilai_ekstrakulikuler }}</td>
                        <td>{{ $n->nilai_buku_pegangan }}</td>
                        <td>
                            <a href="{{ route('nilaikesantrian.edit', $n->id_nilai_kesantrian) }}" class="btn btn-primary btn-sm">✏️ Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
