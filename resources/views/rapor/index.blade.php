@extends('layouts.app')

@section('page_title', 'Rapor')

@section('content')

    <style>
        /* Dropdown rapor styling */
        .dropdown-menu {
            max-height: 320px;
            overflow-y: auto;
            min-width: 220px !important;
            padding: 0.25rem 0;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .dropdown-header {
            font-size: 0.8rem;
            padding: 0.5rem 1rem !important;
            margin: 0;
            background-color: #f8f9fa;
            color: #2c3e50;
            border-top: 1px solid #e9ecef;
        }

        .dropdown-header:first-of-type {
            border-top: none;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            transition: background-color 0.15s;
        }

        .dropdown-item:hover {
            background-color: #e9ecef;
        }

        .dropdown-divider {
            margin: 0.25rem 0;
        }
    </style>


    {{-- HEADER --}}
    <div class="card-header text-white d-flex align-items-center"
        style="
        border-bottom-left-radius: 30px;
        border-bottom-right-radius: 30px;
        font-size: 1.4rem;
        background-color: #1f4b2c;
    ">
        <h5 class="mb-0 p-3 fw-bold">
            @if ($isAlumniPage ?? false)
                Rapor Alumni
            @else
                Rapor Santri
            @endif
        </h5>

        {{--  Switcher halaman --}}
        <div class="ms-auto me-4">

            @if ($isAlumniPage ?? false)
                <a href="{{ route('rapor.index') }}" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-arrow-left me-1"></i> Ke Rapor Santri
                </a>
            @else
                <a href="{{ route('rapor.alumni.index') }}" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-mortarboard me-1"></i> Rapor Alumni
                </a>
            @endif
        </div>
    </div>

    <div class="container-fluid bg-light p-4">

        {{-- TITLE + SEARCH + FILTER --}}
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h5 class="fw-bold m-0">Cetak Rapor Santri</h5>

            <div class="d-flex gap-2 flex-wrap">
                {{-- FILTER ANGKATAN --}}
                <form method="GET" action="{{ url()->current() }}" id="filterForm" class="d-flex gap-2">
                    <input type="hidden" name="search" value="{{ request('search') }}">

                    <select name="angkatan" id="angkatanFilter" class="form-select" style="width: 150px;">
                        <option value="">Semua Angkatan</option>
                        @foreach ($angkatanList as $angkatan)
                            <option value="{{ $angkatan }}" {{ request('angkatan') == $angkatan ? 'selected' : '' }}>
                                {{ $angkatan }}
                            </option>
                        @endforeach
                    </select>
                </form>

                {{-- SEARCH --}}
                <form method="GET" action="{{ url()->current() }}" class="d-flex" style="width: 250px;" id="searchForm">
                    <input type="hidden" name="angkatan" value="{{ request('angkatan') }}">
                    <input type="text" name="search" id="searchInput" class="form-control"
                        placeholder="Cari nama santri..." value="{{ request('search') }}">
                </form>
            </div>
        </div>

        {{-- BULK ACTION BAR --}}
        <div class="card p-3 shadow-sm mb-3" id="bulkActionBar" style="display: none;">
            <div class="row align-items-center g-2">
                {{-- Bagian Kiri --}}
                <div class="col-auto d-flex align-items-center gap-3">
                    <span id="selectedCountBadge" class="badge bg-primary rounded-pill px-3 py-2">
                        <i class="bi bi-check2-all me-1"></i>
                        <span id="selectedCount">0</span> terpilih
                    </span>

                    <button type="button" class="btn btn-outline-secondary btn-sm" id="selectAllBtn">
                        Pilih Semua di Halaman Ini
                    </button>
                </div>

                {{-- Bagian Kanan --}}
                <div class="col d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-danger btn-sm" id="clearSelectionBtn">
                        <i class="bi bi-x-circle me-1"></i>Batal Pilih
                    </button>

                    <button type="button" class="btn btn-primary btn-sm" id="bulkPrintBtn">
                        <i class="bi bi-printer-fill me-1"></i>Cetak Terpilih
                    </button>
                </div>
            </div>
        </div>

        {{-- CARD WRAPPER --}}
        <div class="card p-3 shadow-sm">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">
                            <input type="checkbox" class="form-check-input" id="checkAll"
                                title="Pilih semua di halaman ini">
                        </th>
                        <th style="width: 70px;">No</th>
                        <th>Nama Lengkap</th>
                        <th>Angkatan</th>
                        <th class="text-center" style="width: 100px;">AKSI</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($santri as $index => $s)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input santri-checkbox" value="{{ $s->nis }}"
                                    data-nama="{{ $s->nama }}" title="Pilih {{ $s->nama }}">
                            </td>
                            <td>{{ $santri->firstItem() + $index }}</td>
                            <td>
                                {{ $s->nama }}
                                @if ($isAlumniPage ?? false)
                                    <span class="badge bg-success ms-2">Alumni</span>
                                @else
                                    <span class="badge bg-primary ms-2">{{ ucfirst($s->status ?? 'aktif') }}</span>
                                @endif
                            </td>
                            <td>{{ $s->angkatan ?? '-' }}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false" title="Pilih rapor untuk {{ $s->nama }}"
                                        data-nis="{{ $s->nis }}" data-bs-auto-close="outside">
                                        <i class="bi bi-file-earmark-text me-1"></i>

                                        <i class="bi bi-chevron-down ms-1"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" data-nis="{{ $s->nis }}"
                                        style="min-width: 220px;">
                                        <li>
                                            <h6 class="dropdown-header">Pilih Periode Rapor</h6>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li class="dropdown-item-text text-muted text-center loading-placeholder">
                                            <div class="spinner-border spinner-border-sm" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            Memuat data...
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-1 mb-2 d-block"></i>
                                Tidak ada data santri
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $santri->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdowns = document.querySelectorAll('.dropdown');

            // Utility: escape HTML untuk keamanan dan tampilan
            function escapeHtml(str) {
                const div = document.createElement('div');
                div.textContent = str;
                return div.innerHTML;
            }


            // Fungsi untuk memuat daftar rapor
            function loadRaporList(nis, dropdownMenu) {
                if (dropdownMenu.dataset.loaded === 'true') return;

                dropdownMenu.innerHTML = `
        <li><h6 class="dropdown-header">Pilih Periode Rapor</h6></li>
        <li><hr class="dropdown-divider"></li>
        <li class="dropdown-item-text text-muted text-center">
            <div class="spinner-border spinner-border-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            Memuat...
        </li>
    `;

                fetch(`{{ route('rapor.list', ['nis' => ':nis']) }}`.replace(':nis', nis), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        dropdownMenu.innerHTML = `
                <li><h6 class="dropdown-header">Pilih Periode Rapor</h6></li>
                <li><hr class="dropdown-divider"></li>
            `;

                        if (!data || data.length === 0) {
                            dropdownMenu.innerHTML += `
                    <li class="dropdown-item-text text-muted text-center">
                        <i class="bi bi-info-circle me-1"></i>
                        Tidak ada rapor tersedia
                    </li>
                `;
                            dropdownMenu.dataset.loaded = 'true';
                            return;
                        }

                        let hasItems = false;

                        data.forEach((rapor, index) => {
                            /* =========================
                               HEADER TAHUN AJARAN dengan KELAS
                               ========================= */
                            const headerItem = document.createElement('li');
                            headerItem.className = 'dropdown-header text-secondary fw-semibold small';

                            // Buat HTML untuk header dengan kelas
                            headerItem.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center">
                        <span>${rapor.label}</span>
                        ${rapor.kelas && rapor.kelas !== '-' ?
                            `<span class="badge bg-light text-dark border ms-2">Kelas ${rapor.kelas}</span>` :
                            ''}
                    </div>
                `;
                            dropdownMenu.appendChild(headerItem);

                            /* =========================
                               RAPOR UTS
                               ========================= */
                            if (rapor.uts_available) {
                                hasItems = true;
                                const utsItem = document.createElement('li');
                                const utsLink = document.createElement('a');

                                utsLink.href =
                                    `{{ route('rapor.cetak', ['nis' => ':nis', 'tahun_ajaran_id' => ':ta', 'jenis_ujian' => 'uts']) }}`
                                    .replace(':nis', nis)
                                    .replace(':ta', rapor.tahun_ajaran_id);

                                utsLink.target = '_blank';
                                utsLink.className =
                                    'dropdown-item d-flex justify-content-between align-items-center';
                                utsLink.innerHTML = `
                        <div>
                            <i class="bi bi-file-earmark-text me-2 text-primary"></i>
                            Rapor UTS
                        </div>
                    `;

                                // Tambahkan tooltip jika ada kelas
                                if (rapor.kelas && rapor.kelas !== '-') {
                                    utsLink.title = `Kelas ${rapor.kelas}`;
                                }

                                utsItem.appendChild(utsLink);
                                dropdownMenu.appendChild(utsItem);
                            }

                            /* =========================
                               RAPOR UAS
                               ========================= */
                            if (rapor.uas_available) {
                                hasItems = true;
                                const uasItem = document.createElement('li');
                                const uasLink = document.createElement('a');

                                uasLink.href =
                                    `{{ route('rapor.cetak', ['nis' => ':nis', 'tahun_ajaran_id' => ':ta', 'jenis_ujian' => 'uas']) }}`
                                    .replace(':nis', nis)
                                    .replace(':ta', rapor.tahun_ajaran_id);

                                uasLink.target = '_blank';
                                uasLink.className =
                                    'dropdown-item d-flex justify-content-between align-items-center';
                                uasLink.innerHTML = `
                        <div>
                            <i class="bi bi-file-earmark-text-fill me-2 text-success"></i>
                            Rapor UAS
                        </div>
                    `;

                                // Tambahkan tooltip jika ada kelas
                                if (rapor.kelas && rapor.kelas !== '-') {
                                    uasLink.title = `Kelas ${rapor.kelas}`;
                                }

                                uasItem.appendChild(uasLink);
                                dropdownMenu.appendChild(uasItem);
                            }

                            /* =========================
                               PEMISAH ANTAR PERIODE
                               ========================= */
                            if (index < data.length - 1) {
                                const separator = document.createElement('li');
                                separator.innerHTML = '<hr class="dropdown-divider">';
                                dropdownMenu.appendChild(separator);
                            }
                        });

                        if (!hasItems) {
                            dropdownMenu.innerHTML += `
                    <li class="dropdown-item-text text-muted text-center">
                        <i class="bi bi-info-circle me-1"></i>
                        Tidak ada data nilai
                    </li>
                `;
                        }

                        dropdownMenu.dataset.loaded = 'true';

                        // Update posisi dropdown (Bootstrap)
                        const dropdown = bootstrap.Dropdown.getInstance(
                            dropdownMenu.closest('.dropdown')
                        );
                        if (dropdown) dropdown.update();
                    })
                    .catch(err => {
                        console.error('Gagal memuat daftar rapor:', err);
                        dropdownMenu.innerHTML = `
                <li><h6 class="dropdown-header">Error</h6></li>
                <li><hr class="dropdown-divider"></li>
                <li class="dropdown-item-text text-danger text-center">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Gagal memuat data<br>
                    <small class="text-muted">Coba lagi nanti</small>
                </li>
            `;
                    });
            }

            // Inisialisasi setiap dropdown
            dropdowns.forEach(dropdown => {
                const button = dropdown.querySelector('button[data-bs-toggle="dropdown"]');
                const dropdownMenu = dropdown.querySelector('.dropdown-menu');
                const nis = button?.dataset.nis;

                if (!button || !dropdownMenu || !nis) return;

                // Muat data saat dropdown *akan dibuka* (belum loaded)
                button.addEventListener('click', function(e) {
                    if (dropdownMenu.dataset.loaded !== 'true') {
                        e.preventDefault(); // Cegah muncul sebelum data siap
                        loadRaporList(nis, dropdownMenu);

                        // Set timeout kecil agar dropdown muncul setelah isi
                        setTimeout(() => {
                            const instance = bootstrap.Dropdown.getOrCreateInstance(button);
                            instance.show();
                        }, 100);
                    }
                });
            });

            // ========== BULK SELECTION LOGIC ==========
            const checkAll = document.getElementById('checkAll');
            const santriCheckboxes = document.querySelectorAll('.santri-checkbox');
            const bulkActionBar = document.getElementById('bulkActionBar');
            const selectedCountSpan = document.getElementById('selectedCount');
            const selectAllBtn = document.getElementById('selectAllBtn');
            const clearSelectionBtn = document.getElementById('clearSelectionBtn');
            const bulkPrintBtn = document.getElementById('bulkPrintBtn');

            const selectedNis = new Set();

            function updateSelectionUI() {
                const count = selectedNis.size;
                selectedCountSpan.textContent = count;
                bulkActionBar.style.display = count > 0 ? 'block' : 'none';

                const allChecked = Array.from(santriCheckboxes).every(cb => cb.checked);
                const someChecked = Array.from(santriCheckboxes).some(cb => cb.checked);
                checkAll.checked = allChecked;
                checkAll.indeterminate = someChecked && !allChecked;
            }

            checkAll?.addEventListener('change', (e) => {
                santriCheckboxes.forEach(cb => {
                    cb.checked = e.target.checked;
                    e.target.checked ? selectedNis.add(cb.value) : selectedNis.delete(cb.value);
                });
                updateSelectionUI();
            });

            santriCheckboxes.forEach(cb => {
                cb.addEventListener('change', (e) => {
                    e.target.checked ? selectedNis.add(e.target.value) : selectedNis.delete(e.target
                        .value);
                    updateSelectionUI();
                });
            });

            selectAllBtn?.addEventListener('click', () => {
                santriCheckboxes.forEach(cb => {
                    cb.checked = true;
                    selectedNis.add(cb.value);
                });
                updateSelectionUI();
            });

            clearSelectionBtn?.addEventListener('click', () => {
                santriCheckboxes.forEach(cb => cb.checked = false);
                selectedNis.clear();
                updateSelectionUI();
            });

            bulkPrintBtn?.addEventListener('click', () => {
                if (selectedNis.size === 0) {
                    alert('⚠️ Pilih minimal 1 santri untuk dicetak!');
                    return;
                }

                if (selectedNis.size > 50) {
                    if (!confirm(
                            `Anda akan mencetak ${selectedNis.size} rapor sekaligus. Proses mungkin memakan waktu.\nLanjutkan?`
                        )) {
                        return;
                    }
                }

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('rapor.cetak.bulk') }}';
                form.target = '_blank';
                form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            ${Array.from(selectedNis).map(nis => `<input type="hidden" name="nis[]" value="${nis}">`).join('')}
        `;
                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            });

            updateSelectionUI();
        });
    </script>
@endpush
