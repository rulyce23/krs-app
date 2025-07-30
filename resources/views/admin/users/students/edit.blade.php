@extends('layouts.admin')

@section('title', 'Edit Mahasiswa')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Mahasiswa</h1>
        <a href="{{ route('admin.users.students.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Mahasiswa</h6>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nim">NIM <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim', $student->nim) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $student->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $student->email) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password. Minimal 8 karakter jika diisi.</small>
                        </div>
                        <div class="form-group">
                            <label for="major">Jurusan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="major" name="major" value="{{ old('major', $student->major) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="semester">Semester <span class="text-danger">*</span></label>
                            <select class="form-control" id="semester" name="semester" required>
                                @for ($i = 1; $i <= 14; $i++)
                                    <option value="{{ $i }}" {{ old('semester', $student->semester) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection