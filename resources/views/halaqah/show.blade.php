@extends('layouts.app')

@section('page_title', 'Detail Kelompok Halaqoh')

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
        max-width: full;
        padding: 0 15px;
    }

    .info-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 20px;
    }

    .info-card h4 {
        color: var(--primary-color);
        margin-bottom: 20px;
        font-weight: 600;
        text-align: center;
    }

    .info-row {
        display: flex;
        padding: 12px 0;
        border-bottom: 1px solid var(--border-color);
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #555;
        width: 140px;
        flex-shrink: 0;
    }

    .info-value {
        color: var(--text-color);
    }

    .santri-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .santri-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        background-color: var(--bg-light);
        border-bottom: 1px solid var(--border-color);
    }

    .santri-header h5 {
        margin: 0;
        font-weight: 600;
    }

    .search-box {
        display: flex;
        align-items: center;
        border: 1px solid var(--border-color);
        border-radius: 5px;
        padding: 6px 12px;
        background: white;
    }

    .search-box input {
        border: none;
        outline: none;
        margin-left: 8px;
        width: 200px;
    }

    .add-santri-btn {
        background-color: #1f4b2c;
        color: white;
        padding: 8px 16px;
        border-radius: 5px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        border: none;
        cursor: pointer;
    }

    .add-santri-btn:hover {
        background-color: #1e7e34;
        color: white;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead th {
        background-color: var(--bg-light);
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 12px 15px;
        border-bottom: 2px solid var(--border-color);
        font-weight: 600;
    }

    tbody td {
        padding: 12px 15px;
        border-bottom: 1px solid var(--border-color);
    }

    .action-btn {
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        color: #fff;
        margin: 0 3px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .edit {
        background: var(--secondary-color);
        color: #212529;
    }

    .delete {
        background: var(--delete-color);
    }

    .action-btn:hover {
        opacity: 0.85;
        transform: scale(1.05);
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        margin-bottom: 15px;
        transition: all 0.2s;
    }

    .back-btn:hover {
        color: #1e7e34;
        gap: 12px;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
        opacity: 0.3;
    }
</style>

@section('content')

    <div class="container-wrapper">


        {{-- Tombol Kembali --}}
        <a href="{{ route('halaqah.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        {{-- Card Info Halaqoh --}}
<div class="card shadow-sm border-0 p-3 mb-3">
    <h5 class="fw-bold text-success mb-3 text-center">
        {{ $kelompok->nama_kelompok }}
    </h5>

    <div class="d-flex flex-wrap justify-content-between text-start">
        <div class="me-4 mb-2">
            <div class="fw-semibold text-secondary">No</div>
            <div class="text-dark">{{ $kelompok->id_halaqah }}</div>
        </div>

        <div class="me-4 mb-2">
            <div class="fw-semibold text-secondary">Nama Kelompok</div>
            <div class="text-dark">{{ $kelompok->nama_kelompok }}</div>
        </div>

                <div class="mb-2">
            <div class="fw-semibold text-secondary">Nama Ustadz</div>
            <div class="text-dark">{{ $kelompok->pendidik->nama ?? '-' }}</div>
        </div>

        <div class="me-4 mb-2">
            <div class="fw-semibold text-secondary">ID Ustadz</div>
            <div class="text-dark">{{ $kelompok->id_pendidik }}</div>
        </div>


    </div>
</div>


        {{-- Card Daftar Santri --}}
        <div class="santri-card">
            <div class="santri-header">
                <h5>Daftar Santri</h5>
                <div class="d-flex align-items-center gap-3">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search..." id="searchInput">
                    </div>
                    <a href="{{ route('halaqah.showAddSantri', $kelompok->id_halaqah) }}" class="add-santri-btn">
                        <i class="fas fa-plus"></i> Tambah Santri
                    </a>
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>ID SANTRI</th>
                            <th>NAMA SANTRI</th>
                            <th class="text-center">ACTION</th>
                        </tr>
                    </thead>
                    <tbody id="santriTable">
                        @forelse ($santri as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->nis }}</td>
                                <td>{{ $s->nama }}</td>
                                <td class="text-center">
                                    {{-- SETORAN (EDIT) --}}
                                    <a href="{{ route('setoran.index', $s->nis) }}" title="Setoran"
                                        class="d-inline-flex align-items-center justify-content-center bg-warning text-warning rounded p-2 me-1 shadow-sm"
                                        style="width: 38px; height: 38px; transition: all 0.2s ease;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            viewBox="0 0 25 24" fill="none" stroke="white" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.5">
                                            <path
                                                d="m20.148 5.437l-.659-1.043c-.364-.577-.546-.866-.785-.892c-.238-.027-.505.247-1.038.795c-1.722 1.77-3.444 1.508-5.166 4.691c-1.722-3.183-3.444-2.921-5.166-4.691c-.533-.548-.8-.822-1.038-.795c-.239.026-.421.315-.785.892l-.658 1.043c-.255.402-.382.604-.347.816c.034.212.217.357.584.647l6.182 4.898c.591.468.887.702 1.228.702s.637-.234 1.228-.702L19.91 6.9c.367-.29.55-.435.584-.647c.035-.212-.092-.414-.346-.816M22.5 8.5l-16 12v-4.696M2.5 8.5l16 12v-4.696" />
                                        </svg>
                                    </a>

                                    {{-- DELETE --}}
                                    <button
                                        class="d-inline-flex align-items-center justify-content-center bg-danger text-danger rounded p-2 shadow-sm border-0"
                                        style="width: 38px; height: 38px; transition: all 0.2s ease;" data-bs-toggle="modal"
                                        data-bs-target="#deleteSantriModal" data-id="{{ $s->nis }}"
                                        data-nama="{{ $s->nama }}" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="white" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2">
                                            <path
                                                d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                    </button>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <i class="fas fa-users"></i>
                                        <p>Belum ada santri dalam kelompok ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                            <div class="d-flex justify-content-end mt-3">
                {{ $santri->links('pagination::bootstrap-5') }}
            </div>
            </div>
        </div>
    </div>

    {{-- Modal Delete Santri --}}
    <div class="modal fade" id="deleteSantriModal" tabindex="-1" aria-labelledby="deleteSantriModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="deleteSantriForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header justify-content-center border-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                            fill="#28a745">
                            <path
                                d="M13.435 2.075a3.33 3.33 0 0 0-2.87 0c-.394.189-.755.497-1.26.928l-.079.066a2.56 2.56 0 0 1-1.58.655l-.102.008c-.662.053-1.135.09-1.547.236a3.33 3.33 0 0 0-2.03 2.029c-.145.412-.182.885-.235 1.547l-.008.102a2.56 2.56 0 0 1-.655 1.58l-.066.078c-.431.506-.74.867-.928 1.261a3.33 3.33 0 0 0 0 2.87c.189.394.497.755.928 1.26l.066.079c.41.48.604.939.655 1.58l.008.102c.053.662.09 1.135.236 1.547a3.33 3.33 0 0 0 2.029 2.03c.412.145.885.182 1.547.235l.102.008c.629.05 1.09.238 1.58.655l.078.066c.506.431.867.74 1.261.928a3.33 3.33 0 0 0 2.87 0c.394-.189.755-.497 1.26-.928l.079-.066c.48-.41.939-.604 1.58-.655l.102-.008c.662-.053 1.135-.09 1.547-.236a3.33 3.33 0 0 0 2.03-2.029c.145-.412.182-.885.235-1.547l.008-.102c.05-.629.238-1.09.655-1.58l.066-.079c.431-.505.74-.866.928-1.26a3.33 3.33 0 0 0 0-2.87c-.189-.394-.497-.755-.928-1.26l-.066-.079a2.56 2.56 0 0 1-.655-1.58l-.008-.102c-.053-.662-.09-1.135-.236-1.547a3.33 3.33 0 0 0-2.029-2.03c-.412-.145-.885-.182-1.547-.235l-.102-.008a2.56 2.56 0 0 1-1.58-.655l-.079-.066c-.505-.431-.866-.74-1.26-.928M12 6.877a.75.75 0 0 1 .75.75v5.5a.75.75 0 0 1-1.5 0v-5.5a.75.75 0 0 1 .75-.75m.75 8.996v.5a.75.75 0 0 1-1.5 0v-.5a.75.75 0 0 1 1.5 0" />
                        </svg>
                    </div>
                    <div class="modal-body text-center">
                        <h5 class="mb-3">Konfirmasi Penghapusan</h5>
                        <p>Apakah Anda yakin ingin mengeluarkan santri <strong id="deleteSantriNama"></strong> dari kelompok
                            ini?</p>
                    </div>
                    <div class="modal-footer justify-content-center border-0">
                        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-1"></i> Ya, Keluarkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ DOM Loaded');

            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('santriTable');

            if (searchInput && tableBody) {
                searchInput.addEventListener('keyup', function() {
                    const filter = this.value.toLowerCase();
                    const rows = tableBody.getElementsByTagName('tr');

                    for (let row of rows) {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(filter) ? '' : 'none';
                    }
                });
                console.log('✅ Search functionality initialized');
            }





            // Delete Santri Modal
            const deleteModal = document.getElementById('deleteSantriModal');
            console.log('Delete Modal Element:', deleteModal);

            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', event => {
                    console.log('🔴 === DELETE MODAL OPENED ===');

                    const button = event.relatedTarget;
                    const nis = button.getAttribute('data-id');
                    const nama = button.getAttribute('data-nama');
                    const halaqahId = '{{ $kelompok->id_halaqah }}';

                    console.log('📌 NIS:', nis);
                    console.log('📌 Nama:', nama);
                    console.log('📌 Halaqah ID:', halaqahId);

                    // Set nama di modal
                    const namaElement = deleteModal.querySelector('#deleteSantriNama');
                    if (namaElement) {
                        namaElement.textContent = nama;
                        console.log('✅ Nama set di modal');
                    } else {
                        console.error('❌ Element #deleteSantriNama tidak ditemukan');
                    }

                    // Set action form
                    const form = deleteModal.querySelector('#deleteSantriForm');
                    if (form) {
                        const newAction = `/halaqah/${halaqahId}/remove-santri/${nis}`;

                        console.log('📝 Old Action:', form.getAttribute('action'));
                        console.log('📝 New Action:', newAction);

                        form.setAttribute('action', newAction);

                        console.log('📝 Action After Set:', form.getAttribute('action'));
                        console.log('📝 Full Action URL:', form.action);
                        console.log('✅ Form action updated');
                    } else {
                        console.error('❌ Form #deleteSantriForm tidak ditemukan');
                    }

                    console.log('🔴 ===========================');
                });
                console.log('✅ Delete modal initialized');
            } else {
                console.error('❌ Delete modal tidak ditemukan!');
            }
        });
    </script>

@endsection
