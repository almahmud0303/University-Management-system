<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            abort(404, 'Student profile not found');
        }

        $query = $student->courses()->with('teacher.user');

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('enrollments.status', $request->status);
        }

        // Filter by semester
        if ($request->has('semester') && $request->semester) {
            $query->where('courses.semester', $request->semester);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('courses.title', 'like', "%{$search}%")
                  ->orWhere('courses.course_code', 'like', "%{$search}%");
            });
        }

        $courses = $query->orderBy('courses.semester')
            ->orderBy('courses.course_code')
            ->paginate(15);

        return view('student.courses.index', compact('courses', 'student'));
    }

    public function show(Course $course)
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            abort(404, 'Student profile not found');
        }

        // Check if student is enrolled in this course
        $enrollment = $student->enrollments()
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course.');
        }

        $course->load(['teacher.user', 'assignments', 'exams']);

        // Get course statistics
        $stats = [
            'total_assignments' => $course->assignments()->count(),
            'submitted_assignments' => $course->assignments()
                ->whereHas('submissions', function($q) use ($student) {
                    $q->where('student_id', $student->id);
                })
                ->count(),
            'total_exams' => $course->exams()->count(),
            'completed_exams' => $course->exams()
                ->whereHas('results', function($q) use ($student) {
                    $q->where('student_id', $student->id);
                })
                ->count(),
        ];

        return view('student.courses.show', compact('course', 'enrollment', 'stats', 'student'));
    }
}
