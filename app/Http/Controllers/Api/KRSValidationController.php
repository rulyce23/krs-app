<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Course;
use App\Models\StudentCourse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class KRSValidationController extends Controller
{
    /**
     * Validate schedule conflicts
     */
    public function validateScheduleConflict(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'academic_year' => 'required|string',
            'semester' => 'required|string',
        ]);

        $student = Student::findOrFail($validated['student_id']);
        $newCourse = Course::findOrFail($validated['course_id']);

        // Get student's approved courses for the same period
        $existingCourses = $student->studentCourses()
            ->with('course')
            ->where('academic_year', $validated['academic_year'])
            ->where('semester', $validated['semester'])
            ->where('status', 'approved')
            ->get();

        $conflicts = [];

        foreach ($existingCourses as $studentCourse) {
            $existingCourse = $studentCourse->course;
            
            // Check if courses are on the same day
            if ($existingCourse->day === $newCourse->day) {
                // Check time overlap
                $existingStart = Carbon::createFromFormat('H:i:s', $existingCourse->start_time);
                $existingEnd = Carbon::createFromFormat('H:i:s', $existingCourse->end_time);
                $newStart = Carbon::createFromFormat('H:i:s', $newCourse->start_time);
                $newEnd = Carbon::createFromFormat('H:i:s', $newCourse->end_time);

                // Check for time overlap
                if (($newStart < $existingEnd) && ($newEnd > $existingStart)) {
                    $conflicts[] = [
                        'conflicting_course' => [
                            'id' => $existingCourse->id,
                            'code' => $existingCourse->code,
                            'name' => $existingCourse->name,
                            'day' => $existingCourse->day,
                            'start_time' => $existingCourse->start_time,
                            'end_time' => $existingCourse->end_time,
                            'room' => $existingCourse->room,
                        ],
                        'overlap_details' => [
                            'overlap_start' => max($newStart, $existingStart)->format('H:i:s'),
                            'overlap_end' => min($newEnd, $existingEnd)->format('H:i:s'),
                        ]
                    ];
                }
            }
        }

        $hasConflict = count($conflicts) > 0;

        return response()->json([
            'success' => true,
            'message' => $hasConflict ? 'Schedule conflicts detected' : 'No schedule conflicts found',
            'data' => [
                'has_conflict' => $hasConflict,
                'new_course' => [
                    'id' => $newCourse->id,
                    'code' => $newCourse->code,
                    'name' => $newCourse->name,
                    'day' => $newCourse->day,
                    'start_time' => $newCourse->start_time,
                    'end_time' => $newCourse->end_time,
                    'room' => $newCourse->room,
                ],
                'conflicts' => $conflicts,
                'conflict_count' => count($conflicts),
            ],
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }

    /**
     * Validate credit limit
     */
    public function validateCreditLimit(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'academic_year' => 'required|string',
            'semester' => 'required|string',
            'max_credits' => 'nullable|integer|min:1|max:30', // Default will be set based on student semester
        ]);

        $student = Student::findOrFail($validated['student_id']);
        $newCourse = Course::findOrFail($validated['course_id']);

        // Determine max credits based on student semester if not provided
        $maxCredits = $validated['max_credits'] ?? $this->getMaxCreditsForSemester($student->semester);

        // Get current approved credits for the period
        $currentCredits = $student->studentCourses()
            ->join('courses', 'student_courses.course_id', '=', 'courses.id')
            ->where('student_courses.academic_year', $validated['academic_year'])
            ->where('student_courses.semester', $validated['semester'])
            ->where('student_courses.status', 'approved')
            ->sum('courses.credits');

        $totalCreditsAfterAdding = $currentCredits + $newCourse->credits;
        $exceedsLimit = $totalCreditsAfterAdding > $maxCredits;

        return response()->json([
            'success' => true,
            'message' => $exceedsLimit ? 'Credit limit exceeded' : 'Credit limit validation passed',
            'data' => [
                'exceeds_limit' => $exceedsLimit,
                'current_credits' => $currentCredits,
                'new_course_credits' => $newCourse->credits,
                'total_credits_after_adding' => $totalCreditsAfterAdding,
                'max_allowed_credits' => $maxCredits,
                'remaining_credits' => max(0, $maxCredits - $currentCredits),
                'excess_credits' => $exceedsLimit ? $totalCreditsAfterAdding - $maxCredits : 0,
            ],
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }

    /**
     * Validate course prerequisites
     */
    public function validatePrerequisites(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $student = Student::findOrFail($validated['student_id']);
        $course = Course::findOrFail($validated['course_id']);

        // For now, we'll implement a basic prerequisite system
        // In a real system, you might have a separate prerequisites table
        $prerequisites = $this->getCoursePrerequisites($course);
        
        $missingPrerequisites = [];
        $completedPrerequisites = [];

        foreach ($prerequisites as $prerequisite) {
            $hasCompleted = $student->studentCourses()
                ->join('courses', 'student_courses.course_id', '=', 'courses.id')
                ->where('courses.code', $prerequisite['code'])
                ->where('student_courses.status', 'approved')
                ->exists();

            if ($hasCompleted) {
                $completedPrerequisites[] = $prerequisite;
            } else {
                $missingPrerequisites[] = $prerequisite;
            }
        }

        $hasAllPrerequisites = count($missingPrerequisites) === 0;

        return response()->json([
            'success' => true,
            'message' => $hasAllPrerequisites ? 'All prerequisites met' : 'Missing prerequisites',
            'data' => [
                'has_all_prerequisites' => $hasAllPrerequisites,
                'course' => [
                    'id' => $course->id,
                    'code' => $course->code,
                    'name' => $course->name,
                ],
                'prerequisites' => [
                    'total_required' => count($prerequisites),
                    'completed' => $completedPrerequisites,
                    'missing' => $missingPrerequisites,
                    'completed_count' => count($completedPrerequisites),
                    'missing_count' => count($missingPrerequisites),
                ],
            ],
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }

    /**
     * Validate course quota availability
     */
    public function validateQuotaAvailability(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'academic_year' => 'required|string',
            'semester' => 'required|string',
        ]);

        $course = Course::findOrFail($validated['course_id']);

        // Count current approved enrollments
        $currentEnrollments = StudentCourse::where('course_id', $course->id)
            ->where('academic_year', $validated['academic_year'])
            ->where('semester', $validated['semester'])
            ->where('status', 'approved')
            ->count();

        $availableSlots = $course->quota - $currentEnrollments;
        $isAvailable = $availableSlots > 0;

        return response()->json([
            'success' => true,
            'message' => $isAvailable ? 'Quota available' : 'Course is full',
            'data' => [
                'is_available' => $isAvailable,
                'course' => [
                    'id' => $course->id,
                    'code' => $course->code,
                    'name' => $course->name,
                ],
                'quota_info' => [
                    'total_quota' => $course->quota,
                    'current_enrollments' => $currentEnrollments,
                    'available_slots' => $availableSlots,
                    'utilization_rate' => round(($currentEnrollments / $course->quota) * 100, 2),
                ],
            ],
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }

    /**
     * Comprehensive KRS validation
     */
    public function validateKRS(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'academic_year' => 'required|string',
            'semester' => 'required|string',
            'max_credits' => 'nullable|integer|min:1|max:30',
        ]);

        $validationResults = [];

        // 1. Schedule conflict validation
        $scheduleValidation = $this->validateScheduleConflict($request);
        $scheduleData = $scheduleValidation->getData(true);
        $validationResults['schedule_conflict'] = $scheduleData['data'];

        // 2. Credit limit validation
        $creditValidation = $this->validateCreditLimit($request);
        $creditData = $creditValidation->getData(true);
        $validationResults['credit_limit'] = $creditData['data'];

        // 3. Prerequisites validation
        $prerequisiteValidation = $this->validatePrerequisites($request);
        $prerequisiteData = $prerequisiteValidation->getData(true);
        $validationResults['prerequisites'] = $prerequisiteData['data'];

        // 4. Quota availability validation
        $quotaValidation = $this->validateQuotaAvailability($request);
        $quotaData = $quotaValidation->getData(true);
        $validationResults['quota_availability'] = $quotaData['data'];

        // Overall validation result
        $canEnroll = !$validationResults['schedule_conflict']['has_conflict'] &&
                    !$validationResults['credit_limit']['exceeds_limit'] &&
                    $validationResults['prerequisites']['has_all_prerequisites'] &&
                    $validationResults['quota_availability']['is_available'];

        $issues = [];
        if ($validationResults['schedule_conflict']['has_conflict']) {
            $issues[] = 'Schedule conflict detected';
        }
        if ($validationResults['credit_limit']['exceeds_limit']) {
            $issues[] = 'Credit limit exceeded';
        }
        if (!$validationResults['prerequisites']['has_all_prerequisites']) {
            $issues[] = 'Missing prerequisites';
        }
        if (!$validationResults['quota_availability']['is_available']) {
            $issues[] = 'Course quota full';
        }

        return response()->json([
            'success' => true,
            'message' => $canEnroll ? 'KRS validation passed' : 'KRS validation failed',
            'data' => [
                'can_enroll' => $canEnroll,
                'validation_summary' => [
                    'total_issues' => count($issues),
                    'issues' => $issues,
                ],
                'detailed_validations' => $validationResults,
            ],
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }

    /**
     * Get maximum credits allowed for a semester
     */
    private function getMaxCreditsForSemester(string $semester): int
    {
        // Basic logic - can be customized based on university rules
        $semesterNumber = (int) $semester;
        
        if ($semesterNumber <= 2) {
            return 20; // First year students
        } elseif ($semesterNumber <= 4) {
            return 22; // Second year students
        } else {
            return 24; // Senior students
        }
    }

    /**
     * Get course prerequisites (mock implementation)
     */
    private function getCoursePrerequisites(Course $course): array
    {
        // This is a mock implementation
        // In a real system, you would have a prerequisites table or field
        $prerequisites = [];

        // Example prerequisite rules based on course code patterns
        if (str_contains($course->code, '2')) {
            $prerequisites[] = [
                'code' => str_replace('2', '1', $course->code),
                'name' => 'Prerequisite for ' . $course->name,
            ];
        }

        return $prerequisites;
    }
}