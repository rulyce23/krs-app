<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('lecturer', 'like', "%{$search}%");
            });
        }
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }
        if ($request->filled('credits')) {
            $query->where('credits', $request->credits);
        }
        $perPage = $request->get('per_page', 10);
        $courses = $query->orderBy('code')->paginate($perPage);
        return response()->json($courses);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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
        $course = Course::create($validated);
        return response()->json($course, 201);
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        return response()->json($course);
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $validated = $request->validate([
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
        $course->update($validated);
        return response()->json($course);
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return response()->json(['message' => 'Course deleted']);
    }
}
