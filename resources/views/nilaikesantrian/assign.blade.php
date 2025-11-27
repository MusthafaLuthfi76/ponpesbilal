@extends('layouts.app')

@section('page_title', 'Assign Santri')

@section('content')
<div class="container mt-4">
    <h3>📌 Assign Santri ke Tahun Ajaran {{ $tahunAjaran->tahun }} Semester {{ strtoupper($tahunAjaran->semester) }}</h3>

    <form action="{{ route('nilaikesantrian.assignStore', $tahunAjaran->id_tahunAjaran) }}" method="POST">
        @csrf

        <div class="list-group">
            @foreach($santri as $s)
                <label class="list-group-item">
                    <input type="checkbox" name="nis[]" value="{{ $s->nis }}">
                    {{ $s->nama }} ({{ $s->angkatan }})
                </label>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mt-3">💾 Assign Terpilih</button>
    </form>
</div>
@endsection
