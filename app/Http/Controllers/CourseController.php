<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function availableCourses(Request $request)
    {
        $student = auth('student')->user();
        $studentSemester = (int) $student->semester;
        
        $courses = Course::query()
            ->active()
            ->where('quota', '>', 0)
            ->where('semester', '<=', $studentSemester)
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('code', 'like', '%' . $request->search . '%')
                        ->orWhere('name', 'like', '%' . $request->search . '%')
                        ->orWhere('lecturer', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->semester, fn($q) => $q->where('semester', $request->semester))
            ->when($request->day, fn($q) => $q->where('day', $request->day))
            ->when($request->credits, fn($q) => $q->where('credits', $request->credits))
            ->orderBy('code')
            ->paginate($request->get('per_page', 10));

        $semesters = Course::distinct()
            ->where('semester', '<=', $studentSemester)
            ->pluck('semester')
            ->sort();
        $days = Course::distinct()->pluck('day')->sort();
        $credits = Course::distinct()->pluck('credits')->sort();

        return view('courses.available', [
            'courses' => $courses,
            'semesters' => $semesters,
            'days' => $days,
            'credits' => $credits,
            'student' => $student,
        ]);
    }
}
