@extends('layouts.app')

@section('title', 'Login - Sistem KRS')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow">
            <div class="card-header bg-info text-white text-center">
                <h4 class="mb-0">
                    <i class="fas fa-sign-in-alt me-2"></i>Pilih Jenis Login
                </h4>
            </div>
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <p class="lead text-muted">Silakan pilih jenis akun untuk login ke sistem KRS</p>
                </div>

                <div class="row g-4">
                    <!-- Student Login Option -->
                    <div class="col-md-6">
                        <div class="card h-100 border-primary">
                            <div class="card-body text-center d-flex flex-column">
                                <div class="mb-3">
                                    <i class="fas fa-user fa-3x text-primary"></i>
                                </div>
                                <h5 class="card-title text-primary">Mahasiswa</h5>
                                <p class="card-text text-muted flex-grow-1">
                                    Login sebagai mahasiswa untuk mengakses sistem KRS, melihat mata kuliah, dan mengelola jadwal kuliah.
                                </p>
                                <a href="{{ route('student.login') }}" class="btn btn-primary">
                                    <i class="fas fa-user me-2"></i>Login Mahasiswa
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Login Option -->
                    <div class="col-md-6">
                        <div class="card h-100 border-success">
                            <div class="card-body text-center d-flex flex-column">
                                <div class="mb-3">
                                    <i class="fas fa-user-shield fa-3x text-success"></i>
                                </div>
                                <h5 class="card-title text-success">Administrator</h5>
                                <p class="card-text text-muted flex-grow-1">
                                    Login sebagai administrator untuk mengelola mata kuliah, mahasiswa, dan validasi KRS.
                                </p>
                                <a href="{{ route('admin.login') }}" class="btn btn-success">
                                    <i class="fas fa-user-shield me-2"></i>Login Admin
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="text-center">
                    <p class="text-muted mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        Sistem Kartu Rencana Studi (KRS) Online
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection