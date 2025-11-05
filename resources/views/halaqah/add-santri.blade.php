@extends('layouts.app')

@section('page_title', 'Tambah Santri Baru')

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

    .info-text {
        color: #666;
        margin-bottom: 0;
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

    .selected-count {
        color: var(--primary-color);
        font-size: 14px;
    }

    .santri-list-body {
        max-height: 500px;
        overflow-y: auto;
    }

    .santri-item {
        display: flex;
        align-items: center;
        padding: 15px 25px;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.2s;
        cursor: pointer;
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
        margin-right: 15px;
        cursor: pointer;
        accent-color: var(--primary-color);
    }

    .santri-id {
        font-weight: 600;
        color: var(--primary-color);
        min-width: 100px;
        font-size: 14px;
    }

    .santri-name {
        flex: 1;
        color: var(--text-color);
        font-size: 15px;
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
</style>

@section('content')

<form method="POST" action="{{ route('halaqah.addSantri', $kelompok->id_halaqah) }}" id="addSantriForm">
    @csrf
    
    <div class="container-wrapper">
        {{-- Page Header --}}
        <div class="page-header">
            <h4><i class="fas fa-user-plus"></i> Tambah Santri Baru</h4>
            <a href="{{ route('halaqah.show', $kelompok->id_halaqah) }}" class="back-btn">
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

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Info Kelompok --}}
        <div class="info-card">
            <h5><i class="fas fa-info-circle"></i> Informasi Kelompok</h5>
            <p class="info-text">
                Menambahkan santri ke kelompok <strong>{{ $kelompok->nama_kelompok }}</strong> 
                dengan Ustadz <strong>{{ $kelompok->pendidik->nama ?? '-' }}</strong>
            </p>
        </div>

        {{-- Search Box --}}
        <div class="search-card">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari santri berdasarkan ID atau Nama..." autocomplete="off">
                <i class="fas fa-search"></i>
            </div>
            <button type="button" class="select-all-btn" id="selectAllBtn">
                <i class="fas fa-check-double"></i> Pilih Semua
            </button>
        </div>

        {{-- Santri List --}}
        <div class="santri-list-card">
            <div class="santri-list-header">
                <span><i class="fas fa-users me-2"></i>Daftar Santri Tersedia</span>
                <span class="selected-count" id="selectedCount">0 dipilih</span>
            </div>
            <div class="santri-list-body" id="santriList">
                @forelse($santri as $s)
                    <div class="santri-item" data-nis="{{ $s->nis }}" data-nama="{{ $s->nama }}">
                        <input type="checkbox" 
                               class="santri-checkbox" 
                               name="santri[]" 
                               value="{{ $s->nis }}" 
                               id="santri_{{ $s->nis }}">
                        <label for="santri_{{ $s->nis }}" style="display: flex; flex: 1; cursor: pointer; margin: 0;">
                            <div class="santri-id">{{ $s->nis }}</div>
                            <div class="santri-name">{{ $s->nama }}</div>
                        </label>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-users"></i>
                        <p>Tidak ada santri tersedia</p>
                        <small>Semua santri sudah memiliki kelompok halaqah</small>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Action Footer --}}
        <div class="action-footer">
            <div class="selected-info">
                <i class="fas fa-check-circle me-2"></i>
                <strong id="selectedTotal">0</strong> santri dipilih
            </div>
            <div class="action-buttons">
                <a href="{{ route('halaqah.show', $kelompok->id_halaqah) }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn-submit" id="submitBtn" disabled>
                    <i class="fas fa-save"></i> Simpan
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
        const selectAllBtn = document.getElementById('selectAllBtn');
        const submitBtn = document.getElementById('submitBtn');
        const selectedCount = document.getElementById('selectedCount');
        const selectedTotal = document.getElementById('selectedTotal');
        const form = document.getElementById('addSantriForm');

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
            const total = checkboxes.length;
            if (checked === total && total > 0) {
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
            item.addEventListener('click', function(e) {
                if (e.target !== checkbox && e.target.tagName !== 'LABEL') {
                    checkbox.checked = !checkbox.checked;
                    updateSelectedCount();
                }
            });
        });

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
            });

            console.log('✅ Search initialized');
        }

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