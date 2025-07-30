<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentCourseResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\StudentResource;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Course;
use App\Models\StudentCourse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Get admin dashboard data
     */
    public function index(Request $request): JsonResponse
    {
        $admin = $request->user();
        
        if (!$admin instanceof Admin) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Admin authentication required.',
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

        // Get overall statistics
        $totalStudents = Student::count();
        $totalCourses = Course::count();
        $activeCourses = Course::active()->count();

        // Get KRS statistics for current period
        $krsStats = $this->getKRSStatistics($academicYear, $currentSemester);

        // Get pending approvals
        $pendingApprovals = StudentCourse::with(['student', 'course'])
            ->where('status', 'pending')
            ->where('academic_year', $academicYear)
            ->where('semester', $currentSemester)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get popular courses
        $popularCourses = $this->getPopularCourses($academicYear, $currentSemester);

        // Get enrollment trends
        $enrollmentTrends = $this->getEnrollmentTrends();

        // Get recent activities
        $recentActivities = $this->getRecentActivities();

        return response()->json([
            'success' => true,
            'message' => 'Admin dashboard data retrieved successfully',
            'data' => [
                'admin_info' => [
                    'username' => $admin->username,
                    'name' => $admin->name,
                    'role' => $admin->role,
                ],
                'current_period' => [
                    'academic_year' => $academicYear,
                    'semester' => $currentSemester,
                ],
                'overview_stats' => [
                    'total_students' => $totalStudents,
                    'total_courses' => $totalCourses,
                    'active_courses' => $activeCourses,
                    'inactive_courses' => $totalCourses - $activeCourses,
                ],
                'krs_statistics' => $krsStats,
                'pending_approvals' => [
                    'count' => $pendingApprovals->count(),
                    'items' => StudentCourseResource::collection($pendingApprovals),
                ],
                'popular_courses' => $popularCourses,
                'enrollment_trends' => $enrollmentTrends,
                'recent_activities' => $recentActivities,
            ],
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }

    /**
     * Get KRS statistics for current period
     */
    private function getKRSStatistics($academicYear, $semester): array
    {
        $totalKRS = StudentCourse::where('academic_year', $academicYear)
            ->where('semester', $semester)
            ->count();

        $statusCounts = StudentCourse::where('academic_year', $academicYear)
            ->where('semester', $semester)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $totalCredits = StudentCourse::join('courses', 'student_courses.course_id', '=', 'courses.id')
            ->where('student_courses.academic_year', $academicYear)
            ->where('student_courses.semester', $semester)
            ->where('student_courses.status', 'approved')
            ->sum('courses.credits');

        $studentsWithKRS = StudentCourse::where('academic_year', $academicYear)
            ->where('semester', $semester)
            ->distinct('student_id')
            ->count();

        return [
            'total_krs_submissions' => $totalKRS,
            'status_breakdown' => [
                'pending' => $statusCounts['pending'] ?? 0,
                'approved' => $statusCounts['approved'] ?? 0,
                'rejected' => $statusCounts['rejected'] ?? 0,
            ],
            'total_approved_credits' => $totalCredits,
            'students_with_krs' => $studentsWithKRS,
            'completion_rate' => $totalKRS > 0 ? round((($statusCounts['approved'] ?? 0) / $totalKRS) * 100, 2) : 0,
        ];
    }

    /**
     * Get popular courses for current period
     */
    private function getPopularCourses($academicYear, $semester): array
    {
        return Course::withCount(['studentCourses as enrollment_count' => function ($query) use ($academicYear, $semester) {
                $query->where('academic_year', $academicYear)
                      ->where('semester', $semester)
                      ->where('status', 'approved');
            }])
            ->having('enrollment_count', '>', 0)
            ->orderBy('enrollment_count', 'desc')
            ->take(10)
            ->get()
            ->map(function ($course) {
                return [
                    'course_code' => $course->code,
                    'course_name' => $course->name,
                    'lecturer' => $course->lecturer,
                    'credits' => $course->credits,
                    'quota' => $course->quota,
                    'enrollment_count' => $course->enrollment_count,
                    'utilization_rate' => round(($course->enrollment_count / $course->quota) * 100, 2),
                ];
            })
            ->toArray();
    }

    /**
     * Get enrollment trends over time
     */
    private function getEnrollmentTrends(): array
    {
        $trends = StudentCourse::select(
                'academic_year',
                'semester',
                DB::raw('count(*) as total_enrollments'),
                DB::raw('count(case when status = "approved" then 1 end) as approved_enrollments')
            )
            ->groupBy('academic_year', 'semester')
            ->orderBy('academic_year', 'desc')
            ->orderBy('semester', 'desc')
            ->take(6)
            ->get()
            ->map(function ($trend) {
                return [
                    'period' => $trend->academic_year . ' - ' . $trend->semester,
                    'total_enrollments' => $trend->total_enrollments,
                    'approved_enrollments' => $trend->approved_enrollments,
                    'approval_rate' => $trend->total_enrollments > 0 
                        ? round(($trend->approved_enrollments / $trend->total_enrollments) * 100, 2) 
                        : 0,
                ];
            })
            ->reverse()
            ->values()
            ->toArray();

        return $trends;
    }

    /**
     * Get recent activities
     */
    private function getRecentActivities(): array
    {
        $recentKRS = StudentCourse::with(['student', 'course'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($krs) {
                return [
                    'type' => 'krs_submission',
                    'description' => "Student {$krs->student->name} submitted KRS for {$krs->course->name}",
                    'status' => $krs->status,
                    'timestamp' => $krs->created_at,
                ];
            });

        $recentStatusChanges = StudentCourse::with(['student', 'course'])
            ->where('updated_at', '>', now()->subDays(7))
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($krs) {
                return [
                    'type' => 'status_change',
                    'description' => "KRS for {$krs->student->name} - {$krs->course->name} was {$krs->status}",
                    'status' => $krs->status,
                    'timestamp' => $krs->updated_at,
                ];
            });

        return $recentKRS->concat($recentStatusChanges)
            ->sortByDesc('timestamp')
            ->take(15)
            ->values()
            ->toArray();
    }

    /**
     * Get students requiring attention (many pending KRS, etc.)
     */
    public function studentsRequiringAttention(Request $request): JsonResponse
    {
        $admin = $request->user();
        
        if (!$admin instanceof Admin) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Admin authentication required.',
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

        // Students with many pending KRS
        $studentsWithPendingKRS = Student::withCount(['studentCourses as pending_count' => function ($query) use ($academicYear, $currentSemester) {
                $query->where('academic_year', $academicYear)
                      ->where('semester', $currentSemester)
                      ->where('status', 'pending');
            }])
            ->having('pending_count', '>', 0)
            ->orderBy('pending_count', 'desc')
            ->take(20)
            ->get();

        // Students with no KRS submissions
        $studentsWithoutKRS = Student::whereDoesntHave('studentCourses', function ($query) use ($academicYear, $currentSemester) {
                $query->where('academic_year', $academicYear)
                      ->where('semester', $currentSemester);
            })
            ->take(20)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Students requiring attention retrieved successfully',
            'data' => [
                'students_with_pending_krs' => StudentResource::collection($studentsWithPendingKRS),
                'students_without_krs' => StudentResource::collection($studentsWithoutKRS),
                'current_period' => [
                    'academic_year' => $academicYear,
                    'semester' => $currentSemester,
                ],
            ],
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }
}