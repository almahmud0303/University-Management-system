<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        $courses = Course::where('teacher_id', $teacher->id)
            ->with(['department', 'enrollments'])
            ->withCount(['enrollments' => function($query) {
                $query->where('status', 'enrolled');
            }])
            ->latest()
            ->paginate(10);

        return view('teacher.courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $teacher = Auth::user()->teacher;
        
        // Ensure teacher can only view their own courses
        if ($course->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to course.');
        }

        $course->load(['department', 'enrollments.student.user', 'exams']);
        
        $students = $course->enrollments()
            ->with('student.user')
            ->where('status', 'enrolled')
            ->get()
            ->pluck('student');

        $stats = [
            'total_enrollments' => $course->enrollments()->count(),
            'active_enrollments' => $course->enrollments()->where('status', 'enrolled')->count(),
            'completed_enrollments' => $course->enrollments()->where('status', 'completed')->count(),
            'total_exams' => $course->exams()->count(),
            'upcoming_exams' => $course->exams()
                ->where('exam_date', '>=', now())
                ->count(),
        ];

        $recentExams = $course->exams()
            ->latest()
            ->limit(5)
            ->get();

        return view('teacher.courses.show', compact('course', 'students', 'stats', 'recentExams'));
    }

    public function students(Course $course)
    {
        $teacher = Auth::user()->teacher;
        
        // Ensure teacher can only view their own courses
        if ($course->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to course.');
        }

        $students = $course->enrollments()
            ->with('student.user')
            ->where('status', 'enrolled')
            ->paginate(20);

        return view('teacher.courses.students', compact('course', 'students'));
    }

    public function enrollStudent(Request $request, Course $course)
    {
        $teacher = Auth::user()->teacher;
        
        // Ensure teacher can only manage their own courses
        if ($course->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to course.');
        }

        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $student = Student::find($request->student_id);

        // Check if student is already enrolled
        if ($course->enrollments()->where('student_id', $student->id)->exists()) {
            return redirect()->back()
                ->with('error', 'Student is already enrolled in this course.');
        }

        // Check if course has available slots
        if ($course->enrollments()->where('status', 'enrolled')->count() >= $course->max_students) {
            return redirect()->back()
                ->with('error', 'Course is at full capacity.');
        }

        Enrollment::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'status' => 'enrolled',
            'enrollment_date' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Student enrolled successfully.');
    }

    public function removeStudent(Course $course, Student $student)
    {
        $teacher = Auth::user()->teacher;
        
        // Ensure teacher can only manage their own courses
        if ($course->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to course.');
        }

        $enrollment = $course->enrollments()->where('student_id', $student->id)->first();
        
        if ($enrollment) {
            $enrollment->update(['status' => 'dropped']);
            return redirect()->back()
                ->with('success', 'Student removed from course successfully.');
        }

        return redirect()->back()
            ->with('error', 'Student not found in this course.');
    }
}
