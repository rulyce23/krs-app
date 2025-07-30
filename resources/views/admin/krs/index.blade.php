@extends('layouts.admin')

@section('title', 'Kelola KRS')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>Kelola KRS
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


                          <!-- Search and Filter Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-search me-2"></i>Pencarian & Filter
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form method="GET" action="{{ route('admin.krs.index') }}" class="row g-3">
                                        <div class="col-md-3">
                                            <label for="search" class="form-label">Cari KRS Mahasiswa</label>
                                            <input type="text" class="form-control" id="search" name="search"
                                                   value="{{ request('search') }}"
                                                   placeholder="NIM, nama mahasiswa, kode/nama mata kuliah, dosen...">
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
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="">Semua Status</option>
                                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Disetujui</option>
                                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Ditolak</option>
                                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
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

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th style="color:black;">Mahasiswa</th>
                                    <th style="color:black;">Mata Kuliah</th>
                                    <th style="color:black;">SKS</th>
                                    <th style="color:black;">Semester</th>
                                    <th style="color:black;">Tahun Akademik</th>
                                    <th style="color:black;">Status</th>
                                    <th style="color:black;">Tanggal Submit</th>
                                    <th style="color:black;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courses as $submission)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $submission->student->name }}</strong><br>
                                            <small class="text-muted">{{ $submission->student->nim }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $submission->course->code }}</strong><br>
                                            <small>{{ $submission->course->name }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $submission->course->credits }} SKS</span>
                                    </td>
                                    <td>Semester {{ $submission->course->semester }}</td>
                                    <td>{{ $submission->academic_year }}</td>
                                    <td>
                                        @if($submission->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($submission->status == 'approved')
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $submission->created_at->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td>
                                        @if($submission->status == 'pending')
                                            <div class="btn-group" role="group">
                                                <form action="{{ route('admin.krs.approve', $submission->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" 
                                                            title="Setujui" 
                                                            onclick="return confirm('Setujui KRS ini?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.krs.reject', $submission->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            title="Tolak" 
                                                            onclick="return confirm('Tolak KRS ini?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                                <div class="mt-1">
                                                    <small class="text-muted">Belum diproses</small>
                                                </div>
                                            </div>
                                        @elseif($submission->status == 'approved')
                                            <div>
                                                <div class="mb-2">
                                                    <small class="text-success fw-bold">Sudah diproses (ACC)</small>
                                                </div>
                                                <form action="{{ route('admin.krs.reject', $submission->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            title="Batalkan/Tolak" 
                                                            onclick="return confirm('Batalkan persetujuan dan tolak KRS ini?')">
                                                        <i class="fas fa-times"></i> Batalkan
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <div>
                                                <div class="mb-2">
                                                    <small class="text-danger fw-bold">Sudah diproses (Ditolak)</small>
                                                </div>
                                                <form action="{{ route('admin.krs.approve', $submission->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" 
                                                            title="Setujui" 
                                                            onclick="return confirm('Setujui KRS ini?')">
                                                        <i class="fas fa-check"></i> Setujui
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada KRS yang tersedia.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($courses->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $courses->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection