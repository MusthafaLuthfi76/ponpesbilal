@extends('layouts.app')

@section('page_title', 'Rapor')

@section('content')

    {{-- HEADER --}}
    <div class="card-header text-white d-flex align-items-center"
        style="
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            font-size: 1.4rem;
            background-color: #1f4b2c;
        ">
        <h5 class="mb-0 p-3 fw-bold">Rapor</h5>
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
                        <option value="">Angkatan</option>
                        @foreach($angkatanList as $angkatan)
                            <option value="{{ $angkatan }}" {{ request('angkatan') == $angkatan ? 'selected' : '' }}>
                                {{ $angkatan }}
                            </option>

                            </option>
                        @endforeach
                    </select>
                </form>

                {{-- SEARCH --}}
                <form method="GET" action="{{ url()->current() }}" class="d-flex" style="width: 250px;" id="searchForm">
                    <input type="hidden" name="angkatan" value="{{ request('angkatan') }}">
                    <input type="text"
                           name="search"
                           id="searchInput"
                           class="form-control"
                           placeholder="Search..."
                           value="{{ request('search') }}">
                </form>
            </div>
        </div>

        {{-- BULK ACTION BAR --}}
     <div class="card p-3 shadow-sm mb-3" id="bulkActionBar" style="display: none;">
    <div class="row align-items-center g-2">

        {{-- Bagian Kiri --}}
        <div class="col-auto d-flex align-items-center gap-3">
            <span id="selectedCount" style="display:none;"></span>

            <button type="button" class="btn btn-outline-secondary btn-sm" id="selectAllBtn">
                Pilih Semua
            </button>
        </div>

        {{-- Bagian Kanan --}}
        <div class="col d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-outline-danger btn-sm" id="clearSelectionBtn">
                Batal Pilih
            </button>

            <button type="button" class="btn btn-primary btn-sm" id="bulkPrintBtn">
                <i class="bi bi-printer-fill me-2"></i>Cetak
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
                            <input type="checkbox" class="form-check-input" id="checkAll">
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
                                <input type="checkbox" 
                                       class="form-check-input santri-checkbox" 
                                       value="{{ $s->nis }}"
                                       data-nama="{{ $s->nama }}">
                            </td>
                            <td>{{ $santri->firstItem() + $index }}</td>
                            <td>{{ $s->nama }}</td>
                            <td>{{ $s->angkatan ?? '-' }}</td>


                            {{-- ICON CETAK --}}
                            <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    <a href="{{ route('rapor.cetak', $s->nis) }}"
                                       class="btn btn-primary d-flex justify-content-center align-items-center"
                                       style="width:36px; height:36px; border-radius:50%;"
                                       target="_blank">
                                        <i class="bi bi-printer-fill" style="font-size:16px;"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
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

    {{-- JAVASCRIPT --}}
    <script>
        // SEARCH DEBOUNCE
        let delayTimer;
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');

        searchInput.addEventListener('input', () => {
            clearTimeout(delayTimer);
            delayTimer = setTimeout(() => {
                searchForm.submit();
            }, 400);
        });

        // FILTER ANGKATAN AUTO SUBMIT
        const angkatanFilter = document.getElementById('angkatanFilter');
        const filterForm = document.getElementById('filterForm');

        angkatanFilter.addEventListener('change', () => {
            filterForm.submit();
        });

        // BULK SELECTION
        const checkAll = document.getElementById('checkAll');
        const santriCheckboxes = document.querySelectorAll('.santri-checkbox');
        const bulkActionBar = document.getElementById('bulkActionBar');
        const selectedCountSpan = document.getElementById('selectedCount');
        const selectAllBtn = document.getElementById('selectAllBtn');
        const clearSelectionBtn = document.getElementById('clearSelectionBtn');
        const bulkPrintBtn = document.getElementById('bulkPrintBtn');

        let selectedNis = new Set();

        // Function update UI
        function updateSelectionUI() {
            const count = selectedNis.size;
            selectedCountSpan.textContent = count;
            bulkActionBar.style.display = count > 0 ? 'block' : 'none';

            // Update checkAll state
            const allChecked = Array.from(santriCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(santriCheckboxes).some(cb => cb.checked);
            checkAll.checked = allChecked;
            checkAll.indeterminate = someChecked && !allChecked;
        }

        // Check All in page
        checkAll.addEventListener('change', (e) => {
            santriCheckboxes.forEach(cb => {
                cb.checked = e.target.checked;
                if (e.target.checked) {
                    selectedNis.add(cb.value);
                } else {
                    selectedNis.delete(cb.value);
                }
            });
            updateSelectionUI();
        });

        // Individual checkbox
        santriCheckboxes.forEach(cb => {
            cb.addEventListener('change', (e) => {
                if (e.target.checked) {
                    selectedNis.add(e.target.value);
                } else {
                    selectedNis.delete(e.target.value);
                }
                updateSelectionUI();
            });
        });

        // Select All Button
        selectAllBtn.addEventListener('click', () => {
            santriCheckboxes.forEach(cb => {
                cb.checked = true;
                selectedNis.add(cb.value);
            });
            updateSelectionUI();
        });

        // Clear Selection Button
        clearSelectionBtn.addEventListener('click', () => {
            santriCheckboxes.forEach(cb => {
                cb.checked = false;
            });
            selectedNis.clear();
            updateSelectionUI();
        });

        // Bulk Print Button
        bulkPrintBtn.addEventListener('click', () => {
            if (selectedNis.size === 0) {
                alert('Pilih minimal 1 santri untuk dicetak!');
                return;
            }

            if (selectedNis.size > 50) {
                if (!confirm(`Anda akan mencetak ${selectedNis.size} rapor. Ini mungkin memakan waktu lama. Lanjutkan?`)) {
                    return;
                }
            }

            // Kirim ke route bulk print
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("rapor.cetak.bulk") }}';
            form.target = '_blank';

            // CSRF Token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            // NIS Array
            selectedNis.forEach(nis => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'nis[]';
                input.value = nis;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        });

        // Maintain selection across page loads
        updateSelectionUI();
    </script>

@endsection