<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Department;
use App\Models\Teacher;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['department', 'teacher.user'])
            ->latest()
            ->paginate(15);

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        $teachers = Teacher::where('is_active', true)->get();
        
        return view('admin.courses.create', compact('departments', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_code' => 'required|string|max:255|unique:courses',
            'description' => 'nullable|string',
            'credits' => 'required|numeric|min:0.5|max:6',
            'department_id' => 'required|exists:departments,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'academic_year' => 'required|string|max:10',
            'semester' => 'required|string|max:10',
            'max_students' => 'required|integer|min:1|max:200',
            'course_type' => 'required|in:theory,lab,project,thesis',
            'currency' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        Course::create([
            'title' => $request->title,
            'course_code' => $request->course_code,
            'description' => $request->description,
            'credits' => $request->credits,
            'department_id' => $request->department_id,
            'teacher_id' => $request->teacher_id,
            'academic_year' => $request->academic_year,
            'semester' => $request->semester,
            'max_students' => $request->max_students,
            'course_type' => $request->course_type,
            'currency' => $request->currency ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $course->load(['department', 'teacher.user', 'enrollments.student.user']);
        
        $stats = [
            'total_enrollments' => $course->enrollments()->count(),
            'active_enrollments' => $course->enrollments()->where('status', 'enrolled')->count(),
            'completed_enrollments' => $course->enrollments()->where('status', 'completed')->count(),
            'total_exams' => $course->exams()->count(),
        ];

        $recentEnrollments = $course->enrollments()
            ->with('student.user')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.courses.show', compact('course', 'stats', 'recentEnrollments'));
    }

    public function edit(Course $course)
    {
        $departments = Department::where('is_active', true)->get();
        $teachers = Teacher::where('is_active', true)->get();
        
        return view('admin.courses.edit', compact('course', 'departments', 'teachers'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_code' => 'required|string|max:255|unique:courses,course_code,' . $course->id,
            'description' => 'nullable|string',
            'credits' => 'required|numeric|min:0.5|max:6',
            'department_id' => 'required|exists:departments,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'academic_year' => 'required|string|max:10',
            'semester' => 'required|string|max:10',
            'max_students' => 'required|integer|min:1|max:200',
            'course_type' => 'required|in:theory,lab,project,thesis',
            'currency' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $course->update([
            'title' => $request->title,
            'course_code' => $request->course_code,
            'description' => $request->description,
            'credits' => $request->credits,
            'department_id' => $request->department_id,
            'teacher_id' => $request->teacher_id,
            'academic_year' => $request->academic_year,
            'semester' => $request->semester,
            'max_students' => $request->max_students,
            'course_type' => $request->course_type,
            'currency' => $request->currency ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}