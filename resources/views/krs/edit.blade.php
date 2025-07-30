@extends('layouts.app')

@section('title', 'Edit KRS')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Edit KRS
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-primary">Informasi Mata Kuliah</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Kode:</strong></td>
                                    <td>{{ $studentCourse->course->code }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama:</strong></td>
                                    <td>{{ $studentCourse->course->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>SKS:</strong></td>
                                    <td>{{ $studentCourse->course->credits }} SKS</td>
                                </tr>
                                <tr>
                                    <td><strong>Jadwal:</strong></td>
                                    <td>{{ $studentCourse->course->day }}, {{ $studentCourse->course->start_time }} - {{ $studentCourse->course->end_time }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Ruangan:</strong></td>
                                    <td>{{ $studentCourse->course->room }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Dosen:</strong></td>
                                    <td>{{ $studentCourse->course->lecturer }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Informasi KRS</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @if($studentCourse->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($studentCourse->status == 'approved')
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tahun Akademik:</strong></td>
                                    <td>{{ $studentCourse->academic_year }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Semester:</strong></td>
                                    <td>{{ $studentCourse->semester }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Submit:</strong></td>
                                    <td>{{ $studentCourse->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <form action="{{ route('student.krs.update', $studentCourse->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="4" 
                                      placeholder="Tambahkan catatan atau alasan pemilihan mata kuliah ini...">{{ old('notes', $studentCourse->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Catatan ini akan membantu administrator dalam memproses KRS Anda.
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('student.krs') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update KRS
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 