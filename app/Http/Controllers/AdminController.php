<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\StudentCourse;
use App\Models\Student;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalCourses = Course::count();
        $totalStudents = Student::count();
        $pendingKRS = StudentCourse::where('status', 'pending')->count();
        $approvedKRS = StudentCourse::where('status', 'approved')->count();
        return view('admin.dashboard', compact('totalCourses', 'totalStudents', 'pendingKRS', 'approvedKRS'));
    }

    public function courses(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        
        $courses = Course::query()
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('code', 'like', '%' . $request->search . '%')
                        ->orWhere('name', 'like', '%' . $request->search . '%')
                        ->orWhere('lecturer', 'like', '%' . $request->search . '%')
                        ->orWhere('room', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->semester, fn($q) => $q->where('semester', $request->semester))
            ->when($request->day, fn($q) => $q->where('day', $request->day))
            ->when($request->status !== null, function ($q) use ($request) {
                $q->where('is_active', $request->status === '1');
            })
            ->orderBy('code')
            ->paginate($perPage);

        $semesters = Course::distinct()->pluck('semester')->sort();
        $days = Course::distinct()->pluck('day')->sort();

        return view('admin.courses.index', compact('courses', 'semesters', 'days'));
    }

    public function createCourse()
    {
        return view('admin.courses.create');
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:courses,code',
            'name' => 'required',
            'description' => 'nullable',
            'credits' => 'required|integer|min:1|max:6',
            'semester' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'room' => 'required',
            'lecturer' => 'required',
            'quota' => 'required|integer|min:1',
        ]);
        Course::create($request->all());
        return redirect()->route('admin.courses.index')->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function editCourse($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    }

    public function updateCourse(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $request->validate([
            'code' => 'required|unique:courses,code,' . $id,
            'name' => 'required',
            'description' => 'nullable',
            'credits' => 'required|integer|min:1|max:6',
            'semester' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'room' => 'required',
            'lecturer' => 'required',
            'quota' => 'required|integer|min:1',
        ]);
        $course->update($request->all());
        return redirect()->route('admin.courses.index')->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Mata kuliah berhasil dihapus.');
    }

    public function krs(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $courses = StudentCourse::with(['student', 'course'])
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('student', function($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%')
                          ->orWhere('nim', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('course', function($query) use ($request) {
                    $query->where('code', 'like', '%' . $request->search . '%')
                          ->orWhere('name', 'like', '%' . $request->search . '%')
                          ->orWhere('lecturer', 'like', '%' . $request->search . '%');
                })
                ->orWhere('student_id', 'like', '%' . $request->search . '%')
                ->orWhere('course_id', 'like', '%' . $request->search . '%');
            })
            ->when($request->semester, fn($q) => $q->whereHas('course', fn($query) => $query->where('semester', $request->semester)))
            ->when($request->status !== null, function ($q) use ($request) {
                if ($request->status === 'pending') {
                    $q->where('status', 'pending');
                } else {
                    $q->where('status', $request->status === '1' ? 'approved' : 'rejected');
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $semesters = Course::distinct()->pluck('semester')->sort();
            
        return view('admin.krs.index', compact('courses', 'semesters'));
    }

    public function approveKRS($id)
    {
        $submission = StudentCourse::findOrFail($id);
        $submission->update(['status' => 'approved']);
        return back()->with('success', 'KRS berhasil disetujui.');
    }

    public function rejectKRS(Request $request, $id)
    {
        $submission = StudentCourse::findOrFail($id);
        $submission->update([
            'status' => 'rejected',
            'notes' => $request->notes ?? null,
        ]);
        $course = Course::find($submission->course_id);
        $course->increment('quota');
        return back()->with('success', 'KRS berhasil ditolak.');
    }
}
