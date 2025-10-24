<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(Request $request)
    {
        $query = Student::with(['user', 'department']);
        
        // Apply search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('student_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        // Apply department filter
        if ($request->has('department_id') && $request->department_id) {
            $query->where('department_id', $request->department_id);
        }
        
        // Apply academic year filter
        if ($request->has('academic_year') && $request->academic_year) {
            $query->where('academic_year', $request->academic_year);
        }
        
        // Apply semester filter
        if ($request->has('semester') && $request->semester) {
            $query->where('semester', $request->semester);
        }
        
        $students = $query->latest()->paginate(20);
        
        $departments = \App\Models\Department::all();
        $academicYears = Student::distinct()->pluck('academic_year');
        $semesters = Student::distinct()->pluck('semester');
        
        return view('staff.students.index', compact('students', 'departments', 'academicYears', 'semesters'));
    }
    
    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        $student->load([
            'user', 
            'department', 
            'courses.teacher.user',
            'bookIssues.book',
            'fees',
            'results.exam.course'
        ]);
        
        // Get statistics
        $stats = [
            'enrolled_courses' => $student->courses->count(),
            'borrowed_books' => $student->bookIssues->where('status', 'issued')->count(),
            'overdue_books' => $student->bookIssues->where('status', 'overdue')->count(),
            'total_fees' => $student->fees->count(),
            'paid_fees' => $student->fees->where('is_paid', true)->count(),
            'pending_fees' => $student->fees->where('is_paid', false)->count(),
            'total_results' => $student->results->count(),
            'published_results' => $student->results->where('is_published', true)->count(),
        ];
        
        return view('staff.students.show', compact('student', 'stats'));
    }
}