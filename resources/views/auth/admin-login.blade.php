@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">
                    <i class="fas fa-user-shield me-2"></i>Login Administrator
                </h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.login.post') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">
                            <i class="fas fa-user me-1"></i>Username
                        </label>
                        <input type="text" 
                               class="form-control @error('username') is-invalid @enderror" 
                               id="username" 
                               name="username" 
                               value="{{ old('username') }}" 
                               placeholder="Masukkan username"
                               required 
                               autofocus>
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-1"></i>Password
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Masukkan password"
                               required>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </div>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <p class="text-muted mb-2">Akses sebagai mahasiswa?</p>
                    <a href="{{ route('student.login') }}" class="text-decoration-none">
                        <i class="fas fa-user me-1"></i>Login sebagai Mahasiswa
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 