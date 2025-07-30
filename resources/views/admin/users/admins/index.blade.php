@extends('layouts.admin')

@section('title', 'Manajemen Admin/Koordinator')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Admin/Koordinator</h1>
        <a href="{{ route('admin.users.admins.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Admin/Koordinator
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Admin/Koordinator</h6>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <form action="{{ route('admin.users.admins.index') }}" method="GET" class="form-inline">
                    <div class="form-group mb-2 mr-2">
                        <input type="text" class="form-control" name="search" placeholder="Cari username, nama, email..." value="{{ request('search') }}">
                    </div>
                    <div class="form-group mb-2 mr-2">
                        <select name="role" class="form-control">
                            <option value="">Pilih Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2 mr-2">
                        <select name="per_page" class="form-control">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Filter</button>
                </form>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $admin)
                            <tr>
                                <td>{{ $admin->username }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    <span class="badge badge-{{ $admin->role == 'admin' ? 'primary' : 'info' }}">
                                        {{ ucfirst($admin->role) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.admins.edit', $admin->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.users.admins.destroy', $admin->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data admin/koordinator</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $admins->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection