@extends('layouts.app')

@section('page_title', 'Kelompok Halaqoh')

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
    }

    .container {
        max-width: 1200px;
        margin: 30px auto;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        border-bottom: 1px solid var(--border-color);
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .search-box {
        display: flex;
        align-items: center;
        border: 1px solid var(--border-color);
        border-radius: 5px;
        padding: 8px 12px;
    }

    .search-box input {
        border: none;
        outline: none;
        margin-left: 8px;
    }

    .add-button {
        background-color: #1f4b2c;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .add-button:hover {
        background-color: #1e7e34;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 12px;
        border-bottom: 2px solid var(--border-color);
    }

    tbody td {
        padding: 12px;
        border-bottom: 1px solid var(--border-color);
    }

    .action-btn {
        border: none;
        border-radius: 50%;
        width: 34px;
        height: 34px;
        color: #fff;
        margin: 0 2px;
    }

    .view {
        background: red;
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
    .pagination .pagination-summary {
    display: none;
}

</style>

@section('content')

    <div class="container">
        <div class="header">
            <h3>Kelompok Halaqoh</h3>
            <div class="header-right">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search..." id="searchInput">
                </div>
                <button class="add-button" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="fas fa-plus"></i> Tambah
                </button>
            </div>
        </div>

        <div class="table-container p-3">
            <table class="text-center">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>ID HALAQOH</th>
                        <th>NAMA KELOMPOK</th>
                        <th>ID PENDIDIK</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody id="halaqahTable">
                    @forelse ($kelompok as $group)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $group->id_halaqah }}</td>
                            <td>{{ $group->nama_kelompok }}</td>
                            <td>{{ $group->id_pendidik }}</td>
                            <td class="text-center">
                                {{-- DETAIL --}}
                                <a href="{{ route('halaqah.show', $group->id_halaqah) }}" title="Lihat"
                                    class="d-inline-flex align-items-center justify-content-center bg-danger text-primary rounded p-2 me-1 shadow-sm"
                                    style="width: 38px; height: 38px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="white">
                                        <path
                                            d="M11.5 18c4 0 7.46-2.22 9.24-5.5C18.96 9.22 15.5 7 11.5 7S4.04 9.22 2.26 12.5C4.04 15.78 7.5 18 11.5 18m0-12c4.56 0 8.5 2.65 10.36 6.5C20 16.35 16.06 19 11.5 19S3 16.35 1.14 12.5C3 8.65 6.94 6 11.5 6m0 2C14 8 16 10 16 12.5S14 17 11.5 17 7 15 7 12.5 9 8 11.5 8m0 1A3.5 3.5 0 0 0 8 12.5a3.5 3.5 0 0 0 3.5 3.5a3.5 3.5 0 0 0 3.5-3.5A3.5 3.5 0 0 0 11.5 9" />
                                    </svg>
                                </a>

                                {{-- EDIT --}}
                                <button title="Edit" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-id="{{ $group->id_halaqah }}" data-nama="{{ $group->nama_kelompok }}"
                                    data-pendidik="{{ $group->id_pendidik }}"
                                    class="d-inline-flex align-items-center justify-content-center bg-warning text-warning rounded p-2 me-1 shadow-sm border-0"
                                    style="width: 38px; height: 38px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="white">
                                        <path
                                            d="M21 12a1 1 0 0 0-1 1v6a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h6a1 1 0 0 0 0-2H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-6a1 1 0 0 0-1-1m-15 .76V17a1 1 0 0 0 1 1h4.24a1 1 0 0 0 .71-.29l6.92-6.93L21.71 8a1 1 0 0 0 0-1.42l-4.24-4.29a1 1 0 0 0-1.42 0l-2.82 2.83l-6.94 6.93a1 1 0 0 0-.29.71m10.76-8.35l2.83 2.83l-1.42 1.42l-2.83-2.83ZM8 13.17l5.93-5.93l2.83 2.83L10.83 16H8Z" />
                                    </svg>
                                </button>

                                {{-- DELETE --}}
                                <button title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-id="{{ $group->id_halaqah }}"
                                    class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded p-2 shadow-sm border-0"
                                    style="width: 38px; height: 38px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="white">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data kelompok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-end mt-3">
                {{ $kelompok->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('halaqah.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Tambah Kelompok Halaqoh</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Nama ustad</label>
                            <select name="id_pendidik" class="form-control" required>
                                <option value="">Ust. </option>
                                @foreach ($pendidik as $p)
                                    <option value="{{ $p->id_pendidik }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Nama Kelompok</label>
                            <input type="text" name="nama_kelompok" class="form-control" required>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="modal-title">Edit Kelompok Halaqoh</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Nama Ust</label>
                            <select name="id_pendidik" id="editPendidik" class="form-control" required>
                                <option value="">Ust. </option>
                                @foreach ($pendidik as $p)
                                    <option value="{{ $p->id_pendidik }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Nama Kelompok</label>
                            <input type="text" name="nama_kelompok" id="editNama" class="form-control" required>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn border-success" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Hapus --}}
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header text-white d-flex align-items-center justify-content-between">
                        <!-- Modal Header -->
                        <div class="modal-header  text-white justify-content-center position-relative m-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                fill="#1f4b2c" class="ml-auto">
                                <path
                                    d="M13.435 2.075a3.33 3.33 0 0 0-2.87 0c-.394.189-.755.497-1.26.928l-.079.066a2.56 2.56 0 0 1-1.58.655l-.102.008c-.662.053-1.135.09-1.547.236a3.33 3.33 0 0 0-2.03 2.029c-.145.412-.182.885-.235 1.547l-.008.102a2.56 2.56 0 0 1-.655 1.58l-.066.078c-.431.506-.74.867-.928 1.261a3.33 3.33 0 0 0 0 2.87c.189.394.497.755.928 1.26l.066.079c.41.48.604.939.655 1.58l.008.102c.053.662.09 1.135.236 1.547a3.33 3.33 0 0 0 2.029 2.03c.412.145.885.182 1.547.235l.102.008c.629.05 1.09.238 1.58.655l.078.066c.506.431.867.74 1.261.928a3.33 3.33 0 0 0 2.87 0c.394-.189.755-.497 1.26-.928l.079-.066c.48-.41.939-.604 1.58-.655l.102-.008c.662-.053 1.135-.09 1.547-.236a3.33 3.33 0 0 0 2.03-2.029c.145-.412.182-.885.235-1.547l.008-.102c.05-.629.238-1.09.655-1.58l.066-.079c.431-.505.74-.866.928-1.26a3.33 3.33 0 0 0 0-2.87c-.189-.394-.497-.755-.928-1.26l-.066-.079a2.56 2.56 0 0 1-.655-1.58l-.008-.102c-.053-.662-.09-1.135-.236-1.547a3.33 3.33 0 0 0-2.029-2.03c-.412-.145-.885-.182-1.547-.235l-.102-.008a2.56 2.56 0 0 1-1.58-.655l-.079-.066c-.505-.431-.866-.74-1.26-.928M12 6.877a.75.75 0 0 1 .75.75v5.5a.75.75 0 0 1-1.5 0v-5.5a.75.75 0 0 1 .75-.75m.75 8.996v.5a.75.75 0 0 1-1.5 0v-.5a.75.75 0 0 1 1.5 0" />
                            </svg>

                        </div>
                    </div>

                    <div class="modal-body text-center ">
                        <p>Apakah Anda yakin ingin menghapus <strong id="deleteNama"></strong> ?</p>

                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn border border-success text-success" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-success">Ya, Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('halaqahTable');

            // Fitur pencarian baris tabel
            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                const rows = tableBody.getElementsByTagName('tr');

                for (let row of rows) {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                }
            });

            // --- Modal Edit ---
            const editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');
                const pendidik = button.getAttribute('data-pendidik');

                const form = editModal.querySelector('#editForm');
                form.action = `/halaqah/${id}`;
                form.querySelector('#editNama').value = nama;
                form.querySelector('#editPendidik').value = pendidik;
            });

            // --- Modal Hapus ---
            const deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                deleteModal.querySelector('#deleteForm').action = `/halaqah/${id}`;
            });
        });
    </script>


@endsection
