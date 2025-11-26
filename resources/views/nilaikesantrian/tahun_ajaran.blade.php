@extends('layouts.app')

@section('page_title', 'Tahun Ajaran Nilai Kesantrian')

@section('content')
<div class="container mt-4">
    <h3>📚 Tahun Ajaran Nilai Kesantrian</h3>
    <div class="list-group mt-3">
        @foreach($tahunAjaran as $ta)
            <a href="{{ route('nilaikesantrian.showByTahun', $ta->id_tahunAjaran) }}" class="list-group-item list-group-item-action">
                {{ $ta->tahun }} Semester {{ strtoupper($ta->semester) }}
            </a>
        @endforeach
    </div>
</div>
@endsection
