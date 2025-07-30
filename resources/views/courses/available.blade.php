@extends('layouts.app')

@section('title', 'Mata Kuliah Tersedia')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-book me-2"></i>Mata Kuliah Tersedia
            </h2>
            <a href="{{ route('student.krs') }}" class="btn btn-outline-primary">
                <i class="fas fa-list me-2"></i>Lihat KRS Saya
            </a>
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-search me-2"></i>Pencarian & Filter
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('student.courses') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="search" class="form-label">Cari Mata Kuliah</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Kode, nama, atau dosen...">
                    </div>
                    <div class="col-md-2">
                        <label for="semester" class="form-label">Semester</label>
                        <select class="form-select" id="semester" name="semester">
                            <option value="">Semua Semester</option>
                            @foreach($semesters as $semester)
                                <option value="{{ $semester }}" {{ request('semester') == $semester ? 'selected' : '' }}>
                                    Semester {{ $semester }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="day" class="form-label">Hari</label>
                        <select class="form-select" id="day" name="day">
                            <option value="">Semua Hari</option>
                            @foreach($days as $day)
                                <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>
                                    {{ $day }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="credits" class="form-label">SKS</label>
                        <select class="form-select" id="credits" name="credits">
                            <option value="">Semua SKS</option>
                            @foreach($credits as $credit)
                                <option value="{{ $credit }}" {{ request('credits') == $credit ? 'selected' : '' }}>
                                    {{ $credit }} SKS
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="per_page" class="form-label">Tampilkan</label>
                        <select class="form-select" id="per_page" name="per_page">
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Semester Ganjil 2024/2025
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <h6>Total Mata Kuliah: <span class="badge bg-primary">{{ $courses->total() }}</span></h6>
                    </div>
                    <div class="col-md-3">
                        <h6>Maksimal SKS: <span class="badge bg-warning">24 SKS</span></h6>
                    </div>
                    <div class="col-md-3">
                        <h6>Status: <span class="badge bg-success">KRS Dibuka</span></h6>
                    </div>
                    <div class="col-md-3">
                        <h6>Deadline: <span class="badge bg-info">01 Agustus 2025</span></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($courses->count() > 0)
    <div class="row">
        @foreach($courses as $course)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">{{ $course->code }}</h6>
                        <span class="badge bg-primary">{{ $course->credits }} SKS</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $course->name }}</h5>
                        @if($course->description)
                            <p class="card-text text-muted">{{ Str::limit($course->description, 100) }}</p>
                        @endif
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>{{ $course->day }}
                                </small>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>{{ $course->start_time }} - {{ $course->end_time }}
                                </small>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $course->room }}<br>
                                    <i class="fas fa-book me-1"></i>Semester : {{ $course->semester }}
                                </small>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i>{{ $course->lecturer }}
                                </small>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-users me-1"></i>Kuota: {{ $course->quota }}
                            </small>
                            <form method="POST" action="{{ route('student.krs.select') }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <button type="submit" class="btn btn-sm btn-success" 
                                        {{ $course->quota <= 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-plus me-1"></i>
                                    {{ $course->quota <= 0 ? 'Penuh' : 'Pilih' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($courses->hasPages())
        <nav class="d-flex justify-content-center mt-4">
            {{ $courses->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
        </nav>
    @endif
@else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-book fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada mata kuliah yang tersedia</h5>
                    <p class="text-muted">Silakan hubungi administrator untuk informasi lebih lanjut.</p>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection 