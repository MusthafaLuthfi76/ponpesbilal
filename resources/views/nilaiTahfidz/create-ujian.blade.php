@extends('layouts.app')

@section('page_title', 'Ujian Baru - Nilai Tahfidz')

@section('content')
    <div class="card-header text-white d-flex justify-content-between align-items-center"
        style="
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            display: flex;
            font-size: 1.5rem;
            background-color: #1f4b2c;
        ">
        <h5 class="mb-0 p-4 w-100 fw-bold">Ujian Baru</h5>
    </div>

    <div class="container-fluid bg-light p-4">
        <div class="card shadow-sm border">
            <div class="card-body">
                <form id="formCreateUjian" action="{{ route('nilaiTahfidz.storeUjianBaru') }}" method="POST">
                    @csrf

                    <!-- Tahun Ajaran -->
                    <div class="mb-3">
                        <label for="tahun_ajaran_id" class="form-label fw-bold">Tahun Ajaran <span class="text-danger">*</span></label>
                        <select class="form-select @error('tahun_ajaran_id') is-invalid @enderror" id="tahun_ajaran_id" name="tahun_ajaran_id" required>
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach($tahunAjaranList as $tahun)
                                <option value="{{ $tahun->id_tahunAjaran }}" {{ old('tahun_ajaran_id') == $tahun->id_tahunAjaran ? 'selected' : '' }}>
                                    {{ $tahun->tahun }} - {{ $tahun->semester }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Penguji -->
                    <div class="mb-3">
                        <label for="id_penguji" class="form-label fw-bold">Penguji <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_penguji') is-invalid @enderror" id="id_penguji" name="id_penguji" required>
                            <option value="">Pilih Penguji</option>
                            @foreach($pendidikList as $pendidik)
                                <option value="{{ $pendidik->id_pendidik }}" {{ old('id_penguji') == $pendidik->id_pendidik ? 'selected' : '' }}>
                                    {{ $pendidik->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_penguji')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Santri -->
                    <div class="mb-3">
                        <label for="nis" class="form-label fw-bold">Nama Santri <span class="text-danger">*</span></label>
                        <select class="form-select @error('nis') is-invalid @enderror" id="nis" name="nis" required>
                            <option value="">Pilih Santri</option>
                            @foreach($santriList as $santri)
                                <option value="{{ $santri->nis }}" {{ old('nis') == $santri->nis ? 'selected' : '' }}>
                                    {{ $santri->nama }} ({{ $santri->nis }})
                                </option>
                            @endforeach
                        </select>
                        @error('nis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('nilaiTahfidz.index') }}" class="btn btn-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="white" class="me-2">
                                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                            </svg>
                            Kembali
                        </a>
                        <button type="submit" class="btn text-white" style="background-color:#1f4b2c;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="white" class="me-1">
                                <path d="M17 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>

                <!-- Duplicate modal -->
                <div class="modal fade" id="duplicateModal" tabindex="-1" aria-labelledby="duplicateModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="duplicateModalLabel">Kesalahan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p id="duplicateModalMessage" class="mb-0 text-danger fw-semibold"></p>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    (function() {
                        const form = document.getElementById('formCreateUjian');
                        if (!form) return;

                        form.addEventListener('submit', function(e) {
                            e.preventDefault();

                            const formData = new FormData(form);
                            const payload = {
                                nis: formData.get('nis'),
                                tahun_ajaran_id: formData.get('tahun_ajaran_id')
                                // jenis_ujian & sekali_duduk removed
                            };

                            // CSRF token
                            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                                        || form.querySelector('input[name="_token"]')?.value;

                            fetch("{{ route('nilaiTahfidz.checkDuplicate') }}", {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': token,
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(payload)
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.exists) {
                                    const msg = 'Ujian untuk santri ini pada tahun ajaran dan semester yang sama sudah ada.';
                                    const modalEl = document.getElementById('duplicateModal');
                                    if (modalEl) {
                                        const bodyEl = modalEl.querySelector('#duplicateModalMessage');
                                        if (bodyEl) bodyEl.textContent = msg;
                                        const duplicateModal = new bootstrap.Modal(modalEl);
                                        duplicateModal.show();
                                    } else {
                                        alert(msg);
                                    }
                                } else {
                                    form.submit();
                                }
                            })
                            .catch(err => {
                                console.error(err);
                                form.submit(); // fallback
                            });
                        });
                    })();
                </script>
            </div>
        </div>
    </div>
@endsection
