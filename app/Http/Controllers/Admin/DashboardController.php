<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Staff;
use App\Models\Hall;
use App\Models\Notice;
use App\Models\Exam;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get statistics for dashboard cards
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalDepartments = Department::count();
        $totalCourses = Course::count();
        $totalHalls = Hall::count();

        // Get recent activities
        $recentStudents = Student::with('user', 'department')
            ->latest()
            ->limit(5)
            ->get();

        $recentTeachers = Teacher::with('user', 'department')
            ->latest()
            ->limit(5)
            ->get();

        $recentNotices = Notice::with('user')
            ->latest()
            ->limit(5)
            ->get();

        $upcomingExams = Exam::with('course')
            ->where('exam_date', '>=', now())
            ->orderBy('exam_date')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalDepartments',
            'totalCourses',
            'totalHalls',
            'recentStudents',
            'recentTeachers',
            'recentNotices',
            'upcomingExams'
        ));
    }

    public function analytics()
    {
        // Get comprehensive analytics data
        $analytics = [
            'students' => [
                'total' => Student::count(),
                'active' => Student::where('is_active', true)->count(),
                'by_year' => Student::selectRaw('academic_year, count(*) as count')
                    ->groupBy('academic_year')
                    ->get(),
                'by_department' => Student::with('department')
                    ->selectRaw('department_id, count(*) as count')
                    ->groupBy('department_id')
                    ->get(),
            ],
            'teachers' => [
                'total' => Teacher::count(),
                'active' => Teacher::where('is_active', true)->count(),
                'by_department' => Teacher::with('department')
                    ->selectRaw('department_id, count(*) as count')
                    ->groupBy('department_id')
                    ->get(),
            ],
            'courses' => [
                'total' => Course::count(),
                'active' => Course::where('is_active', true)->count(),
                'by_department' => Course::with('department')
                    ->selectRaw('department_id, count(*) as count')
                    ->groupBy('department_id')
                    ->get(),
            ],
            'exams' => [
                'total' => Exam::count(),
                'upcoming' => Exam::where('exam_date', '>=', now())->count(),
                'completed' => Exam::where('exam_date', '<', now())->count(),
            ],
            'notices' => [
                'total' => Notice::count(),
                'published' => Notice::where('is_published', true)->count(),
                'unpublished' => Notice::where('is_published', false)->count(),
            ],
        ];

        return view('admin.analytics', compact('analytics'));
    }
}