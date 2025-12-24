@extends('layouts.app')

@section('page_title', 'Ujian Baru - Nilai Tahfidz')

@push('styles')
<style>
    /* Styling untuk autocomplete */
    .autocomplete-wrapper {
        position: relative;
        width: 100%;
    }
    
    .autocomplete-input {
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        background-color: #fff;
    }
    
    .autocomplete-input:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .autocomplete-input.is-invalid {
        border-color: #dc3545;
    }
    
    .autocomplete-list {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        max-height: 300px;
        overflow-y: auto;
        background: white;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        z-index: 1000;
        display: none;
        margin-top: 2px;
    }
    
    .autocomplete-list.show {
        display: block;
    }
    
    .autocomplete-item {
        padding: 0.5rem 0.75rem;
        cursor: pointer;
        transition: background-color 0.15s ease-in-out;
    }
    
    .autocomplete-item:hover,
    .autocomplete-item.active {
        background-color: #0d6efd;
        color: white;
    }
    
    .autocomplete-no-result {
        padding: 0.5rem 0.75rem;
        color: #6c757d;
        font-style: italic;
    }
</style>
@endpush

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
            <div class="card-body p-4">
                <form id="formCreateUjian" action="{{ route('nilaiTahfidz.storeUjianBaru') }}" method="POST">
                    @csrf

                    <!-- Tahun Ajaran -->
                    <div class="mb-4">
                        <label for="tahun_ajaran_id" class="form-label fw-bold">
                            Tahun Ajaran <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('tahun_ajaran_id') is-invalid @enderror" 
                                id="tahun_ajaran_id" 
                                name="tahun_ajaran_id" 
                                required>
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach($tahunAjaranList as $tahun)
                                <option value="{{ $tahun->id_tahunAjaran }}" 
                                        {{ old('tahun_ajaran_id') == $tahun->id_tahunAjaran ? 'selected' : '' }}>
                                    {{ $tahun->tahun }} - {{ $tahun->semester }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jenis Ujian -->
                    <div class="mb-4">
                        <label for="jenis_ujian" class="form-label fw-bold">
                            Jenis Ujian <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('jenis_ujian') is-invalid @enderror" 
                                id="jenis_ujian" 
                                name="jenis_ujian" 
                                required>
                            <option value="">Pilih Jenis Ujian</option>
                            <option value="UTS" {{ old('jenis_ujian') == 'UTS' ? 'selected' : '' }}>UTS</option>
                            <option value="UAS" {{ old('jenis_ujian') == 'UAS' ? 'selected' : '' }}>UAS</option>
                        </select>
                        @error('jenis_ujian')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sekali Duduk -->
                    <div class="mb-4">
                        <label for="sekali_duduk" class="form-label fw-bold">
                            Sekali Duduk <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('sekali_duduk') is-invalid @enderror" 
                                id="sekali_duduk" 
                                name="sekali_duduk" 
                                required>
                            <option value="">Pilih</option>
                            <option value="ya" {{ old('sekali_duduk', 'tidak') == 'ya' ? 'selected' : '' }}>Ya</option>
                            <option value="tidak" {{ old('sekali_duduk', 'tidak') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('sekali_duduk')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Penguji -->
                    <div class="mb-4">
                        <label for="penguji_search" class="form-label fw-bold">
                            Penguji <span class="text-danger">*</span>
                        </label>
                        <div class="autocomplete-wrapper">
                            <input type="text" 
                                   class="form-control autocomplete-input @error('id_penguji') is-invalid @enderror" 
                                   id="penguji_search" 
                                   placeholder="Ketik untuk mencari penguji..."
                                   autocomplete="off"
                                   value="{{ old('penguji_name') }}">
                            <input type="hidden" 
                                   id="id_penguji" 
                                   name="id_penguji" 
                                   value="{{ old('id_penguji') }}"
                                   required>
                            <div class="autocomplete-list" id="penguji_list"></div>
                        </div>
                        @error('id_penguji')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Santri -->
                    <div class="mb-4">
                        <label for="santri_search" class="form-label fw-bold">
                            Nama Santri <span class="text-danger">*</span>
                        </label>
                        <div class="autocomplete-wrapper">
                            <input type="text" 
                                   class="form-control autocomplete-input @error('nis') is-invalid @enderror" 
                                   id="santri_search" 
                                   placeholder="Ketik untuk mencari santri..."
                                   autocomplete="off"
                                   value="{{ old('santri_name') }}">
                            <input type="hidden" 
                                   id="nis" 
                                   name="nis" 
                                   value="{{ old('nis') }}"
                                   required>
                            <div class="autocomplete-list" id="santri_list"></div>
                        </div>
                        @error('nis')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol -->
                    <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                        <a href="{{ route('nilaiTahfidz.index') }}" class="btn btn-secondary px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="white" class="me-2">
                                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                            </svg>
                            Kembali
                        </a>
                        <button type="submit" class="btn text-white px-4" style="background-color:#1f4b2c;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="white" class="me-2">
                                <path d="M17 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Duplicate modal -->
    <div class="modal fade" id="duplicateModal" tabindex="-1" aria-labelledby="duplicateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold text-danger" id="duplicateModalLabel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                        Kesalahan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <p id="duplicateModalMessage" class="mb-0 text-dark"></p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (function() {
        // Data untuk autocomplete
        const pendidikData = @json($pendidikList->map(function($p) {
            return ['id' => $p->id_pendidik, 'nama' => $p->nama];
        }));
        
        const santriData = @json($santriList->map(function($s) {
            return ['id' => $s->nis, 'nama' => $s->nama, 'nis' => $s->nis];
        }));
        
        // Autocomplete function
        function initAutocomplete(inputId, listId, hiddenId, data, displayKey) {
            const input = document.getElementById(inputId);
            const list = document.getElementById(listId);
            const hidden = document.getElementById(hiddenId);
            let currentFocus = -1;
            
            if (!input || !list || !hidden) return;
            
            // Handle input event
            input.addEventListener('input', function() {
                const value = this.value.toLowerCase();
                currentFocus = -1;
                list.innerHTML = '';
                
                if (!value) {
                    list.classList.remove('show');
                    hidden.value = '';
                    return;
                }
                
                const filtered = data.filter(item => {
                    const searchText = displayKey === 'santri' 
                        ? `${item.nama} ${item.nis}`.toLowerCase()
                        : item.nama.toLowerCase();
                    return searchText.includes(value);
                });
                
                if (filtered.length === 0) {
                    list.innerHTML = '<div class="autocomplete-no-result">Tidak ada hasil</div>';
                    list.classList.add('show');
                    hidden.value = '';
                    return;
                }
                
                filtered.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'autocomplete-item';
                    div.textContent = displayKey === 'santri' 
                        ? `${item.nama} (${item.nis})`
                        : item.nama;
                    div.dataset.id = item.id;
                    div.dataset.name = displayKey === 'santri' 
                        ? `${item.nama} (${item.nis})`
                        : item.nama;
                    
                    div.addEventListener('click', function() {
                        input.value = this.dataset.name;
                        hidden.value = this.dataset.id;
                        list.classList.remove('show');
                        input.classList.remove('is-invalid');
                    });
                    
                    list.appendChild(div);
                });
                
                list.classList.add('show');
            });
            
            // Handle keyboard navigation
            input.addEventListener('keydown', function(e) {
                const items = list.querySelectorAll('.autocomplete-item');
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    currentFocus++;
                    addActive(items);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    currentFocus--;
                    addActive(items);
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (currentFocus > -1 && items[currentFocus]) {
                        items[currentFocus].click();
                    }
                } else if (e.key === 'Escape') {
                    list.classList.remove('show');
                }
            });
            
            function addActive(items) {
                if (!items.length) return;
                removeActive(items);
                if (currentFocus >= items.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = items.length - 1;
                items[currentFocus].classList.add('active');
                items[currentFocus].scrollIntoView({ block: 'nearest' });
            }
            
            function removeActive(items) {
                items.forEach(item => item.classList.remove('active'));
            }
            
            // Close list when clicking outside
            document.addEventListener('click', function(e) {
                if (e.target !== input) {
                    list.classList.remove('show');
                }
            });
            
            // Validate on blur
            input.addEventListener('blur', function() {
                setTimeout(() => {
                    if (!hidden.value && input.value) {
                        input.classList.add('is-invalid');
                    }
                }, 200);
            });
        }
        
        // Initialize autocomplete for both fields
        initAutocomplete('penguji_search', 'penguji_list', 'id_penguji', pendidikData, 'penguji');
        initAutocomplete('santri_search', 'santri_list', 'nis', santriData, 'santri');
        
        // Set initial values if exists
        const oldPengujiId = '{{ old("id_penguji") }}';
        const oldNis = '{{ old("nis") }}';
        
        if (oldPengujiId) {
            const penguji = pendidikData.find(p => p.id == oldPengujiId);
            if (penguji) {
                document.getElementById('penguji_search').value = penguji.nama;
                document.getElementById('id_penguji').value = penguji.id;
            }
        }
        
        if (oldNis) {
            const santri = santriData.find(s => s.nis == oldNis);
            if (santri) {
                document.getElementById('santri_search').value = `${santri.nama} (${santri.nis})`;
                document.getElementById('nis').value = santri.nis;
            }
        }
        
        // Form submission with duplicate check
        const form = document.getElementById('formCreateUjian');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const payload = {
                    nis: formData.get('nis'),
                    tahun_ajaran_id: formData.get('tahun_ajaran_id'),
                    jenis_ujian: formData.get('jenis_ujian'),
                    sekali_duduk: formData.get('sekali_duduk'),
                    id_penguji: formData.get('id_penguji')
                };

                const token = document.querySelector('meta[name="csrf-token"]') 
                    ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                    : form.querySelector('input[name="_token"]').value;

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
                        const msg = 'Ujian untuk santri ini pada kombinasi penguji, semester, dan jenis ujian tersebut sudah ada.';
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
                    console.error('Error checking duplicate:', err);
                    form.submit();
                });
            });
        }
    })();
</script>
@endpush