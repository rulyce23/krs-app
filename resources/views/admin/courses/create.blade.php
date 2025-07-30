@extends('layouts.admin')

@section('title', 'Tambah Mata Kuliah')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-plus me-2"></i>Tambah Mata Kuliah Baru
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.courses.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Kode Mata Kuliah <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                           id="code" name="code" value="{{ old('code') }}" 
                                           placeholder="Contoh: IF101" required>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="credits" class="form-label">SKS <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('credits') is-invalid @enderror" 
                                           id="credits" name="credits" value="{{ old('credits') }}" 
                                           min="1" max="6" required>
                                    @error('credits')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Mata Kuliah <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="Contoh: Pemrograman Web" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" 
                                      placeholder="Deskripsi singkat mata kuliah">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                    <select class="form-select @error('semester') is-invalid @enderror" 
                                            id="semester" name="semester" required>
                                        <option value="">Pilih Semester</option>
                                        <option value="1" {{ old('semester') == '1' ? 'selected' : '' }}>Semester 1</option>
                                        <option value="2" {{ old('semester') == '2' ? 'selected' : '' }}>Semester 2</option>
                                        <option value="3" {{ old('semester') == '3' ? 'selected' : '' }}>Semester 3</option>
                                        <option value="4" {{ old('semester') == '4' ? 'selected' : '' }}>Semester 4</option>
                                        <option value="5" {{ old('semester') == '5' ? 'selected' : '' }}>Semester 5</option>
                                        <option value="6" {{ old('semester') == '6' ? 'selected' : '' }}>Semester 6</option>
                                        <option value="7" {{ old('semester') == '7' ? 'selected' : '' }}>Semester 7</option>
                                        <option value="8" {{ old('semester') == '8' ? 'selected' : '' }}>Semester 8</option>
                                    </select>
                                    @error('semester')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quota" class="form-label">Kuota <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('quota') is-invalid @enderror" 
                                           id="quota" name="quota" value="{{ old('quota') }}" 
                                           min="1" max="100" required>
                                    @error('quota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="day" class="form-label">Hari <span class="text-danger">*</span></label>
                                    <select class="form-select @error('day') is-invalid @enderror" 
                                            id="day" name="day" required>
                                        <option value="">Pilih Hari</option>
                                        <option value="Senin" {{ old('day') == 'Senin' ? 'selected' : '' }}>Senin</option>
                                        <option value="Selasa" {{ old('day') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                        <option value="Rabu" {{ old('day') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                        <option value="Kamis" {{ old('day') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                        <option value="Jumat" {{ old('day') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                        <option value="Sabtu" {{ old('day') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                    </select>
                                    @error('day')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                                           id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="end_time" class="form-label">Waktu Selesai <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                                           id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="room" class="form-label">Ruangan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('room') is-invalid @enderror" 
                                           id="room" name="room" value="{{ old('room') }}" 
                                           placeholder="Contoh: Lab 1.1" required>
                                    @error('room')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lecturer" class="form-label">Dosen Pengampu <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('lecturer') is-invalid @enderror" 
                                           id="lecturer" name="lecturer" value="{{ old('lecturer') }}" 
                                           placeholder="Nama Dosen" required>
                                    @error('lecturer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Mata kuliah aktif (dapat dipilih mahasiswa)
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Simpan Mata Kuliah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection