@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- FORM FILTER --}}
    <form action="{{ route('nilaikesantrian.index') }}" method="GET" class="mb-4">

        <div class="row">

            <!-- Filter Tahun Ajaran -->
            <div class="col-md-3 mb-2">
                <label class="form-label">Tahun Ajaran</label>
                <select name="id_tahunAjaran" class="form-control">
                    <option value="">-- Semua Tahun --</option>
                    @foreach($tahunAjaran as $tahun)
                        <option value="{{ $tahun->id_tahunAjaran }}"
                            {{ request('id_tahunAjaran') == $tahun->id_tahunAjaran ? 'selected' : '' }}>
                            {{ $tahun->tahunAjaran }} - {{ $tahun->semester }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Mata Pelajaran -->
            <div class="col-md-3 mb-2">
                <label class="form-label">Mata Pelajaran</label>
                <select name="id_matapelajaran" class="form-control">
                    <option value="">-- Semua Mapel --</option>
                    @foreach($matapelajaran as $m)
                        <option value="{{ $m->id_matapelajaran }}"
                            {{ request('id_matapelajaran') == $m->id_matapelajaran ? 'selected' : '' }}>
                            {{ $m->nama_matapelajaran }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Search NIS -->
            <div class="col-md-3 mb-2">
                <label class="form-label">Cari NIS</label>
                <input type="text" name="search_nis" 
                    value="{{ request('search_nis') }}"
                    placeholder="Masukkan NIS..."
                    class="form-control">
            </div>

            <!-- Search Nama -->
            <div class="col-md-3 mb-2">
                <label class="form-label">Cari Nama Santri</label>
                <input type="text" name="search_nama"
                    value="{{ request('search_nama') }}"
                    placeholder="Masukkan Nama..."
                    class="form-control">
            </div>

        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('nilaikesantrian.index') }}" class="btn btn-secondary">Reset</a>
        </div>

    </form>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Nilai Kesantrian</h3>
        <a href="{{ route('nilaikesantrian.create') }}" class="btn btn-primary">
            + Tambah Nilai
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Santri</th>
                        <th>Tahun Ajaran</th>
                        <th>Akhlak</th>
                        <th>Disiplin</th>
                        <th>Kebersihan</th>
                        <th>Kerapian</th>
                        <th>Rata-rata</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($nilai as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->santri->nama_lengkap ?? '-' }}</td>
                        <td>{{ $item->tahunAjaran->tahunAjaran ?? '-' }} - {{ $item->tahunAjaran->semester ?? '' }}</td>

                        <td>{{ $item->nilai_akhlak }}</td>
                        <td>{{ $item->nilai_kedisiplinan }}</td>
                        <td>{{ $item->nilai_kebersihan }}</td>
                        <td>{{ $item->nilai_kerapian }}</td>

                        <td>
                            {{ number_format(
                                ($item->nilai_akhlak + $item->nilai_kedisiplinan + $item->nilai_kebersihan + $item->nilai_kerapian) / 4,
                                2
                            ) }}
                        </td>

                        <td>
                            <a href="{{ route('nilaikesantrian.edit', $item->id_nilai_kesantrian) }}" 
                                class="btn btn-sm btn-warning">
                                Edit
                            </a>

                            <!-- Tombol buka modal -->
                            <button class="btn btn-danger btn-sm"
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal{{ $item->id_nilai_kesantrian }}">
                                Hapus
                            </button>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="9" class="text-center">
                            Belum ada data nilai kesantrian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- PAGINATION --}}
            <div class="p-3">
                {{ $nilai->links() }}
            </div>

            {{-- MODAL DELETE --}}
            @foreach($nilai as $n)
            <div class="modal fade" id="deleteModal{{ $n->id_nilai_kesantrian }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <p>
                                Yakin ingin menghapus nilai untuk:
                                <br><strong>{{ $n->santri->nama_lengkap }}</strong><br>
                                Mapel: <strong>{{ $n->mataPelajaran->nama_matapelajaran }}</strong><br>
                                Tahun Ajaran: 
                                <strong>{{ $n->tahunAjaran->tahunAjaran }} ({{ $n->tahunAjaran->semester }})</strong>
                            </p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                            <form action="{{ route('nilaikesantrian.destroy', $n->id_nilai_kesantrian) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Ya, Hapus</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>

</div>
@endsection
