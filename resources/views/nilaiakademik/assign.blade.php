@extends('layouts.app')

@section('page_title', 'Assign Santri')

{{-- Bootstrap & Font Awesome --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    :root {
        --primary-color: #28a745;
        --secondary-color: #ffc107;
        --delete-color: #dc3545;
        --border-color: #dee2e6;
        --text-color: #212529;
        --bg-light: #f8f9fa;
    }

    body {
        background-color: #e8f5e9;
    }

    .container-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px 15px;
    }

    .page-header {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px 25px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .page-header h4 {
        margin: 0;
        color: var(--primary-color);
        font-weight: 600;
        flex: 1;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
        padding: 8px 16px;
        border: 1px solid var(--primary-color);
        border-radius: 5px;
    }

    .back-btn:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .info-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px 25px;
        margin-bottom: 20px;
    }

    .info-card h5 {
        color: var(--primary-color);
        margin-bottom: 15px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-detail {
        display: flex;
        gap: 10px;
        margin-bottom: 8px;
        color: #666;
    }

    .info-label {
        font-weight: 500;
        min-width: 120px;
    }

    .filter-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px 25px;
        margin-bottom: 20px;
    }

    .filter-card h6 {
        color: var(--text-color);
        margin-bottom: 15px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .filter-group label {
        font-weight: 500;
        font-size: 14px;
        color: #555;
    }

    .filter-group select,
    .filter-group input {
        padding: 8px 12px;
        border: 2px solid var(--border-color);
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s;
    }

    .filter-group select:focus,
    .filter-group input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
    }

    .filter-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .btn-filter {
        padding: 8px 20px;
        border-radius: 6px;
        border: none;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-reset {
        background-color: #6c757d;
        color: white;
    }

    .btn-reset:hover {
        background-color: #5a6268;
    }

    .search-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px 25px;
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .search-box {
        position: relative;
        flex: 1;
    }

    .search-box input {
        width: 100%;
        padding: 12px 45px 12px 15px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s;
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
    }

    .search-box i {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }

    .select-all-btn {
        background-color: var(--secondary-color);
        color: #212529;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 500;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .select-all-btn:hover {
        background-color: #e0a800;
        transform: translateY(-1px);
    }

    .santri-list-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .santri-list-header {
        background-color: var(--bg-light);
        padding: 15px 25px;
        border-bottom: 2px solid var(--border-color);
        font-weight: 600;
        color: var(--text-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .pagination-info {
        font-size: 14px;
        color: #666;
    }

    .selected-count {
        color: var(--primary-color);
        font-size: 14px;
    }

    .santri-list-body {
        max-height: 500px;
        overflow-y: auto;
    }

    .santri-table-header {
        display: grid;
        grid-template-columns: 40px 60px 80px 1fr 100px 100px;
        align-items: center;
        padding: 12px 25px;
        background-color: #2c3e50;
        color: white;
        font-weight: 600;
        font-size: 14px;
        gap: 15px;
        position: sticky;
        top: 0;
        z-index: 5;
    }

    .santri-table-header div {
        text-align: left;
    }

    .santri-table-header .text-center {
        text-align: center;
    }

    .santri-item {
        display: grid;
        grid-template-columns: 40px 60px 80px 1fr 100px 100px;
        align-items: center;
        padding: 15px 25px;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.2s;
        cursor: pointer;
        gap: 15px;
    }

    .santri-item:hover {
        background-color: #f8f9fa;
    }

    .santri-item:last-child {
        border-bottom: none;
    }

    .santri-item.selected {
        background-color: #d4edda;
    }

    .santri-checkbox {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: var(--primary-color);
    }

    .santri-no {
        font-weight: 500;
        color: #666;
        font-size: 14px;
    }

    .santri-nis {
        font-weight: 600;
        color: var(--primary-color);
        font-size: 14px;
    }

    .santri-name {
        color: var(--text-color);
        font-size: 15px;
        font-weight: 500;
    }

    .santri-angkatan {
        color: #666;
        font-size: 14px;
        text-align: center;
    }

    .santri-status {
        text-align: center;
    }

    .badge-status {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-aktif {
        background-color: #d4edda;
        color: #155724;
    }

    .badge-lulus {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .badge-keluar {
        background-color: #f8d7da;
        color: #721c24;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    .empty-state p {
        font-size: 18px;
        margin-bottom: 5px;
    }

    .empty-state small {
        font-size: 14px;
        color: #bbb;
    }

    .pagination-wrapper {
        padding: 15px 25px;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: center;
    }

    .action-footer {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        bottom: 20px;
    }

    .selected-info {
        color: #666;
        font-size: 15px;
    }

    .selected-info strong {
        color: var(--primary-color);
        font-size: 18px;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
    }

    .btn-cancel {
        background-color: white;
        color: #666;
        border: 2px solid var(--border-color);
        padding: 10px 24px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-cancel:hover {
        border-color: #999;
        color: #333;
    }

    .btn-submit {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-submit:hover:not(:disabled) {
        background-color: #1e7e34;
        transform: translateY(-1px);
    }

    .btn-submit:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }

    /* Custom Scrollbar */
    .santri-list-body::-webkit-scrollbar {
        width: 8px;
    }

    .santri-list-body::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .santri-list-body::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .santri-list-body::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .santri-table-header {
            grid-template-columns: 35px 50px 70px 1fr 80px;
            gap: 10px;
            padding: 10px 15px;
            font-size: 12px;
        }

        .santri-table-header .header-angkatan {
            display: none;
        }

        .santri-item {
            grid-template-columns: 35px 50px 70px 1fr 80px;
            gap: 10px;
            padding: 12px 15px;
            font-size: 13px;
        }

        .santri-angkatan {
            display: none;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .page-header h4 {
            font-size: 18px;
        }

        .filter-row {
            grid-template-columns: 1fr;
        }

        .search-card {
            flex-direction: column;
        }

        .action-footer {
            flex-direction: column;
            gap: 15px;
        }

        .action-buttons {
            width: 100%;
        }

        .btn-cancel, .btn-submit {
            flex: 1;
            justify-content: center;
        }
    }
</style>

@section('content')

<form method="POST" action="{{ route('nilaiakademik.mapel.assign.store', $mapel->id_matapelajaran) }}" id="assignForm">
    @csrf
    
    <div class="container-wrapper">
        {{-- Page Header --}}
        <div class="page-header">
            <h4><i class="fas fa-user-plus"></i> Assign Santri ke Mata Pelajaran</h4>
            <a href="{{ route('nilaiakademik.mapel.show', $mapel->id_matapelajaran) }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Info Mata Pelajaran --}}
        <div class="info-card">
            <h5><i class="fas fa-info-circle"></i> Informasi Mata Pelajaran</h5>
            <div class="info-detail">
                <span class="info-label">Mata Pelajaran:</span>
                <strong>{{ $mapel->nama_matapelajaran }}</strong>
            </div>
            <div class="info-detail">
                <span class="info-label">Tahun Ajaran:</span>
                <strong>{{ $mapel->tahunAjaran->tahun ?? '-' }}</strong>
            </div>
        </div>

        {{-- Filter Card --}}
        <div class="filter-card">
            <h6><i class="fas fa-filter"></i> Filter Santri</h6>
            <div class="filter-row">
                <div class="filter-group">
                    <label>Angkatan</label>
                    <select name="angkatan" id="filterAngkatan" class="form-select">
                        <option value="">Semua Angkatan</option>
                        @foreach($angkatanOptions as $opt)
                            <option value="{{ $opt->angkatan }}" {{ request('angkatan') == $opt->angkatan ? 'selected' : '' }}>
                                {{ $opt->angkatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label>Status</label>
                    <select name="status" id="filterStatus" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach($statusOptions as $opt)
                            <option value="{{ $opt->status }}" {{ request('status') == $opt->status ? 'selected' : '' }}>
                                {{ ucfirst($opt->status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label>Tampilkan</label>
                    <select name="per_page" id="filterPerPage" class="form-select">
                        @foreach([20, 50, 100] as $num)
                            <option value="{{ $num }}" {{ request('per_page', 20) == $num ? 'selected' : '' }}>
                                {{ $num }} data
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="filter-actions">
                <a href="{{ route('nilaiakademik.mapel.assign.form', $mapel->id_matapelajaran) }}" class="btn-filter btn-reset">
                    <i class="fas fa-redo"></i> Reset Filter
                </a>
            </div>
        </div>

        {{-- Search Box --}}
        <div class="search-card">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari santri berdasarkan NIS atau Nama..." autocomplete="off">
                <i class="fas fa-search"></i>
            </div>
            <button type="button" class="select-all-btn" id="selectAllBtn">
                <i class="fas fa-check-double"></i> Pilih Semua
            </button>
        </div>

        {{-- Santri List --}}
        <div class="santri-list-card">
            <div class="santri-list-header">
                <span><i class="fas fa-users me-2"></i>Daftar Santri</span>
                <div style="display: flex; gap: 20px; align-items: center;">
                    <span class="pagination-info">
                        {{ $santri->firstItem() ?? 0 }} - {{ $santri->lastItem() ?? 0 }} dari {{ $santri->total() }}
                    </span>
                    <span class="selected-count" id="selectedCount">0 dipilih</span>
                </div>
            </div>
            
            <div class="santri-list-body" id="santriList">
                {{-- Table Header --}}
                <div class="santri-table-header">
                    <div><input type="checkbox" id="checkAllHeader" class="santri-checkbox"></div>
                    <div>#</div>
                    <div>NIS</div>
                    <div>Nama</div>
                    <div class="text-center header-angkatan">Angkatan</div>
                    <div class="text-center">Status</div>
                </div>

                @forelse($santri as $s)
                    <div class="santri-item" 
                         data-nis="{{ $s->nis }}" 
                         data-nama="{{ strtolower($s->nama) }}"
                         data-angkatan="{{ $s->angkatan }}"
                         data-status="{{ $s->status }}">
                        <input type="checkbox" 
                               class="santri-checkbox" 
                               name="nis[]" 
                               value="{{ $s->nis }}" 
                               id="santri_{{ $s->nis }}">
                        <div class="santri-no">{{ $loop->iteration + $santri->firstItem() - 1 }}</div>
                        <div class="santri-nis">{{ $s->nis }}</div>
                        <div class="santri-name">{{ $s->nama }}</div>
                        <div class="santri-angkatan">{{ $s->angkatan }}</div>
                        <div class="santri-status">
                            <span class="badge-status badge-{{ strtolower($s->status) }}">
                                {{ ucfirst($s->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-users"></i>
                        <p>Tidak ada santri tersedia</p>
                        <small>Gunakan filter untuk mencari santri lain</small>
                    </div>
                @endforelse
            </div>

            @if($santri->count() > 0)
                <div class="pagination-wrapper">
                    {{ $santri->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>

        {{-- Action Footer --}}
        <div class="action-footer">
            <div class="selected-info">
                <i class="fas fa-check-circle me-2"></i>
                <strong id="selectedTotal">0</strong> santri dipilih
            </div>
            <div class="action-buttons">
                <a href="{{ route('nilaiakademik.mapel.show', $mapel->id_matapelajaran) }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn-submit" id="submitBtn" disabled>
                    <i class="fas fa-save"></i> Assign Santri
                </button>
            </div>
        </div>
    </div>
</form>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const santriList = document.getElementById('santriList');
        const checkboxes = document.querySelectorAll('.santri-checkbox');
        const checkAllHeader = document.getElementById('checkAllHeader');
        const selectAllBtn = document.getElementById('selectAllBtn');
        const submitBtn = document.getElementById('submitBtn');
        const selectedCount = document.getElementById('selectedCount');
        const selectedTotal = document.getElementById('selectedTotal');
        const form = document.getElementById('assignForm');

        // Filter elements
        const filterAngkatan = document.getElementById('filterAngkatan');
        const filterStatus = document.getElementById('filterStatus');
        const filterPerPage = document.getElementById('filterPerPage');

        // Update selected count
        function updateSelectedCount() {
            const checked = document.querySelectorAll('.santri-checkbox:checked').length;
            selectedCount.textContent = `${checked} dipilih`;
            selectedTotal.textContent = checked;
            
            // Enable/disable submit button
            submitBtn.disabled = checked === 0;
            
            // Update parent item styling
            checkboxes.forEach(checkbox => {
                const item = checkbox.closest('.santri-item');
                if (checkbox.checked) {
                    item.classList.add('selected');
                } else {
                    item.classList.remove('selected');
                }
            });

            // Update select all button text
            const visibleCheckboxes = Array.from(checkboxes).filter(cb => {
                const item = cb.closest('.santri-item');
                return item && item.offsetParent !== null;
            });
            const visibleChecked = visibleCheckboxes.filter(cb => cb.checked).length;
            
            if (visibleChecked === visibleCheckboxes.length && visibleCheckboxes.length > 0) {
                selectAllBtn.innerHTML = '<i class="fas fa-times"></i> Batal Pilih Semua';
            } else {
                selectAllBtn.innerHTML = '<i class="fas fa-check-double"></i> Pilih Semua';
            }
        }

        // Checkbox change event
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
            
            // Click on item to toggle checkbox
            const item = checkbox.closest('.santri-item');
            if (item) {
                item.addEventListener('click', function(e) {
                    if (e.target !== checkbox && !e.target.closest('.badge-status')) {
                        checkbox.checked = !checkbox.checked;
                        updateSelectedCount();
                    }
                });
            }
        });

        // Check all header checkbox
        if (checkAllHeader) {
            checkAllHeader.addEventListener('change', function() {
                const visibleCheckboxes = Array.from(checkboxes).filter(cb => {
                    const item = cb.closest('.santri-item');
                    return item && item.offsetParent !== null;
                });
                
                visibleCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                
                updateSelectedCount();
            });
        }

        // Select all button
        selectAllBtn.addEventListener('click', function() {
            const visibleCheckboxes = Array.from(checkboxes).filter(cb => {
                const item = cb.closest('.santri-item');
                return item && item.offsetParent !== null;
            });
            
            const allChecked = visibleCheckboxes.every(cb => cb.checked);
            
            visibleCheckboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });
            
            updateSelectedCount();
        });

        // Search functionality
        if (searchInput && santriList) {
            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                const items = santriList.querySelectorAll('.santri-item');
                let visibleCount = 0;

                items.forEach(item => {
                    const nis = item.dataset.nis.toLowerCase();
                    const nama = item.dataset.nama.toLowerCase();
                    
                    if (nis.includes(filter) || nama.includes(filter)) {
                        item.style.display = '';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Show empty state if no results
                const emptyState = santriList.querySelector('.empty-state');
                const hasEmptyState = !!emptyState;
                
                if (visibleCount === 0 && filter !== '' && !hasEmptyState) {
                    const tempEmpty = document.createElement('div');
                    tempEmpty.className = 'empty-state temp-empty';
                    tempEmpty.innerHTML = `
                        <i class="fas fa-search"></i>
                        <p>Tidak ada hasil</p>
                        <small>Coba kata kunci lain</small>
                    `;
                    santriList.appendChild(tempEmpty);
                } else if (visibleCount > 0) {
                    const tempEmpty = santriList.querySelector('.temp-empty');
                    if (tempEmpty) {
                        tempEmpty.remove();
                    }
                }

                updateSelectedCount();
            });
        }

        // Filter change events - submit form
        filterAngkatan?.addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('angkatan', this.value);
            if (filterStatus) url.searchParams.set('status', filterStatus.value);
            if (filterPerPage) url.searchParams.set('per_page', filterPerPage.value);
            window.location.href = url.toString();
        });

        filterStatus?.addEventListener('change', function() {
            const url = new URL(window.location.href);
            if (filterAngkatan) url.searchParams.set('angkatan', filterAngkatan.value);
            url.searchParams.set('status', this.value);
            if (filterPerPage) url.searchParams.set('per_page', filterPerPage.value);
            window.location.href = url.toString();
        });

        filterPerPage?.addEventListener('change', function() {
            const url = new URL(window.location.href);
            if (filterAngkatan) url.searchParams.set('angkatan', filterAngkatan.value);
            if (filterStatus) url.searchParams.set('status', filterStatus.value);
            url.searchParams.set('per_page', this.value);
            window.location.href = url.toString();
        });

        // Form submit with loading
        form.addEventListener('submit', function() {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
            submitBtn.disabled = true;
        });

        // Initialize count
        updateSelectedCount();
    });
</script>

@endsection