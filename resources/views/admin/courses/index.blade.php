@extends('layouts.admin')

@section('title', 'Kelola Mata Kuliah')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-book me-2"></i>Kelola Mata Kuliah
                    </h4>
                    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Tambah Mata Kuliah
                    </a>
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
                                    <form method="GET" action="{{ route('admin.courses.index') }}" class="row g-3">
                                        <div class="col-md-3">
                                            <label for="search" class="form-label">Cari Mata Kuliah</label>
                                            <input type="text" class="form-control" id="search" name="search"
                                                   value="{{ request('search') }}"
                                                   placeholder="Kode, nama, dosen, ruang...">
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
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="">Semua Status</option>
                                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
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
                                    <th style="color: black;">Kode</th>
                                    <th style="color: black;">Nama Mata Kuliah</th>
                                    <th style="color: black;">SKS</th>
                                    <th style="color: black;">Semester</th>
                                    <th style="color: black;">Jadwal</th>
                                    <th style="color: black;">Ruangan</th>
                                    <th style="color: black;">Dosen</th>
                                    <th style="color: black;">Kuota</th>
                                    <th style="color: black;">Status</th>
                                    <th style="color: black;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courses as $course)
                                <tr>
                                    <td style="color: black;"><strong>{{ $course->code }}</strong></td>
                                    <td style="color: black;">{{ $course->name }}</td>
                                    <td style="color: black;"><span class="badge bg-info">{{ $course->credits }} SKS</span></td>
                                    <td style="color: black;">Semester {{ $course->semester }}</td>
                                    <td style="color: black;">
                                        <small>
                                            {{ $course->day }}, {{ $course->start_time }} - {{ $course->end_time }}
                                        </small>
                                    </td>
                                    <td style="color: black;">{{ $course->room }}</td>
                                    <td style="color: black;">{{ $course->lecturer }}</td>
                                    <td style="color: black;">
                                        @if($course->quota > 0)
                                            <span class="badge bg-success">{{ $course->quota }} tersedia</span>
                                        @else
                                            <span class="badge bg-danger">Penuh</span>
                                        @endif
                                    </td>
                                    <td style="color: black;">
                                        @if($course->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.courses.edit', $course->id) }}"
                                               class="btn btn-sm btn-warning"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.courses.destroy', $course->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada mata kuliah yang tersedia.</p>
                                        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i>Tambah Mata Kuliah Pertama
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($courses->hasPages())
                            <nav class="d-flex justify-content-center mt-4">
            {{ $courses->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
        </nav>
                    @endif

                    <!-- Results Info -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="text-muted small">
                                Menampilkan {{ $courses->firstItem() ?? 0 }} sampai {{ $courses->lastItem() ?? 0 }}
                                dari {{ $courses->total() }} mata kuliah
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection