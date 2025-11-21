@extends('layouts.app')

@section('page_title', 'Nilai Mata Pelajaran')

@section('content')

<style>
/* 🎨 Header Gradien & Sticky */
.table-header-fancy {
    background: linear-gradient(45deg, #007bff, #6610f2);
    color: #fff !important;
    text-transform: uppercase;
    letter-spacing: .6px;
    position: sticky;
    top: 0;
    z-index: 10;
}

/* Hover */
.table tbody tr:hover {
    background-color: #eef6ff;
    transition: .2s;
}

/* Predikat warna */
.predikat-A { color: #0a7b27; font-weight: bold; }
.predikat-B { color: #1c8a74; font-weight: bold; }
.predikat-C { color: #ce7100; font-weight: bold; }
.predikat-D { color: #b00020; font-weight: bold; }

/* Scroll */
.table-responsive {
    max-height: 70vh;
    overflow-y: auto;
}

/* Floating Button mobile */
@media (max-width: 768px) {
    .save-floating {
        position: fixed;
        bottom: 12px;
        right: 12px;
        padding: 8px 18px;
        font-size: 14px;
        z-index: 200;
        border-radius: 30px;
        box-shadow: 0px 4px 10px rgba(0,0,0,0.3);
    }
}

/* Mobile: mode tampilan angka saja */
@media (max-width: 768px) {
    .nilai-input {
        width: 45px;
        font-size: 11px;
        padding: 2px !important;
        background: transparent;
        border: none;
        text-align: center;
    }

    /* Saat fokus: muncul border lagi */
    .nilai-input:focus {
        border: 1px solid #007bff !important;
        background: #fff;
        outline: none;
    }

    /* Pertegas teks */
    .rata, .predikat {
        font-size: 12px !important;
    }

    /* Perbaikan layout sel */
    .table td, .table th {
        padding: 3px !important;
        white-space: nowrap;
    }
}



</style>

<div class="container mt-4">

    <h3 class="mb-3">📗 Nilai Mata Pelajaran</h3>

    <!-- Mapel Info -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5><strong>{{ $mapel->nama_matapelajaran }}</strong></h5>

            <p class="mb-1">Tahun Ajaran:
                <strong>{{ $mapel->tahunAjaran->tahun }} - Semester {{ strtoupper($mapel->tahunAjaran->semester) }}</strong>
            </p>

            <p class="mb-1">Pendidik: <strong>{{ $mapel->pendidik->nama ?? '-' }}</strong></p>

            <a href="{{ route('nilaiakademik.mapel.assign.form', $mapel->id_matapelajaran) }}" class="btn btn-success btn-sm mt-2">+ Assign Santri</a>
            <a href="{{ route('nilaiakademik.mapel.index') }}" class="btn btn-secondary btn-sm mt-2">⬅ Daftar Mata Pelajaran</a>
        </div>
    </div>

    <!-- FORM -->
    <form action="{{ route('nilaiakademik.mapel.updateAll', $mapel->id_matapelajaran) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card shadow-sm">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center align-middle">
                        <thead class="table-header-fancy">
                            <tr>
                                <th>#</th>
                                <th>Santri</th>
                                <th>UTS</th>
                                <th>UAS</th>
                                <th>Praktik</th>
                                <th>Izin</th>
                                <th>Sakit</th>
                                <th>Ghaib</th>
                                <th>Rata-rata</th>
                                <th>Predikat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($nilai as $n)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $n->santri->nama }}</td>

                                <td><input oninput="updateRow(this)" type="number" name="nilai[{{ $n->id_nilai_akademik }}][uts]" value="{{ $n->nilai_UTS }}" class="form-control nilai-input"></td>
                                <td><input oninput="updateRow(this)" type="number" name="nilai[{{ $n->id_nilai_akademik }}][uas]" value="{{ $n->nilai_UAS }}" class="form-control nilai-input"></td>
                                <td><input oninput="updateRow(this)" type="number" name="nilai[{{ $n->id_nilai_akademik }}][praktik]" value="{{ $n->nilai_praktik }}" class="form-control nilai-input"></td>

                                <td><input type="number" name="nilai[{{ $n->id_nilai_akademik }}][izin]" value="{{ $n->jumlah_izin }}" class="form-control"></td>
                                <td><input type="number" name="nilai[{{ $n->id_nilai_akademik }}][sakit]" value="{{ $n->jumlah_sakit }}" class="form-control"></td>
                                <td><input type="number" name="nilai[{{ $n->id_nilai_akademik }}][ghaib]" value="{{ $n->jumlah_ghaib }}" class="form-control"></td>

                                <td>
                                    <input type="text" class="form-control text-center bg-light rata"
                                           readonly value="{{ number_format($n->nilai_rata_rata, 2) }}">
                                </td>

                                <td>
                                    <span class="predikat {{ 'predikat-'. $n->predikat }}">
                                        {{ $n->predikat }}
                                    </span>
                                </td>

                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteNilai('{{ $n->id_nilai_akademik }}')">🗑</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <button class="btn btn-primary mt-3 float-end d-none d-md-inline">💾 Simpan Semua</button>
                <button class="btn btn-primary save-floating d-md-none">💾 Simpan</button>

            </div>
        </div>
    </form>

    <!-- DELETE FORM -->
    <form id="deleteForm" method="POST" style="display:none;">
        @csrf @method('DELETE')
    </form>

</div>

<script>
function deleteNilai(id) {
    if(confirm('Hapus data nilai ini?')) {
        const form = document.getElementById('deleteForm');
        form.action = "{{ route('nilaiakademik.mapel.destroy', ':id') }}".replace(':id', id);
        form.submit();
    }
}

// Auto Count
function updateRow(el) {
    const row = el.closest('tr');
    const uts = Number(row.querySelector('[name*="uts"]').value) || 0;
    const uas = Number(row.querySelector('[name*="uas"]').value) || 0;
    const praktik = Number(row.querySelector('[name*="praktik"]').value) || 0;

    const rata = ((uts + uas + praktik) / 3).toFixed(2);
    const rataEl = row.querySelector('.rata');
    rataEl.value = rata;

    const predEl = row.querySelector('.predikat');

    let predikat = 'D';
    if(rata >= 85) predikat = 'A';
    else if(rata >= 75) predikat = 'B';
    else if(rata >= 65) predikat = 'C';

    predEl.textContent = predikat;
    predEl.className = 'predikat predikat-' + predikat;
}
</script>

@endsection
