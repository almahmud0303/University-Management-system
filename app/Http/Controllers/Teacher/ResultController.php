<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        $results = Result::whereHas('exam.course', function($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })
            ->with(['exam.course', 'student.user'])
            ->latest()
            ->paginate(20);

        return view('teacher.results.index', compact('results'));
    }

    public function publish(Result $result)
    {
        $teacher = Auth::user()->teacher;
        
        // Ensure teacher can only publish their own results
        if ($result->exam->course->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to result.');
        }

        $result->update(['is_published' => true]);

        return redirect()->back()
            ->with('success', 'Result published successfully.');
    }

    public function unpublish(Result $result)
    {
        $teacher = Auth::user()->teacher;
        
        // Ensure teacher can only unpublish their own results
        if ($result->exam->course->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to result.');
        }

        $result->update(['is_published' => false]);

        return redirect()->back()
            ->with('success', 'Result unpublished successfully.');
    }

    public function publishAll(Exam $exam)
    {
        $teacher = Auth::user()->teacher;
        
        // Ensure teacher can only publish results for their own exams
        if ($exam->course->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to exam.');
        }

        $exam->results()->update(['is_published' => true]);

        return redirect()->back()
            ->with('success', 'All results published successfully.');
    }

    public function edit(Result $result)
    {
        $teacher = Auth::user()->teacher;
        
        // Ensure teacher can only edit their own results
        if ($result->exam->course->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to result.');
        }

        $result->load(['exam', 'student.user']);

        return view('teacher.results.edit', compact('result'));
    }

    public function update(Request $request, Result $result)
    {
        $teacher = Auth::user()->teacher;
        
        // Ensure teacher can only edit their own results
        if ($result->exam->course->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to result.');
        }

        $request->validate([
            'marks_obtained' => 'required|integer|min:0|max:' . $result->exam->total_marks,
            'remarks' => 'nullable|string|max:255',
        ]);

        $grade = $this->calculateGrade($request->marks_obtained, $result->exam->total_marks);
        $gradePoint = $this->calculateGradePoint($grade);

        $result->update([
            'marks_obtained' => $request->marks_obtained,
            'grade' => $grade,
            'grade_point' => $gradePoint,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('teacher.results.index')
            ->with('success', 'Result updated successfully.');
    }

    private function calculateGrade($marksObtained, $totalMarks)
    {
        $percentage = ($marksObtained / $totalMarks) * 100;

        if ($percentage >= 80) return 'A+';
        if ($percentage >= 75) return 'A';
        if ($percentage >= 70) return 'A-';
        if ($percentage >= 65) return 'B+';
        if ($percentage >= 60) return 'B';
        if ($percentage >= 55) return 'B-';
        if ($percentage >= 50) return 'C+';
        if ($percentage >= 45) return 'C';
        if ($percentage >= 40) return 'D';
        return 'F';
    }

    private function calculateGradePoint($grade)
    {
        return match($grade) {
            'A+' => 4.00,
            'A' => 3.75,
            'A-' => 3.50,
            'B+' => 3.25,
            'B' => 3.00,
            'B-' => 2.75,
            'C+' => 2.50,
            'C' => 2.25,
            'D' => 2.00,
            'F' => 0.00,
            default => 0.00
        };
    }
}