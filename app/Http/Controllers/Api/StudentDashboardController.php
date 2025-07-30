<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentCourseResource;
use App\Http\Resources\CourseResource;
use App\Models\Student;
use App\Models\Course;
use App\Models\StudentCourse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class StudentDashboardController extends Controller
{
    /**
     * Get student dashboard data
     */
    public function index(Request $request): JsonResponse
    {
        $student = $request->user();
        
        if (!$student instanceof Student) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Student authentication required.',
                'data' => null,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => 'v1'
                ]
            ], 403);
        }

        // Get current academic year and semester
        $currentYear = now()->year;
        $currentSemester = now()->month >= 8 ? 'Ganjil' : 'Genap';
        $academicYear = now()->month >= 8 ? $currentYear . '/' . ($currentYear + 1) : ($currentYear - 1) . '/' . $currentYear;

        // Get student's current KRS
        $currentKRS = $student->studentCourses()
            ->with('course')
            ->where('academic_year', $academicYear)
            ->where('semester', $currentSemester)
            ->get();

        // Calculate total credits
        $totalCredits = $currentKRS->where('status', 'approved')->sum(function ($sc) {
            return $sc->course->credits;
        });

        // Count by status
        $statusCounts = [
            'pending' => $currentKRS->where('status', 'pending')->count(),
            'approved' => $currentKRS->where('status', 'approved')->count(),
            'rejected' => $currentKRS->where('status', 'rejected')->count(),
        ];

        // Get weekly schedule for approved courses
        $weeklySchedule = $this->getWeeklySchedule($currentKRS->where('status', 'approved'));

        // Get recent notifications
        $recentNotifications = $student->notifications()
            ->take(5)
            ->get();

        // Get academic progress (all semesters)
        $academicProgress = $this->getAcademicProgress($student);

        return response()->json([
            'success' => true,
            'message' => 'Dashboard data retrieved successfully',
            'data' => [
                'student_info' => [
                    'nim' => $student->nim,
                    'name' => $student->name,
                    'major' => $student->major,
                    'semester' => $student->semester,
                ],
                'current_period' => [
                    'academic_year' => $academicYear,
                    'semester' => $currentSemester,
                ],
                'krs_summary' => [
                    'total_courses' => $currentKRS->count(),
                    'total_credits' => $totalCredits,
                    'status_counts' => $statusCounts,
                ],
                'weekly_schedule' => $weeklySchedule,
                'recent_notifications' => $recentNotifications->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'title' => $notification->title,
                        'message' => $notification->message,
                        'type' => $notification->type,
                        'is_read' => $notification->read(),
                        'created_at' => $notification->created_at,
                    ];
                }),
                'academic_progress' => $academicProgress,
                'current_krs' => StudentCourseResource::collection($currentKRS),
            ],
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }

    /**
     * Get student's weekly schedule
     */
    private function getWeeklySchedule($approvedCourses): array
    {
        $schedule = [];
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        foreach ($days as $day) {
            $schedule[$day] = [];
        }

        foreach ($approvedCourses as $studentCourse) {
            $course = $studentCourse->course;
            $schedule[$course->day][] = [
                'course_code' => $course->code,
                'course_name' => $course->name,
                'lecturer' => $course->lecturer,
                'room' => $course->room,
                'start_time' => $course->start_time,
                'end_time' => $course->end_time,
                'credits' => $course->credits,
            ];
        }

        // Sort by start time
        foreach ($schedule as $day => $courses) {
            usort($schedule[$day], function ($a, $b) {
                return strcmp($a['start_time'], $b['start_time']);
            });
        }

        return $schedule;
    }

    /**
     * Get student's academic progress
     */
    private function getAcademicProgress(Student $student): array
    {
        $allStudentCourses = $student->studentCourses()
            ->with('course')
            ->where('status', 'approved')
            ->get()
            ->groupBy('academic_year');

        $progress = [];
        $totalCredits = 0;
        $totalCourses = 0;

        foreach ($allStudentCourses as $year => $courses) {
            $yearCredits = $courses->sum(function ($sc) {
                return $sc->course->credits;
            });
            
            $progress[] = [
                'academic_year' => $year,
                'total_courses' => $courses->count(),
                'total_credits' => $yearCredits,
                'semesters' => $courses->groupBy('semester')->map(function ($semesterCourses, $semester) {
                    return [
                        'semester' => $semester,
                        'courses_count' => $semesterCourses->count(),
                        'credits' => $semesterCourses->sum(function ($sc) {
                            return $sc->course->credits;
                        }),
                    ];
                })->values(),
            ];

            $totalCredits += $yearCredits;
            $totalCourses += $courses->count();
        }

        return [
            'total_credits_earned' => $totalCredits,
            'total_courses_taken' => $totalCourses,
            'yearly_progress' => $progress,
        ];
    }

    /**
     * Get available courses for current period
     */
    public function availableCourses(Request $request): JsonResponse
    {
        $student = $request->user();
        
        if (!$student instanceof Student) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Student authentication required.',
                'data' => null,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => 'v1'
                ]
            ], 403);
        }

        $perPage = $request->get('per_page', 10);
        
        // Get current academic year and semester
        $currentYear = now()->year;
        $currentSemester = now()->month >= 8 ? 'Ganjil' : 'Genap';
        $academicYear = now()->month >= 8 ? $currentYear . '/' . ($currentYear + 1) : ($currentYear - 1) . '/' . $currentYear;

        // Get courses that student hasn't taken in current period
        $takenCourseIds = $student->studentCourses()
            ->where('academic_year', $academicYear)
            ->where('semester', $currentSemester)
            ->pluck('course_id');

        $query = Course::active()
            ->whereNotIn('id', $takenCourseIds)
            ->withCount(['studentCourses as enrolled_count' => function ($query) use ($academicYear, $currentSemester) {
                $query->where('academic_year', $academicYear)
                      ->where('semester', $currentSemester)
                      ->where('status', 'approved');
            }]);

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('lecturer', 'like', "%{$search}%");
            });
        }

        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }

        if ($request->filled('credits')) {
            $query->where('credits', $request->credits);
        }

        $courses = $query->orderBy('code')->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Available courses retrieved successfully',
            'data' => CourseResource::collection($courses),
            'meta' => [
                'pagination' => [
                    'current_page' => $courses->currentPage(),
                    'last_page' => $courses->lastPage(),
                    'per_page' => $courses->perPage(),
                    'total' => $courses->total(),
                ],
                'current_period' => [
                    'academic_year' => $academicYear,
                    'semester' => $currentSemester,
                ],
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }
}