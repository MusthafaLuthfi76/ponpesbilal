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
        justify-content: space-between;
    }

    .page-header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .page-header h4 {
        margin: 0;
        color: var(--primary-color);
        font-weight: 600;
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
        background: white;
    }

    .back-btn:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .tahun-info-card {
        background: linear-gradient(135deg, var(--primary-color) 0%, #1e7e34 100%);
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 20px;
        color: white;
    }

    .tahun-info-header {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .tahun-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .tahun-details h5 {
        margin: 0 0 5px 0;
        font-weight: 600;
        font-size: 22px;
        line-height: 1.2;
    }

    .tahun-details p {
        margin: 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .santri-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .santri-header {
        padding: 20px 25px;
        background-color: var(--bg-light);
        border-bottom: 1px solid var(--border-color);
    }

    .santri-header h5 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .santri-list {
        padding: 15px 25px;
        max-height: 60vh;
        overflow-y: auto;
    }

    .santri-item {
        background: white;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .santri-item:hover {
        border-color: var(--primary-color);
        background-color: #f8fff9;
    }

    .santri-item input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: var(--primary-color);
    }

    .santri-info {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .santri-avatar {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, var(--primary-color) 0%, #1e7e34 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        flex-shrink: 0;
    }

    .santri-details {
        flex: 1;
    }

    .santri-name {
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 3px;
    }

    .santri-angkatan {
        font-size: 13px;
        color: #666;
    }

    .santri-item.selected {
        border-color: var(--primary-color);
        background-color: #e8f5e9;
    }

    .action-buttons {
        padding: 15px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid var(--border-color);
        background-color: var(--bg-light);
    }

    .select-all-btn {
        background-color: white;
        color: var(--primary-color);
        padding: 8px 16px;
        border: 1px solid var(--primary-color);
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .select-all-btn:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .submit-btn {
        background-color: var(--primary-color);
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .submit-btn:hover {
        background-color: #1e7e34;
        transform: translateY(-1px);
    }

    .submit-btn:disabled {
        background-color: #ccc;
        cursor: not-allowed;
        transform: none;
    }

    .selected-count {
        font-size: 14px;
        color: #666;
        font-weight: 500;
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
        margin-bottom: 10px;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        body {
            background-color: #f5f5f5;
        }

        .container-wrapper {
            padding: 0 0 20px 0;
        }

        .page-header {
            border-radius: 0;
            flex-direction: column;
            align-items: flex-start;
            padding: 15px;
            margin-bottom: 15px;
        }

        .page-header-left {
            margin-bottom: 10px;
            width: 100%;
        }

        .page-header h4 {
            font-size: 18px;
        }

        .back-btn {
            width: 100%;
            justify-content: center;
        }

        .tahun-info-card {
            border-radius: 0;
            padding: 20px 15px;
            margin-bottom: 15px;
        }

        .tahun-icon {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }

        .tahun-details h5 {
            font-size: 18px;
        }

        .santri-card {
            border-radius: 0;
        }

        .santri-header {
            padding: 15px;
        }

        .santri-header h5 {
            font-size: 16px;
        }

        .santri-list {
            padding: 15px;
        }

        .santri-item {
            padding: 12px;
        }

        .santri-avatar {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .action-buttons {
            flex-direction: column;
            gap: 10px;
            padding: 15px;
        }

        .select-all-btn,
        .submit-btn {
            width: 100%;
            justify-content: center;
        }

        .selected-count {
            width: 100%;
            text-align: center;
        }
    }
</style>

@section('content')

<div class="container-wrapper">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left">
            <h4>
                <i class="fas fa-user-plus"></i> Assign Santri
            </h4>
        </div>
        <a href="{{ route('nilaikesantrian.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Tahun Ajaran Info Card -->
    <div class="tahun-info-card">
        <div class="tahun-info-header">
            <div class="tahun-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="tahun-details">
                <h5>Tahun Ajaran {{ $tahunAjaran->tahun }}</h5>
                <p><i class="fas fa-book me-2"></i>Semester {{ strtoupper($tahunAjaran->semester) }}</p>
            </div>
        </div>
    </div>

    <!-- Santri Card -->
    <form action="{{ route('nilaikesantrian.assignStore', $tahunAjaran->id_tahunAjaran) }}" method="POST" id="assignForm">
        @csrf
        
        <div class="santri-card">
            <div class="santri-header">
                <h5><i class="fas fa-users"></i> Pilih Santri</h5>
            </div>

            <div class="santri-list">
                @forelse($santri as $s)
                    <label class="santri-item" onclick="toggleSelection(this)">
                        <input type="checkbox" name="nis[]" value="{{ $s->nis }}" onchange="updateCount()">
                        <div class="santri-info">
                            <div class="santri-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="santri-details">
                                <div class="santri-name">{{ $s->nama }}</div>
                                <div class="santri-angkatan">
                                    <i class="fas fa-graduation-cap me-1"></i>Angkatan {{ $s->angkatan }}
                                </div>
                            </div>
                        </div>
                    </label>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-users-slash"></i>
                        <p>Tidak ada santri tersedia</p>
                        <small>Semua santri sudah di-assign atau belum ada data santri</small>
                    </div>
                @endforelse
            </div>

            @if($santri->count() > 0)
            <div class="action-buttons">
                <button type="button" class="select-all-btn" onclick="selectAll()">
                    <i class="fas fa-check-double"></i> Pilih Semua
                </button>
                
                <span class="selected-count" id="selectedCount">0 santri dipilih</span>
                
                <button type="submit" class="submit-btn" id="submitBtn" disabled>
                    <i class="fas fa-save"></i> Assign Terpilih
                </button>
            </div>
            @endif
        </div>
    </form>
</div>

<script>
let selectAllState = false;

function toggleSelection(label) {
    const checkbox = label.querySelector('input[type="checkbox"]');
    
    // Toggle visual state
    if (checkbox.checked) {
        label.classList.add('selected');
    } else {
        label.classList.remove('selected');
    }
}

function selectAll() {
    const checkboxes = document.querySelectorAll('input[name="nis[]"]');
    const btn = document.querySelector('.select-all-btn');
    const icon = btn.querySelector('i');
    
    selectAllState = !selectAllState;
    
    checkboxes.forEach(cb => {
        cb.checked = selectAllState;
        const label = cb.closest('.santri-item');
        if (selectAllState) {
            label.classList.add('selected');
        } else {
            label.classList.remove('selected');
        }
    });
    
    if (selectAllState) {
        btn.innerHTML = '<i class="fas fa-times"></i> Batalkan Semua';
    } else {
        btn.innerHTML = '<i class="fas fa-check-double"></i> Pilih Semua';
    }
    
    updateCount();
}

function updateCount() {
    const checked = document.querySelectorAll('input[name="nis[]"]:checked').length;
    const countEl = document.getElementById('selectedCount');
    const submitBtn = document.getElementById('submitBtn');
    
    countEl.textContent = `${checked} santri dipilih`;
    
    if (checked > 0) {
        submitBtn.disabled = false;
    } else {
        submitBtn.disabled = true;
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[name="nis[]"]');
    checkboxes.forEach(cb => {
        if (cb.checked) {
            cb.closest('.santri-item').classList.add('selected');
        }
    });
    updateCount();
});
</script>

@endsection