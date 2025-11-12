@extends('layouts.app')

@section('page_title','Data Nilai Akademik')

@section('content')
<style>
    :root {
        --green:#1f4a34;
        --green-dark:#173e2b;
        --light-green:#cfe9d7;
        --bg:#cdd9cf;
        --panel:#f8fdf9;
        --accent:#234f3a;
        --btn-green:#234f3a;
        --btn-green-hover:#1a3a2b;
        --btn-red:#b91c1c;
        --btn-yellow:#d97706;
    }

    main.content {
        background: var(--panel);
        border-radius: 20px 0 0 0;
        padding: 30px;
    }

    .content-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    .content-header h2 {
        font-size: 20px;
        color: var(--green);
        font-weight: 700;
    }

    .search-filter { display:block; gap:10px; margin-bottom:15px; }
    .filter-and-add-group { display:flex; align-items:center; gap:10px; margin-top:10px; }

    input[type="search"], select.filter {
        max-width:none;
        border:1px solid #ccc;
        border-radius:8px;
        padding:8px 12px;
    }

    .btn-add {
        padding:8px 10px;
        background: var(--btn-green);
        color:white;
        border:none;
        border-radius:8px;
        font-size:14px;
        cursor:pointer;
        transition:0.3s;
    }
    .btn-add:hover { background: var(--btn-green-hover); }

    table { width:100%; border-collapse:collapse; background:white; border-radius:10px; overflow:hidden; }
    th, td { padding:12px 15px; text-align:left; border-bottom:1px solid #e0e0e0; }
    th { background:#f1f5f3; font-weight:600; color:#1f4a34; }
    tr:hover { background:#f9fdfb; }

    .action-btns { display:flex; gap:6px; }
    .btn { border:none; border-radius:6px; padding:6px 10px; cursor:pointer; font-size:13px; color:white; display:inline-flex; align-items:center; justify-content:center; transition:0.3s; }
    .btn-warning { background: var(--btn-yellow); }
    .btn-danger { background: var(--btn-red); }
    .btn-warning:hover { background:#b45309; }
    .btn-danger:hover { background:#7f1d1d; }

    .alert { background:#d1fae5; color:#065f46; padding:10px 14px; border-radius:6px; margin-bottom:10px; }
</style>

<main class="content">
    <div class="search-filter">
        <input type="search" id="searchInput" placeholder="Search...">
        <div class="filter-and-add-group">
            <select id="filterMatpel" class="filter">
                <option value="">Semua Mata Pelajaran</option>
                @foreach($matapelajaran->pluck('nama')->unique() as $mp)
                    <option value="{{ $mp }}">{{ $mp }}</option>
                @endforeach
            </select>
            <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambahNilai">+ Tambah</button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Santri</th>
                <th>Mata Pelajaran</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Praktik</th>
                <th>Rata-Rata</th>
                <th>Predikat</th>
                <th>Keterangan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($nilai as $index => $n)
            <tr>
                <td data-label="No">{{ $index + 1 }}</td>
                <td data-label="Santri">{{ $n->santri->nama ?? '-' }}</td>
                <td data-label="Mata Pelajaran">{{ $n->mataPelajaran->nama ?? '-' }}</td>
                <td data-label="UTS">{{ $n->nilai_UTS ?? '-' }}</td>
                <td data-label="UAS">{{ $n->nilai_UAS ?? '-' }}</td>
                <td data-label="Praktik">{{ $n->nilai_praktik ?? '-' }}</td>
                <td data-label="Rata-Rata">{{ $n->nilai_rata_rata ?? '-' }}</td>
                <td data-label="Predikat">{{ $n->predikat ?? '-' }}</td>
                <td data-label="Keterangan">{{ $n->keterangan ?? '-' }}</td>
                <td data-label="Action">
                    <div class="action-btns">
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $n->id_nilai_akademik }}">✏️</button>
                        <form action="{{ route('nilaiakademik.destroy',$n->id_nilai_akademik) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">🗑️</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="10" style="text-align:center;">Belum ada data nilai</td></tr>
            @endforelse
        </tbody>
    </table>
</main>

{{-- MODAL TAMBAH NILAI --}}
<div class="modal fade" id="modalTambahNilai" tabindex="-1" aria-labelledby="modalTambahNilaiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-sm">
            <form action="{{ route('nilaiakademik.store') }}" method="POST" id="formTambahNilai">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Tambah Nilai</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Santri</label>
                        <select name="nis" class="form-select" required>
                            <option value="" selected disabled>Pilih Santri</option>
                            @foreach($santri as $s)
                                <option value="{{ $s->nis }}">{{ $s->nama }} ({{ $s->nis }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <select name="id_matapelajaran" class="form-select" required>
                            <option value="" selected disabled>Pilih Mata Pelajaran</option>
                            @foreach($matapelajaran as $m)
                                <option value="{{ $m->id_matapelajaran }}">{{ $m->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">UTS</label>
                        <input type="number" step="0.01" name="nilai_UTS" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">UAS</label>
                        <input type="number" step="0.01" name="nilai_UAS" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Praktik</label>
                        <input type="number" step="0.01" name="nilai_praktik" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Izin</label>
                        <input type="number" name="jumlah_izin" class="form-control" value="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Sakit</label>
                        <input type="number" name="jumlah_sakit" class="form-control" value="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Ghaib</label>
                        <input type="number" name="jumlah_ghaib" class="form-control" value="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai Rata-Rata</label>
                        <input type="text" name="nilai_rata_rata" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Predikat</label>
                        <input type="text" name="predikat" class="form-control" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT NILAI --}}
@foreach($nilai as $n)
<div class="modal fade" id="editModal{{ $n->id_nilai_akademik }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-sm">
            <form action="{{ route('nilaiakademik.update', $n->id_nilai_akademik) }}" method="POST" class="formEditNilai">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Nilai</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Santri</label>
                        <select name="nis" class="form-select" required>
                            @foreach($santri as $s)
                                <option value="{{ $s->nis }}" {{ $n->nis == $s->nis ? 'selected' : '' }}>{{ $s->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <select name="id_matapelajaran" class="form-select" required>
                            @foreach($matapelajaran as $m)
                                <option value="{{ $m->id_matapelajaran }}" {{ $n->id_matapelajaran == $m->id_matapelajaran ? 'selected' : '' }}>{{ $m->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">UTS</label>
                        <input type="number" step="0.01" name="nilai_UTS" class="form-control" value="{{ $n->nilai_UTS }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">UAS</label>
                        <input type="number" step="0.01" name="nilai_UAS" class="form-control" value="{{ $n->nilai_UAS }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Praktik</label>
                        <input type="number" step="0.01" name="nilai_praktik" class="form-control" value="{{ $n->nilai_praktik }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Izin</label>
                        <input type="number" name="jumlah_izin" class="form-control" value="{{ $n->jumlah_izin }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Sakit</label>
                        <input type="number" name="jumlah_sakit" class="form-control" value="{{ $n->jumlah_sakit }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Ghaib</label>
                        <input type="number" name="jumlah_ghaib" class="form-control" value="{{ $n->jumlah_ghaib }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" value="{{ $n->keterangan }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai Rata-Rata</label>
                        <input type="text" name="nilai_rata_rata" class="form-control" value="{{ $n->nilai_rata_rata }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Predikat</label>
                        <input type="text" name="predikat" class="form-control" value="{{ $n->predikat }}" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- Script perhitungan otomatis --}}
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function(){
    // Untuk tambah
    const formTambah = document.getElementById('formTambahNilai');
    const inputsTambah = ['nilai_UTS','nilai_UAS','nilai_praktik'];
    const rataTambah = formTambah.querySelector('[name="nilai_rata_rata"]');
    const predTambah = formTambah.querySelector('[name="predikat"]');

    function hitungNilai(inputUTS, inputUAS, inputPrak, outRata, outPred){
        const nUTS = parseFloat(inputUTS.value) || 0;
        const nUAS = parseFloat(inputUAS.value) || 0;
        const nPrak = parseFloat(inputPrak.value) || 0;
        const rata = (0.3*nUTS) + (0.6*nUAS) + (0.1*nPrak);
        outRata.value = rata.toFixed(2);
        let p='';
        if(rata >= 90) p='A';
        else if(rata >= 80) p='B';
        else if(rata >= 65) p='C';
        else p='D';
        outPred.value = p;
    }

    const utsTambah = formTambah.querySelector('[name="nilai_UTS"]');
    const uasTambah = formTambah.querySelector('[name="nilai_UAS"]');
    const prakTambah = formTambah.querySelector('[name="nilai_praktik"]');

    [utsTambah, uasTambah, prakTambah].forEach(i => i.addEventListener('input', ()=> hitungNilai(utsTambah,uasTambah,prakTambah,rataTambah,predTambah)));

    // Untuk edit (loop setiap form edit)
    document.querySelectorAll('.formEditNilai').forEach(form=>{
        const uts = form.querySelector('[name="nilai_UTS"]');
        const uas = form.querySelector('[name="nilai_UAS"]');
        const prak = form.querySelector('[name="nilai_praktik"]');
        const rata = form.querySelector('[name="nilai_rata_rata"]');
        const pred = form.querySelector('[name="predikat"]');
        [uts, uas, prak].forEach(i => i.addEventListener('input', ()=> hitungNilai(uts,uas,prak,rata,pred)));
    });
});
</script>
@endpush
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function(){
    const searchInput = document.getElementById("searchInput");
    const filterMatpel = document.getElementById("filterMatpel");
    const rows = document.querySelectorAll("tbody tr");

    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();
        const selectedMatpel = filterMatpel.value;

        rows.forEach(row => {
            if(row.children.length > 1) {
                const santri = row.children[1].textContent.toLowerCase();
                const matpel = row.children[2].textContent.toLowerCase();
                const matchSearch = santri.includes(searchValue);
                const matchFilter = selectedMatpel === "" || matpel === selectedMatpel.toLowerCase();
                row.style.display = (matchSearch && matchFilter) ? "" : "none";
            }
        });
    }

    searchInput.addEventListener("input", filterTable);
    filterMatpel.addEventListener("change", filterTable);
});
</script>
@endsection
