<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            abort(404, 'Student profile not found');
        }

        $query = Result::where('student_id', $student->id)
            ->where('is_published', true)
            ->with(['exam.course', 'exam.teacher.user']);

        // Filter by course
        if ($request->has('course_id') && $request->course_id) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('course_id', $request->course_id);
            });
        }

        // Filter by semester
        if ($request->has('semester') && $request->semester) {
            $query->whereHas('exam.course', function($q) use ($request) {
                $q->where('semester', $request->semester);
            });
        }

        $results = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get GPA calculation
        $gpaData = $this->calculateGPA($student);

        return view('student.results.index', compact('results', 'gpaData', 'student'));
    }

    public function show(Result $result)
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            abort(404, 'Student profile not found');
        }

        // Check if result belongs to this student
        if ($result->student_id !== $student->id) {
            abort(403, 'Unauthorized access to result.');
        }

        $result->load(['exam.course.teacher.user']);

        return view('student.results.show', compact('result', 'student'));
    }

    private function calculateGPA($student)
    {
        $results = Result::where('student_id', $student->id)
            ->where('is_published', true)
            ->with('exam.course')
            ->get();

        if ($results->isEmpty()) {
            return [
                'total_credits' => 0,
                'total_grade_points' => 0,
                'gpa' => 0,
                'semester_gpa' => []
            ];
        }

        $totalCredits = 0;
        $totalGradePoints = 0;
        $semesterData = [];

        foreach ($results as $result) {
            $credits = $result->exam->course->credits;
            $gradePoints = $result->grade_point * $credits;

            $totalCredits += $credits;
            $totalGradePoints += $gradePoints;

            $semester = $result->exam->course->semester;
            if (!isset($semesterData[$semester])) {
                $semesterData[$semester] = [
                    'credits' => 0,
                    'grade_points' => 0,
                    'courses' => 0
                ];
            }

            $semesterData[$semester]['credits'] += $credits;
            $semesterData[$semester]['grade_points'] += $gradePoints;
            $semesterData[$semester]['courses']++;
        }

        $gpa = $totalCredits > 0 ? $totalGradePoints / $totalCredits : 0;

        // Calculate semester-wise GPA
        $semesterGPA = [];
        foreach ($semesterData as $semester => $data) {
            $semesterGPA[$semester] = $data['credits'] > 0 ? $data['grade_points'] / $data['credits'] : 0;
        }

        return [
            'total_credits' => $totalCredits,
            'total_grade_points' => $totalGradePoints,
            'gpa' => round($gpa, 2),
            'semester_gpa' => $semesterGPA
        ];
    }
}
