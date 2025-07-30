@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-user-shield me-2"></i>Dashboard Administrator
            </h2>
            <div class="text-muted">
                Selamat datang, <strong>{{ Auth::guard('admin')->user()->name }}</strong>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Mata Kuliah</h6>
                        <h4 class="mb-0">{{ $totalCourses }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-book fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Mahasiswa</h6>
                        <h4 class="mb-0">{{ $totalStudents }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">KRS Menunggu</h6>
                        <h4 class="mb-0">{{ $pendingKRS }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">KRS Disetujui</h6>
                        <h4 class="mb-0">{{ $approvedKRS }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-tasks me-2"></i>Menu Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <i class="fas fa-book fa-3x text-primary mb-3"></i>
                                <h5>Kelola Mata Kuliah</h5>
                                <p class="text-muted">Tambah, edit, atau hapus data mata kuliah</p>
                                <a href="{{ route('admin.courses.index') }}" class="btn btn-primary">
                                    <i class="fas fa-cog me-2"></i>Kelola
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card border-success">
                            <div class="card-body text-center">
                                <i class="fas fa-list fa-3x text-success mb-3"></i>
                                <h5>KRS Submissions</h5>
                                <p class="text-muted">Validasi pengajuan KRS mahasiswa</p>
                                <a href="{{ route('admin.krs.index') }}" class="btn btn-success">
                                    <i class="fas fa-eye me-2"></i>Lihat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Sistem
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-primary">Tahun Akademik</h6>
                    <p class="mb-0">2024/2025</p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-success">Semester Aktif</h6>
                    <p class="mb-0">Ganjil</p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-warning">Status KRS</h6>
                    <p class="mb-0">Dibuka</p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-info">Deadline</h6>
                    <p class="mb-0">01 Agustus 2025</p>
                </div>

                <hr>

                <h6 class="text-muted mb-3">Fitur Tersedia:</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Manajemen mata kuliah</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Validasi KRS mahasiswa</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Monitoring sistem</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection