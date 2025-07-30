<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentCourse;

class StudentCourseApiController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentCourse::with(['student', 'course']);
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $perPage = $request->get('per_page', 10);
        $studentCourses = $query->orderBy('created_at', 'desc')->paginate($perPage);
        return response()->json($studentCourses);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'academic_year' => 'required',
            'semester' => 'required',
            'status' => 'nullable|in:pending,approved,rejected',
            'notes' => 'nullable|string',
        ]);
        $studentCourse = StudentCourse::create($validated);
        return response()->json($studentCourse, 201);
    }

    public function show($id)
    {
        $studentCourse = StudentCourse::with(['student', 'course'])->findOrFail($id);
        return response()->json($studentCourse);
    }

    public function update(Request $request, $id)
    {
        $studentCourse = StudentCourse::findOrFail($id);
        $validated = $request->validate([
            'status' => 'nullable|in:pending,approved,rejected',
            'notes' => 'nullable|string',
        ]);
        $studentCourse->update($validated);
        return response()->json($studentCourse);
    }

    public function destroy($id)
    {
        $studentCourse = StudentCourse::findOrFail($id);
        $studentCourse->delete();
        return response()->json(['message' => 'StudentCourse deleted']);
    }
}
