<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\StudentCourse;

class KRSController extends Controller
{
    public function index()
    {
        $user = Auth::guard('student')->user();
        $krs = $user->studentCourses()
            ->with('course')
            ->where('academic_year', '2024/2025')
            ->where('semester', 'Ganjil')
            ->get();
        $totalSks = $krs->sum(fn($item) => $item->course->credits);
        return view('krs.index', [
            'selectedCourses' => $krs,
            'totalCredits' => $totalSks,
        ]);
    }

    public function selectCourse(Request $request)
    {
        $request->validate(['course_id' => 'required|exists:courses,id']);
        $user = Auth::guard('student')->user();
        $course = Course::findOrFail($request->course_id);
        
        // Validate semester eligibility
        $studentSemester = (int) $user->semester;
        $courseSemester = (int) $course->semester;
        
        // Validasi untuk semester yang belum diduduki
        if ($courseSemester > $studentSemester) {
            return back()->with('error', 'Anda belum dapat mengambil mata kuliah semester ' . $courseSemester . '. Semester Anda saat ini: ' . $studentSemester);
        }
        
        // Cek apakah mata kuliah sudah diambil sebelumnya
        $sudahAda = StudentCourse::where('student_id', $user->id)
            ->where('course_id', $course->id)
            ->where('academic_year', '2024/2025')
            ->where('semester', 'Ganjil')
            ->exists();
        if ($sudahAda) {
            return back()->with('error', 'Mata kuliah sudah dipilih.');
        }
        if ($this->cekBentrok($user, $course)) {
            return back()->with('error', 'Jadwal bentrok dengan mata kuliah lain.');
        }
        $sksSekarang = $user->studentCourses()
            ->with('course')
            ->where('academic_year', '2024/2025')
            ->where('semester', 'Ganjil')
            ->get()
            ->sum(fn($item) => $item->course->credits);
        if ($sksSekarang + $course->credits > 24) {
            return back()->with('error', 'SKS melebihi batas maksimal.');
        }
        if ($course->quota <= 0) {
            return back()->with('error', 'Kuota penuh.');
        }
        StudentCourse::create([
            'student_id' => $user->id,
            'course_id' => $course->id,
            'academic_year' => '2024/2025',
            'semester' => 'Ganjil',
            'status' => 'pending',
        ]);
        $course->decrement('quota');
        return back()->with('success', 'Mata kuliah berhasil dipilih.');
    }

    public function removeCourse(Request $request)
    {
        $request->validate(['course_id' => 'required|exists:courses,id']);
        $user = Auth::guard('student')->user();
        $studentCourse = StudentCourse::where('student_id', $user->id)
            ->where('course_id', $request->course_id)
            ->where('academic_year', '2024/2025')
            ->where('semester', 'Ganjil')
            ->first();
        if ($studentCourse) {
            $course = Course::find($request->course_id);
            $course->increment('quota');
            $studentCourse->delete();
            return back()->with('success', 'Mata kuliah dihapus dari KRS.');
        }
        return back()->with('error', 'Mata kuliah tidak ditemukan di KRS.');
    }

    public function editKRS($id)
    {
        $user = Auth::guard('student')->user();
        $studentCourse = StudentCourse::where('id', $id)
            ->where('student_id', $user->id)
            ->with('course')
            ->firstOrFail();
        return view('krs.edit', ['studentCourse' => $studentCourse]);
    }

    public function updateKRS(Request $request, $id)
    {
        $request->validate(['notes' => 'nullable|string|max:500']);
        $user = Auth::guard('student')->user();
        $studentCourse = StudentCourse::where('id', $id)
            ->where('student_id', $user->id)
            ->firstOrFail();
        $studentCourse->update(['notes' => $request->notes]);
        return redirect()->route('student.krs')->with('success', 'KRS diperbarui.');
    }

    public function deleteKRS($id)
    {
        $user = Auth::guard('student')->user();
        $studentCourse = StudentCourse::where('id', $id)
            ->where('student_id', $user->id)
            ->firstOrFail();
        $studentCourse->delete();
        $course = Course::find($studentCourse->course_id);
        $course->increment('quota');
        return redirect()->route('student.krs')->with('success', 'KRS dihapus.');
    }

    private function cekBentrok($student, $newCourse)
    {
        $selected = $student->studentCourses()
            ->with('course')
            ->where('academic_year', '2024/2025')
            ->where('semester', 'Ganjil')
            ->get();
        foreach ($selected as $item) {
            if ($item->course->day === $newCourse->day) {
                $start1 = strtotime($item->course->start_time);
                $end1 = strtotime($item->course->end_time);
                $start2 = strtotime($newCourse->start_time);
                $end2 = strtotime($newCourse->end_time);
                if ($start2 < $end1 && $end2 > $start1) {
                    return true;
                }
            }
        }
        return false;
    }
}
