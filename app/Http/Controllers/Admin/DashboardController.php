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
        
        // Get statistics
        $stats = [
            'total_users' => User::count(),
            'total_students' => Student::count(),
            'total_teachers' => Teacher::count(),
            'total_staff' => Staff::count(),
            'total_departments' => Department::count(),
            'total_courses' => Course::count(),
            'total_halls' => Hall::count(),
            'active_courses' => Course::where('is_active', true)->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
        ];

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
            ->where('status', 'scheduled')
            ->orderBy('exam_date')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentStudents',
            'recentTeachers',
            'recentNotices',
            'upcomingExams'
        ));
    }
}