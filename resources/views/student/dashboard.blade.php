@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-home me-2"></i>Dashboard Mahasiswa
            </h2>
            <div class="text-muted">
                Selamat datang, <strong>{{ Auth::guard('student')->user()->name }}</strong>
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
                        <h6 class="card-title">NIM</h6>
                        <h4 class="mb-0">{{ Auth::guard('student')->user()->nim }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-id-card fa-2x"></i>
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
                        <h6 class="card-title">Program Studi</h6>
                        <h4 class="mb-0">{{ Auth::guard('student')->user()->major }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-graduation-cap fa-2x"></i>
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
                        <h6 class="card-title">Semester</h6>
                        <h4 class="mb-0">{{ Auth::guard('student')->user()->semester }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar-alt fa-2x"></i>
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
                        <h6 class="card-title">Tahun Akademik</h6>
                        <h4 class="mb-0">2024/2025</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar fa-2x"></i>
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
                    <i class="fas fa-list me-2"></i>Status KRS Semester Ganjil 2024/2025
                </h5>
            </div>
            <div class="card-body">
                @php
                    $student = Auth::guard('student')->user();
                    $selectedCourses = $student->studentCourses()
                                              ->with('course')
                                              ->where('academic_year', '2024/2025')
                                              ->where('semester', 'Ganjil')
                                              ->get();
                    $totalCredits = $selectedCourses->sum('course.credits');
                @endphp

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Total Mata Kuliah: <span class="badge bg-primary">{{ $selectedCourses->count() }}</span></h6>
                    </div>
                    <div class="col-md-6">
                        <h6>Total SKS: <span class="badge bg-success">{{ $totalCredits }}</span></h6>
                    </div>
                </div>

                @if($selectedCourses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Mata Kuliah</th>
                                    <th>Semester</th>
                                    <th>SKS</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($selectedCourses as $studentCourse)
                                    <tr>
                                        <td>{{ $studentCourse->course->code }}</td>
                                        <td>{{ $studentCourse->course->name }}</td>
                                        <td>{{ $studentCourse->course->semester }}</td>
                                        <td>{{ $studentCourse->course->credits }}</td>
                                        <td>
                                            @if($studentCourse->status == 'pending')
                                                <span class="badge bg-warning">Menunggu</span>
                                            @elseif($studentCourse->status == 'approved')
                                                <span class="badge bg-success">Disetujui</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada mata kuliah yang dipilih</p>
                        <a href="{{ route('student.courses') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Pilih Mata Kuliah
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-tasks me-2"></i>Menu Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('student.courses') }}" class="btn btn-outline-primary">
                        <i class="fas fa-book me-2"></i>Lihat Mata Kuliah
                    </a>
                    <a href="{{ route('student.krs') }}" class="btn btn-outline-success">
                        <i class="fas fa-list me-2"></i>Kelola KRS
                    </a>
                </div>

                <hr>

                <h6 class="text-muted mb-3">Informasi Penting:</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        <small>Maksimal 24 SKS per semester</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-clock text-warning me-2"></i>
                        <small>Perhatikan jadwal yang tidak bentrok</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>KRS akan divalidasi oleh admin</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection 