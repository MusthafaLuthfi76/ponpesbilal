@extends('layouts.app')

@section('page_title','Data Mata Pelajaran')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Daftar Mata Pelajaran</h5>
</div>

<form method="GET" action="{{ route('matapelajaran.index') }}" class="row g-2 mb-3">
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-text">Search</span>
            <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Cari nama mata pelajaran">
        </div>
    </div>
    <div class="col-md-4">
        <select name="tahun" class="form-select" onchange="this.form.submit()">
            <option value="">Tahun Ajaran</option>
            @foreach($tahunAjaran as $t)
                <option value="{{ $t->id_tahunAjaran }}" {{ (string)$tahunId === (string)$t->id_tahunAjaran ? 'selected' : '' }}>
                    {{ $t->tahun }} - Semester {{ ucfirst($t->semester) }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#createModal">Tambah</button>
    </div>
</form>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Desktop Table View -->
<div class="table-responsive d-none d-lg-block">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr>
                <th>Nama Mata Pelajaran</th>
                <th>Kelas</th>
                <th>Tahun Ajaran</th>
                <th>Pendidik</th>
                <th>KKM</th>
                <th>Bobot UTS</th>
                <th>Bobot UAS</th>
                <th>Bobot Praktik</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($mataPelajaran as $mp)
            <tr>
                <td>{{ $mp->nama_matapelajaran }}</td>
                <td>{{ $mp->kelas }}</td>
                <td>
                    {{ $mp->tahunAjaran?->tahun ?? '-' }} - Semester {{ ucfirst($mp->tahunAjaran?->semester ?? '-') }}
                </td>
                <td>{{ $mp->pendidik->nama ?? '-' }}</td>
                <td>{{ $mp->kkm }}</td>
                <td>{{ $mp->bobot_UTS }}%</td>
                <td>{{ $mp->bobot_UAS }}%</td>
                <td>{{ $mp->bobot_praktik }}%</td>
                <td class="text-center">
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewModal"
                            data-id="{{ $mp->id_matapelajaran }}"
                            data-nama="{{ $mp->nama_matapelajaran }}"
                            data-kelas="{{ $mp->kelas }}"
                            data-materi="{{ $mp->materi_pelajaran }}"
                            data-tahun="{{ $mp->tahunAjaran?->tahun ?? '-' }} - Semester {{ ucfirst($mp->tahunAjaran?->semester ?? '-') }}"
                            data-kkm="{{ $mp->kkm }}"
                            data-uts="{{ $mp->bobot_UTS }}"
                            data-uas="{{ $mp->bobot_UAS }}"
                            data-praktik="{{ $mp->bobot_praktik }}"
                            data-pendidik="{{ $mp->pendidik?->nama ?? '-' }}"
                        ><i class="bi bi-eye"></i></button>

                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal"
                            data-id="{{ $mp->id_matapelajaran }}"
                            data-nama="{{ $mp->nama_matapelajaran }}"
                            data-kelas="{{ $mp->kelas }}"
                            data-materi="{{ $mp->materi_pelajaran }}"
                            data-tahun="{{ $mp->id_tahunAjaran }}"
                            data-kkm="{{ $mp->kkm }}"
                            data-uts="{{ $mp->bobot_UTS }}"
                            data-uas="{{ $mp->bobot_UAS }}"
                            data-praktik="{{ $mp->bobot_praktik }}"
                            data-pendidik="{{ $mp->id_pendidik }}"
                        ><i class="bi bi-pencil-square"></i></button>

                        <form action="{{ route('matapelajaran.destroy', $mp->id_matapelajaran) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus {{ $mp->nama_matapelajaran }}?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">Belum ada data</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<!-- Mobile Card View -->
<div class="d-lg-none">
    @forelse($mataPelajaran as $mp)
    <div class="card mb-3">
        <div class="card-body">
            <h6 class="card-title mb-2">{{ $mp->nama_matapelajaran }}</h6>
            <div class="mb-2">
                <span class="badge bg-primary">Kelas {{ $mp->kelas }}</span>
                <span class="badge bg-secondary">{{ $mp->pendidik->nama ?? '-' }}</span>
            </div>
            <p class="card-text small mb-2">
                <strong>Tahun:</strong> {{ $mp->tahunAjaran?->tahun ?? '-' }} - {{ ucfirst($mp->tahunAjaran?->semester ?? '-') }}
            </p>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-info flex-fill" data-bs-toggle="modal" data-bs-target="#viewModal"
                    data-id="{{ $mp->id_matapelajaran }}"
                    data-nama="{{ $mp->nama_matapelajaran }}"
                    data-kelas="{{ $mp->kelas }}"
                    data-materi="{{ $mp->materi_pelajaran }}"
                    data-tahun="{{ $mp->tahunAjaran?->tahun ?? '-' }} - Semester {{ ucfirst($mp->tahunAjaran?->semester ?? '-') }}"
                    data-kkm="{{ $mp->kkm }}"
                    data-uts="{{ $mp->bobot_UTS }}"
                    data-uas="{{ $mp->bobot_UAS }}"
                    data-praktik="{{ $mp->bobot_praktik }}"
                    data-pendidik="{{ $mp->pendidik?->nama ?? '-' }}"
                ><i class="bi bi-eye"></i> Detail</button>

                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal"
                    data-id="{{ $mp->id_matapelajaran }}"
                    data-nama="{{ $mp->nama_matapelajaran }}"
                    data-kelas="{{ $mp->kelas }}"
                    data-materi="{{ $mp->materi_pelajaran }}"
                    data-tahun="{{ $mp->id_tahunAjaran }}"
                    data-kkm="{{ $mp->kkm }}"
                    data-uts="{{ $mp->bobot_UTS }}"
                    data-uas="{{ $mp->bobot_UAS }}"
                    data-praktik="{{ $mp->bobot_praktik }}"
                    data-pendidik="{{ $mp->id_pendidik }}"
                ><i class="bi bi-pencil-square"></i></button>

                <form action="{{ route('matapelajaran.destroy', $mp->id_matapelajaran) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus {{ $mp->nama_matapelajaran }}?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="alert alert-info">Belum ada data</div>
    @endforelse
</div>

<div class="mt-3 d-flex justify-content-between align-items-center">
    <div class="small text-muted">
        Menampilkan {{ $mataPelajaran->firstItem() }}–{{ $mataPelajaran->lastItem() }} dari {{ $mataPelajaran->total() }} data
    </div>
    {{ $mataPelajaran->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" action="{{ route('matapelajaran.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Mata Pelajaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Nama Mata Pelajaran</label>
              <input type="text" name="nama_matapelajaran" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Kelas</label>
              <select name="kelas" class="form-select" required>
                <option value="">Pilih Kelas</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Materi Pelajaran</label>
              <textarea name="materi_pelajaran" class="form-control" rows="3" placeholder="Opsional"></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label">Tahun Ajaran</label>
              <select name="id_tahunAjaran" class="form-select" required>
                <option value="">Pilih Tahun Ajaran</option>
                @foreach($tahunAjaran as $t)
                    <option value="{{ $t->id_tahunAjaran }}">
                        {{ $t->tahun }} - Semester {{ ucfirst($t->semester) }}
                    </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Pendidik</label>
              <select name="id_pendidik" class="form-select" required>
                <option value="">Pilih Pendidik</option>
                @foreach($pendidik as $p)
                  <option value="{{ $p->id_pendidik }}">{{ $p->nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">KKM</label>
              <input type="number" name="kkm" class="form-control" min="0" max="100" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Bobot UTS</label>
              <input type="number" name="bobot_UTS" class="form-control bobot-input" min="0" max="100" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Bobot UAS</label>
              <input type="number" name="bobot_UAS" class="form-control bobot-input" min="0" max="100" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Bobot Praktik</label>
              <input type="number" name="bobot_praktik" class="form-control bobot-input" min="0" max="100" required>
            </div>
            <div class="col-12">
              <div class="alert alert-info mb-0">
                <strong>Total Bobot:</strong> <span id="create_total_bobot">0</span>% 
                <span id="create_bobot_status" class="ms-2"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" id="create_submit_btn" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="editForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Edit Mata Pelajaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Nama Mata Pelajaran</label>
              <input type="text" name="nama_matapelajaran" id="edit_nama" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Kelas</label>
              <select name="kelas" id="edit_kelas" class="form-select" required>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Materi Pelajaran</label>
              <textarea name="materi_pelajaran" id="edit_materi" class="form-control" rows="3"></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label">Tahun Ajaran</label>
              <select name="id_tahunAjaran" id="edit_tahun" class="form-select" required>
                @foreach($tahunAjaran as $t)
                    <option value="{{ $t->id_tahunAjaran }}">
                        {{ $t->tahun }} - Semester {{ ucfirst($t->semester) }}
                    </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Pendidik</label>
              <select name="id_pendidik" id="edit_pendidik" class="form-select" required>
                @foreach($pendidik as $p)
                  <option value="{{ $p->id_pendidik }}">{{ $p->nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">KKM</label>
              <input type="number" name="kkm" id="edit_kkm" class="form-control" min="0" max="100" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Bobot UTS</label>
              <input type="number" name="bobot_UTS" id="edit_uts" class="form-control bobot-input-edit" min="0" max="100" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Bobot UAS</label>
              <input type="number" name="bobot_UAS" id="edit_uas" class="form-control bobot-input-edit" min="0" max="100" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Bobot Praktik</label>
              <input type="number" name="bobot_praktik" id="edit_praktik" class="form-control bobot-input-edit" min="0" max="100" required>
            </div>
            <div class="col-12">
              <div class="alert alert-info mb-0">
                <strong>Total Bobot:</strong> <span id="edit_total_bobot">0</span>% 
                <span id="edit_bobot_status" class="ms-2"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" id="edit_submit_btn" class="btn btn-warning">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal View -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Mata Pelajaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <dl class="row mb-0">
          <dt class="col-sm-4">ID</dt><dd class="col-sm-8" id="v_id"></dd>
          <dt class="col-sm-4">Nama</dt><dd class="col-sm-8" id="v_nama"></dd>
          <dt class="col-sm-4">Kelas</dt><dd class="col-sm-8" id="v_kelas"></dd>
          <dt class="col-sm-4">Materi</dt><dd class="col-sm-8" id="v_materi"></dd>
          <dt class="col-sm-4">Tahun Ajaran</dt><dd class="col-sm-8" id="v_tahun"></dd>
          <dt class="col-sm-4">Pendidik</dt><dd class="col-sm-8" id="v_pendidik"></dd>
          <dt class="col-sm-4">KKM</dt><dd class="col-sm-8" id="v_kkm"></dd>
          <dt class="col-sm-4">Bobot UTS</dt><dd class="col-sm-8" id="v_uts"></dd>
          <dt class="col-sm-4">Bobot UAS</dt><dd class="col-sm-8" id="v_uas"></dd>
          <dt class="col-sm-4">Bobot Praktik</dt><dd class="col-sm-8" id="v_praktik"></dd>
        </dl>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
// ============== CREATE MODAL ==============
const createModal = document.getElementById('createModal');

createModal.addEventListener('show.bs.modal', () => {
  updateCreateBobot();
});

document.querySelectorAll('#createModal .bobot-input').forEach(input => {
  input.addEventListener('input', updateCreateBobot);
});

function updateCreateBobot() {
  const uts = parseFloat(document.querySelector('#createModal input[name="bobot_UTS"]').value) || 0;
  const uas = parseFloat(document.querySelector('#createModal input[name="bobot_UAS"]').value) || 0;
  const praktik = parseFloat(document.querySelector('#createModal input[name="bobot_praktik"]').value) || 0;
  
  const total = uts + uas + praktik;
  const totalSpan = document.getElementById('create_total_bobot');
  const statusSpan = document.getElementById('create_bobot_status');
  const submitBtn = document.getElementById('create_submit_btn');
  
  totalSpan.textContent = total.toFixed(2);
  
  if (total === 100) {
    statusSpan.innerHTML = '<span class="badge bg-success">✓ Sesuai (100%)</span>';
    submitBtn.disabled = false;
  } else if (total < 100) {
    statusSpan.innerHTML = `<span class="badge bg-warning">Kurang ${(100 - total).toFixed(2)}%</span>`;
    submitBtn.disabled = false;
  } else {
    statusSpan.innerHTML = `<span class="badge bg-danger">Lebih ${(total - 100).toFixed(2)}%</span>`;
    submitBtn.disabled = false;
  }
}

// ============== EDIT MODAL ==============
const editModal = document.getElementById('editModal');

editModal.addEventListener('show.bs.modal', event => {
  const btn = event.relatedTarget;
  const id = btn.getAttribute('data-id');
  document.getElementById('edit_nama').value = btn.getAttribute('data-nama');
  document.getElementById('edit_kelas').value = btn.getAttribute('data-kelas');
  document.getElementById('edit_materi').value = btn.getAttribute('data-materi') || '';
  document.getElementById('edit_tahun').value = btn.getAttribute('data-tahun');
  document.getElementById('edit_kkm').value = btn.getAttribute('data-kkm');
  document.getElementById('edit_uts').value = btn.getAttribute('data-uts');
  document.getElementById('edit_uas').value = btn.getAttribute('data-uas');
  document.getElementById('edit_praktik').value = btn.getAttribute('data-praktik');
  document.getElementById('edit_pendidik').value = btn.getAttribute('data-pendidik');
  document.getElementById('editForm').action = `/matapelajaran/${id}`;
  
  updateEditBobot();
});

document.querySelectorAll('#editModal .bobot-input-edit').forEach(input => {
  input.addEventListener('input', updateEditBobot);
});

function updateEditBobot() {
  const uts = parseFloat(document.getElementById('edit_uts').value) || 0;
  const uas = parseFloat(document.getElementById('edit_uas').value) || 0;
  const praktik = parseFloat(document.getElementById('edit_praktik').value) || 0;
  
  const total = uts + uas + praktik;
  const totalSpan = document.getElementById('edit_total_bobot');
  const statusSpan = document.getElementById('edit_bobot_status');
  const submitBtn = document.getElementById('edit_submit_btn');
  
  totalSpan.textContent = total.toFixed(2);
  
  if (total === 100) {
    statusSpan.innerHTML = '<span class="badge bg-success">✓ Sesuai (100%)</span>';
    submitBtn.disabled = false;
  } else if (total < 100) {
    statusSpan.innerHTML = `<span class="badge bg-warning">Kurang ${(100 - total).toFixed(2)}%</span>`;
    submitBtn.disabled = false;
  } else {
    statusSpan.innerHTML = `<span class="badge bg-danger">Lebih ${(total - 100).toFixed(2)}%</span>`;
    submitBtn.disabled = false;
  }
}

// ============== VIEW MODAL ==============
const viewModal = document.getElementById('viewModal');
viewModal.addEventListener('show.bs.modal', event => {
  const b = event.relatedTarget;
  document.getElementById('v_id').textContent = b.getAttribute('data-id');
  document.getElementById('v_nama').textContent = b.getAttribute('data-nama');
  document.getElementById('v_kelas').textContent = b.getAttribute('data-kelas');
  document.getElementById('v_materi').textContent = b.getAttribute('data-materi') || '-';
  document.getElementById('v_tahun').textContent = b.getAttribute('data-tahun');
  document.getElementById('v_pendidik').textContent = b.getAttribute('data-pendidik');
  document.getElementById('v_kkm').textContent = b.getAttribute('data-kkm');
  document.getElementById('v_uts').textContent = b.getAttribute('data-uts') + '%';
  document.getElementById('v_uas').textContent = b.getAttribute('data-uas') + '%';
  document.getElementById('v_praktik').textContent = b.getAttribute('data-praktik') + '%';
});
</script>
@endpush
@endsection