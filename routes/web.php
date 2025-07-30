<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\KRSController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserManagementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/student/login', [AuthController::class, 'showStudentLogin'])->name('student.login');
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/student/login', [AuthController::class, 'studentLogin'])->name('student.login.post');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth:student')->group(function () {
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');
    
    Route::get('/student/courses', [CourseController::class, 'availableCourses'])->name('student.courses');
    Route::get('/student/krs', [KRSController::class, 'index'])->name('student.krs');
    Route::post('/student/krs/select', [KRSController::class, 'selectCourse'])->name('student.krs.select');
    Route::post('/student/krs/remove', [KRSController::class, 'removeCourse'])->name('student.krs.remove');
    Route::get('/student/krs/{id}/edit', [KRSController::class, 'editKRS'])->name('student.krs.edit');
    Route::put('/student/krs/{id}', [KRSController::class, 'updateKRS'])->name('student.krs.update');
    Route::delete('/student/krs/{id}', [KRSController::class, 'deleteKRS'])->name('student.krs.delete');
});

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Manajemen Mata Kuliah
    Route::get('/courses', [AdminController::class, 'courses'])->name('courses.index');
    Route::get('/courses/create', [AdminController::class, 'createCourse'])->name('courses.create');
    Route::post('/courses', [AdminController::class, 'storeCourse'])->name('courses.store');
    Route::get('/courses/{id}/edit', [AdminController::class, 'editCourse'])->name('courses.edit');
    Route::put('/courses/{id}', [AdminController::class, 'updateCourse'])->name('courses.update');
    Route::delete('/courses/{id}', [AdminController::class, 'deleteCourse'])->name('courses.destroy');
    
    // Manajemen KRS
    Route::get('/krs', [AdminController::class, 'krs'])->name('krs.index');
    Route::post('/krs/{id}/approve', [AdminController::class, 'approveKRS'])->name('krs.approve');
    Route::post('/krs/{id}/reject', [AdminController::class, 'rejectKRS'])->name('krs.reject');
    
    // Manajemen User Mahasiswa
    Route::get('/users/students', [UserManagementController::class, 'students'])->name('users.students.index');
    Route::get('/users/students/create', [UserManagementController::class, 'createStudent'])->name('users.students.create');
    Route::post('/users/students', [UserManagementController::class, 'storeStudent'])->name('users.students.store');
    Route::get('/users/students/{id}/edit', [UserManagementController::class, 'editStudent'])->name('users.students.edit');
    Route::put('/users/students/{id}', [UserManagementController::class, 'updateStudent'])->name('users.students.update');
    Route::delete('/users/students/{id}', [UserManagementController::class, 'deleteStudent'])->name('users.students.destroy');
    
    // Manajemen User Admin/Koordinator
    Route::get('/users/admins', [UserManagementController::class, 'admins'])->name('users.admins.index');
    Route::get('/users/admins/create', [UserManagementController::class, 'createAdmin'])->name('users.admins.create');
    Route::post('/users/admins', [UserManagementController::class, 'storeAdmin'])->name('users.admins.store');
    Route::get('/users/admins/{id}/edit', [UserManagementController::class, 'editAdmin'])->name('users.admins.edit');
    Route::put('/users/admins/{id}', [UserManagementController::class, 'updateAdmin'])->name('users.admins.update');
    Route::delete('/users/admins/{id}', [UserManagementController::class, 'deleteAdmin'])->name('users.admins.destroy');
});
