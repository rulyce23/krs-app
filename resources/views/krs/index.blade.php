@extends('layouts.app')

@section('title', 'Kartu Rencana Studi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-list me-2"></i>Kartu Rencana Studi (KRS)
            </h2>
            <a href="{{ route('student.courses') }}" class="btn btn-outline-primary">
                <i class="fas fa-plus me-2"></i>Tambah Mata Kuliah
            </a>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi KRS Semester Ganjil 2024/2025
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <h6>Nama: <span class="text-primary">{{ Auth::guard('student')->user()->name }}</span></h6>
                    </div>
                    <div class="col-md-3">
                        <h6>NIM: <span class="text-primary">{{ Auth::guard('student')->user()->nim }}</span></h6>
                    </div>
                    <div class="col-md-3">
                        <h6>Total SKS: <span class="badge bg-success">{{ $totalCredits }}</span></h6>
                    </div>
                    <div class="col-md-3">
                        <h6>Status: 
                            @if($totalCredits >= 18)
                                <span class="badge bg-success">Lengkap</span>
                            @elseif($totalCredits > 0)
                                <span class="badge bg-warning">Belum Lengkap</span>
                            @else
                                <span class="badge bg-danger">Kosong</span>
                            @endif
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($selectedCourses->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-table me-2"></i>Daftar Mata Kuliah yang Dipilih
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Mata Kuliah</th>
                                    <th>SKS</th>
                                    <th>Semester</th>
                                    <th>Jadwal</th>
                                    <th>Ruangan</th>
                                    <th>Dosen</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($selectedCourses as $index => $studentCourse)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><strong>{{ $studentCourse->course->code }}</strong></td>
                                        <td>{{ $studentCourse->course->name }}</td>
                                        <td>{{ $studentCourse->course->credits }}</td>
                                        <td>{{ $studentCourse->course->semester }}</td>
                                   
                                        <td>
                                            <small>
                                                {{ $studentCourse->course->day }}<br>
                                                {{ $studentCourse->course->start_time }} - {{ $studentCourse->course->end_time }}
                                            </small>
                                        </td>
                                        <td>{{ $studentCourse->course->room }}</td>
                                        <td>{{ $studentCourse->course->lecturer }}</td>
                                        <td>
                                            @if($studentCourse->status == 'pending')
                                                <span class="badge bg-warning">Menunggu</span>
                                            @elseif($studentCourse->status == 'approved')
                                                <span class="badge bg-success">Disetujui</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                                @if($studentCourse->notes)
                                                    <br><small class="text-muted">{{ $studentCourse->notes }}</small>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($studentCourse->status == 'pending')
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('student.krs.edit', $studentCourse->id) }}" 
                                                       class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('student.krs.delete', $studentCourse->id) }}" 
                                                          method="POST" class="d-inline"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini dari KRS?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-primary">
                                    <td colspan="3"><strong>Total</strong></td>
                                    <td><strong>{{ $totalCredits }}</strong></td>
                                    <td colspan="5"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-print me-2"></i>Cetak KRS
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Cetak KRS untuk keperluan administrasi akademik.</p>
                    <button class="btn btn-primary" onclick="window.print()">
                        <i class="fas fa-print me-2"></i>Cetak KRS
                    </button>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Penting
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <small>Minimal 18 SKS untuk dapat mengikuti perkuliahan</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                            <small>Maksimal 24 SKS per semester</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-clock text-info me-2"></i>
                            <small>KRS akan divalidasi oleh admin dalam 1-2 hari kerja</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-list fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">KRS Anda masih kosong</h5>
                    <p class="text-muted">Silakan pilih mata kuliah yang ingin Anda ambil untuk semester ini.</p>
                    <a href="{{ route('student.courses') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Pilih Mata Kuliah
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection 