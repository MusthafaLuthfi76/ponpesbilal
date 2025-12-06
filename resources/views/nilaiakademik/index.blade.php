@extends('layouts.app')

@section('page_title', 'Daftar Mata Pelajaran')

@section('content')
<style>
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
        background: linear-gradient(45deg, #007bff, #6610f2);
        color: #fff !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody tr:hover {
        background-color: #f1f8ff;
        transition: .2s;
    }

    /* Fix width & alignment untuk kolom aksi */
    th:last-child,
    td:last-child {
        width: 120px !important;
        text-align: center !important;
    }

    /* Wrapper tombol agar selalu rapi */
    .action-center {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.25rem;
    }
</style>

<div class="container-fluid mt-4 px-2">
    <h3 class="mb-3">📘 Daftar Mata Pelajaran</h3>

    <div class="card shadow-sm">
        <div class="card-body p-2">
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
                        @foreach($mapel as $m)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $m->nama_matapelajaran }}</td>
                            <td>
                                @if($m->tahunAjaran)
                                    {{ $m->tahunAjaran->tahun }}
                                    <span class="badge bg-info">
                                        Semester {{ strtoupper($m->tahunAjaran->semester) }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $m->pendidik->nama ?? '-' }}</td>
                            <td>
                                <div class="action-center">
                                    <a href="{{ route('nilaiakademik.mapel.show', $m->id_matapelajaran) }}"
                                       class="btn btn-primary btn-sm">
                                        Lihat
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection