<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Notice;
use App\Models\BookIssue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            abort(404, 'Student profile not found');
        }

        // Get student statistics
        $stats = [
            'total_courses' => $student->enrollments()->count(),
            'enrolled_courses' => $student->enrollments()->where('status', 'enrolled')->count(),
            'completed_courses' => $student->enrollments()->where('status', 'completed')->count(),
            'issued_books' => $student->bookIssues()->where('status', 'issued')->count(),
            'overdue_books' => $student->bookIssues()->where('status', 'overdue')->count(),
        ];

        // Get enrolled courses
        $courses = $student->courses()
            ->where('enrollments.status', 'enrolled')
            ->with('teacher.user')
            ->get();

        // Get upcoming exams
        $upcomingExams = Exam::whereHas('course', function($query) use ($student) {
            $query->whereHas('enrollments', function($subQuery) use ($student) {
                $subQuery->where('student_id', $student->id)
                         ->where('status', 'enrolled');
            });
        })
        ->where('exam_date', '>=', now())
        ->orderBy('exam_date')
        ->limit(5)
        ->get();

        // Get recent notices
        $recentNotices = Notice::where('is_published', true)
            ->where(function($query) {
                $query->whereNull('target_role')
                      ->orWhere('target_role', 'all')
                      ->orWhere('target_role', 'student');
            })
            ->where(function($query) {
                $query->whereNull('expiry_date')
                      ->orWhere('expiry_date', '>=', now());
            })
            ->latest()
            ->limit(5)
            ->get();

        // Get recent book issues
        $recentBookIssues = $student->bookIssues()
            ->with('book')
            ->latest()
            ->limit(5)
            ->get();

        return view('student.dashboard', compact(
            'student',
            'stats',
            'courses',
            'upcomingExams',
            'recentNotices',
            'recentBookIssues'
        ));
    }
}
