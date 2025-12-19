@extends('layouts.app')

@section('page_title','Data User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Daftar User</h5>
    <a href="{{ route('user.create') }}" class="btn btn-success">Tambah User</a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Desktop Table View -->
<div class="table-responsive d-none d-lg-block">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id_user }}</td>
                    <td>{{ $user->nama }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role == 'admin')
                            <span class="badge bg-danger">Admin</span>
                        @elseif($user->role == 'musyrif')
                            <span class="badge bg-primary">Musyrif</span>
                        @elseif($user->role == 'pengajar')
                            <span class="badge bg-success">Pengajar</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($user->role) }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('user.edit', $user->id_user) }}" class="btn btn-sm btn-warning">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id_user }}">
                            Hapus
                        </button>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal{{ $user->id_user }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus user <strong>{{ $user->nama }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('user.destroy', $user->id_user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data user</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Mobile Card View -->
<div class="d-lg-none">
    @forelse($users as $user)
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title">{{ $user->nama }}</h6>
                <p class="card-text mb-2">
                    <strong>Email:</strong> {{ $user->email }}<br>
                    <strong>Role:</strong> 
                    @if($user->role == 'admin')
                        <span class="badge bg-danger">Admin</span>
                    @elseif($user->role == 'musyrif')
                        <span class="badge bg-primary">Musyrif</span>
                    @elseif($user->role == 'pengajar')
                        <span class="badge bg-success">Pengajar</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst($user->role) }}</span>
                    @endif
                </p>
                <div class="d-flex gap-2">
                    <a href="{{ route('user.edit', $user->id_user) }}" class="btn btn-sm btn-warning flex-fill">Edit</a>
                    <button type="button" class="btn btn-sm btn-danger flex-fill" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id_user }}">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">Tidak ada data user</div>
    @endforelse
</div>

@endsection
