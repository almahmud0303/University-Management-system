<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseEnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            abort(404, 'Student profile not found');
        }

        // Get available courses for enrollment
        $query = Course::with('teacher.user')
            ->where('department_id', $student->department_id)
            ->where('academic_year', $student->academic_year)
            ->where('semester', $student->semester)
            ->where('is_active', true)
            ->whereDoesntHave('enrollments', function($q) use ($student) {
                $q->where('student_id', $student->id);
            });

        // Filter by course type
        if ($request->has('course_type') && $request->course_type) {
            $query->where('course_type', $request->course_type);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('course_code', 'like', "%{$search}%");
            });
        }

        $availableCourses = $query->orderBy('course_code')->paginate(15);

        // Get enrolled courses
        $enrolledCourses = $student->courses()
            ->where('enrollments.status', 'enrolled')
            ->with('teacher.user')
            ->get();

        return view('student.course-enrollment.index', compact(
            'availableCourses',
            'enrolledCourses',
            'student'
        ));
    }

    public function enroll(Course $course)
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            abort(404, 'Student profile not found');
        }

        // Check if course is available for this student
        if ($course->department_id !== $student->department_id ||
            $course->academic_year !== $student->academic_year ||
            $course->semester !== $student->semester ||
            !$course->is_active) {
            return redirect()->back()->with('error', 'Course not available for enrollment.');
        }

        // Check if already enrolled
        $existingEnrollment = Enrollment::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->back()->with('error', 'Already enrolled in this course.');
        }

        // Check course capacity
        if ($course->current_enrollment_count >= $course->max_students) {
            return redirect()->back()->with('error', 'Course is full.');
        }

        // Enroll student
        Enrollment::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'enrollment_date' => now(),
            'status' => 'enrolled',
        ]);

        return redirect()->back()->with('success', 'Successfully enrolled in ' . $course->title);
    }

    public function drop(Course $course)
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            abort(404, 'Student profile not found');
        }

        $enrollment = Enrollment::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return redirect()->back()->with('error', 'Not enrolled in this course.');
        }

        // Check if it's a compulsory course
        if ($course->course_type === 'compulsory') {
            return redirect()->back()->with('error', 'Cannot drop compulsory course.');
        }

        $enrollment->update([
            'status' => 'dropped',
            'drop_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Successfully dropped ' . $course->title);
    }
}
