<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\Result;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        // Get teacher's courses with statistics
        $courses = Course::where('teacher_id', $teacher->id)
            ->where('is_active', true)
            ->with(['department', 'enrollments'])
            ->get();

        $courseStats = $courses->map(function ($course) {
            return [
                'course' => $course,
                'enrolled_count' => $course->enrollments()->where('status', 'enrolled')->count(),
                'total_exams' => $course->exams()->count(),
                'pending_results' => $course->exams()
                    ->whereHas('results', function($q) {
                        $q->where('is_published', false);
                    })
                    ->count(),
            ];
        });

        // Get upcoming exams
        $upcomingExams = Exam::whereHas('course', function($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })
            ->where('exam_date', '>=', now())
            ->orderBy('exam_date')
            ->with('course')
            ->limit(5)
            ->get();

        // Get unpublished results
        $unpublishedResults = Result::whereHas('exam.course', function($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })
            ->where('is_published', false)
            ->with(['exam.course', 'student.user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get recent notices
        $recentNotices = Notice::where('is_published', true)
            ->where(function($query) {
                $query->whereJsonContains('target_roles', 'teacher')
                      ->orWhereJsonContains('target_roles', 'all');
            })
            ->where('publish_date', '<=', now())
            ->where(function($query) {
                $query->whereNull('expiry_date')
                      ->orWhere('expiry_date', '>=', now());
            })
            ->with('user')
            ->latest()
            ->limit(5)
            ->get();

        // Dashboard statistics
        $stats = [
            'total_courses' => $courses->count(),
            'total_students' => $courses->sum(function($course) {
                return $course->enrollments()->where('status', 'enrolled')->count();
            }),
            'total_exams' => $courses->sum(function($course) {
                return $course->exams()->count();
            }),
            'pending_results' => $unpublishedResults->count(),
        ];

        return view('teacher.dashboard', compact(
            'teacher',
            'courseStats',
            'upcomingExams',
            'unpublishedResults',
            'recentNotices',
            'stats'
        ));
    }
}