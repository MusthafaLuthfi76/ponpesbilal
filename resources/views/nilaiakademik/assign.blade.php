@extends('layouts.app')

@section('page_title', 'Assign Santri')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">➕ Assign Santri ke Mata Pelajaran</h3>
        <a href="{{ route('nilaiakademik.mapel.show', $mapel->id_matapelajaran) }}" class="btn btn-secondary">
            ⬅ Kembali
        </a>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5><strong>{{ $mapel->nama_matapelajaran }}</strong></h5>
            <p class="mb-1">Tahun Ajaran:
                <strong>{{ $mapel->tahunAjaran->tahun ?? '-' }}</strong>
            </p>
        </div>
    </div>

    <!-- FILTER + SEARCH -->
    <form method="GET" class="card mb-3 shadow-sm">
        <div class="card-body row g-2">

            <div class="col-md-3 col-6">
                <label class="fw-bold small">Angkatan</label>
                <select name="angkatan" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    @foreach($angkatanOptions as $opt)
                        <option value="{{ $opt->angkatan }}" {{ request('angkatan') == $opt->angkatan ? 'selected' : '' }}>
                            {{ $opt->angkatan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 col-6">
                <label class="fw-bold small">Status</label>
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    @foreach($statusOptions as $opt)
                        <option value="{{ $opt->status }}" {{ request('status') == $opt->status ? 'selected' : '' }}>
                            {{ ucfirst($opt->status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 col-12">
                <label class="fw-bold small">Cari Nama</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm" placeholder="Cari santri..."
                       onkeyup="if(event.keyCode==13) this.form.submit()">
            </div>

            <div class="col-md-2 col-6">
                <label class="fw-bold small">Tampilkan</label>
                <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                    @foreach([20, 50, 100] as $num)
                        <option value="{{ $num }}" {{ request('per_page', 20) == $num ? 'selected' : '' }}>
                            {{ $num }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-1 col-6 d-flex align-items-end">
                <a href="{{ route('nilaiakademik.mapel.assign.form', $mapel->id_matapelajaran) }}"
                   class="btn btn-secondary btn-sm w-100">Reset</a>
            </div>

        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body">

            @if($santri->count() == 0)
                <div class="alert alert-warning text-center">
                    Tidak ada data santri untuk ditampilkan.
                </div>
            @else

            <form action="{{ route('nilaiakademik.mapel.assign.store', $mapel->id_matapelajaran) }}" method="POST">
                @csrf

                <!-- INFO PAGINATION -->
                <div class="small text-muted mb-2">
                    Menampilkan
                    <strong>{{ $santri->firstItem() }}</strong> –
                    <strong>{{ $santri->lastItem() }}</strong>
                    dari
                    <strong>{{ $santri->total() }}</strong> santri
                </div>

                <div class="table-responsive" style="max-height: 60vh; overflow-y:auto;">
                    <table class="table table-bordered table-striped align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>#</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Angkatan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($santri as $s)
                            <tr>
                                <td><input type="checkbox" name="nis[]" value="{{ $s->nis }}" class="cekbox-santri"></td>
                                <td>{{ $loop->iteration + $santri->firstItem() - 1 }}</td>
                                <td>{{ $s->nis }}</td>
                                <td>{{ $s->nama }}</td>
                                <td>{{ $s->angkatan }}</td>
                                <td>{{ ucfirst($s->status) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                <div class="d-flex justify-content-center my-2">
                    {{ $santri->links('pagination::bootstrap-5') }}
                </div>

                <!-- STICKY BUTTON (Mobile Friendly) -->
                <div class="sticky-assign text-end">
                    <button class="btn btn-primary px-3 py-1 btn-sm">
                        ✔ Assign Santri Terpilih
                    </button>
                </div>

            </form>
            @endif

        </div>
    </div>

</div>

<style>
.sticky-assign{
    position: sticky;
    bottom: 0;
    background: #ffffff;
    padding: 10px;
    border-top: 1px solid #ddd;
    z-index: 10;
}
@media(max-width: 576px){
    table th, table td{
        font-size: 12px;
        padding: 6px;
    }
}
</style>

<script>
document.getElementById('checkAll')?.addEventListener('change', function() {
    document.querySelectorAll('.cekbox-santri').forEach(cb => cb.checked = this.checked);
});
</script>

@endsection
