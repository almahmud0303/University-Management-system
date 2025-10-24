<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            abort(404, 'Student profile not found');
        }

        $query = Exam::whereHas('course', function($q) use ($student) {
            $q->whereHas('enrollments', function($subQ) use ($student) {
                $subQ->where('student_id', $student->id)
                     ->where('status', 'enrolled');
            });
        })->with('course');

        // Filter by status
        if ($request->has('status') && $request->status) {
            switch ($request->status) {
                case 'upcoming':
                    $query->where('exam_date', '>', now());
                    break;
                case 'completed':
                    $query->where('exam_date', '<', now());
                    break;
                case 'today':
                    $query->whereDate('exam_date', today());
                    break;
            }
        }

        $exams = $query->orderBy('exam_date')->paginate(15);

        return view('student.exams.index', compact('exams', 'student'));
    }

    public function show(Exam $exam)
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            abort(404, 'Student profile not found');
        }

        // Check if student is enrolled in the course
        $enrollment = $student->enrollments()
            ->where('course_id', $exam->course_id)
            ->first();

        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course.');
        }

        $exam->load('course.teacher.user');

        // Get result if available
        $result = Result::where('exam_id', $exam->id)
            ->where('student_id', $student->id)
            ->first();

        return view('student.exams.show', compact('exam', 'result', 'student'));
    }
}
