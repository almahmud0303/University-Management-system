<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Department, Teacher, Student, Staff, Course, Notice};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate statistics
        $stats = [
            'total_students' => Student::count(),
            'active_students' => Student::where('is_active', true)->count(),
            'total_teachers' => Teacher::count(),
            'active_teachers' => Teacher::where('is_active', true)->count(),
            'total_staff' => Staff::count(),
            'total_courses' => Course::count(),
            'active_courses' => Course::where('is_active', true)->count(),
            // 'total_departments' => Department::count(),
        ];

        // Recent records
        $recentStudents = Student::with('user', 'department')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentNotices = Notice::with('postedByUser')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentStudents', 'recentNotices'));
    }
}