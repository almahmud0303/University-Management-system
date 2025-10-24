<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Result::with(['student.user', 'exam.course']);

        // Apply filters
        if ($request->has('course_id') && $request->course_id) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('course_id', $request->course_id);
            });
        }

        if ($request->has('exam_id') && $request->exam_id) {
            $query->where('exam_id', $request->exam_id);
        }

        if ($request->has('student_id') && $request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->has('is_published') && $request->is_published !== '') {
            $query->where('is_published', $request->is_published);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('student.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $results = $query->latest()->paginate(20);

        $courses = Course::where('is_active', true)->get();
        $exams = Exam::with('course')->latest()->get();
        $students = Student::with('user')->where('is_active', true)->get();

        return view('admin.results.index', compact('results', 'courses', 'exams', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $exams = Exam::with('course')->where('status', 'completed')->get();
        $students = Student::with('user')->where('is_active', true)->get();

        return view('admin.results.create', compact('exams', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'student_id' => 'required|exists:students,id',
            'marks' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        // Check if result already exists
        $existingResult = Result::where('exam_id', $request->exam_id)
            ->where('student_id', $request->student_id)
            ->first();

        if ($existingResult) {
            return back()->with('error', 'Result already exists for this student and exam.');
        }

        // Get exam details for grade calculation
        $exam = Exam::find($request->exam_id);
        $percentage = ($request->marks / $exam->total_marks) * 100;

        // Calculate grade and grade point
        $grade = $this->calculateGrade($percentage);
        $gradePoint = $this->calculateGradePoint($grade);

        Result::create([
            'exam_id' => $request->exam_id,
            'student_id' => $request->student_id,
            'marks' => $request->marks,
            'grade' => $grade,
            'grade_point' => $gradePoint,
            'remarks' => $request->remarks,
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('admin.results.index')
            ->with('success', 'Result created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Result $result)
    {
        $result->load(['student.user', 'exam.course.teacher.user']);

        return view('admin.results.show', compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Result $result)
    {
        $result->load(['student.user', 'exam.course']);
        $exams = Exam::with('course')->where('status', 'completed')->get();
        $students = Student::with('user')->where('is_active', true)->get();

        return view('admin.results.edit', compact('result', 'exams', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Result $result)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'student_id' => 'required|exists:students,id',
            'marks' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        // Check if result already exists for different result
        $existingResult = Result::where('exam_id', $request->exam_id)
            ->where('student_id', $request->student_id)
            ->where('id', '!=', $result->id)
            ->first();

        if ($existingResult) {
            return back()->with('error', 'Result already exists for this student and exam.');
        }

        // Get exam details for grade calculation
        $exam = Exam::find($request->exam_id);
        $percentage = ($request->marks / $exam->total_marks) * 100;

        // Calculate grade and grade point
        $grade = $this->calculateGrade($percentage);
        $gradePoint = $this->calculateGradePoint($grade);

        $result->update([
            'exam_id' => $request->exam_id,
            'student_id' => $request->student_id,
            'marks' => $request->marks,
            'grade' => $grade,
            'grade_point' => $gradePoint,
            'remarks' => $request->remarks,
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('admin.results.index')
            ->with('success', 'Result updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Result $result)
    {
        $result->delete();
        return redirect()->route('admin.results.index')
            ->with('success', 'Result deleted successfully.');
    }

    /**
     * Bulk create results for an exam
     */
    public function bulkCreate(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'results' => 'required|array',
            'results.*.student_id' => 'required|exists:students,id',
            'results.*.marks' => 'required|numeric|min:0',
            'results.*.remarks' => 'nullable|string|max:500',
        ]);

        $exam = Exam::find($request->exam_id);
        $createdCount = 0;

        DB::transaction(function() use ($request, $exam, &$createdCount) {
            foreach ($request->results as $resultData) {
                // Check if result already exists
                $existingResult = Result::where('exam_id', $request->exam_id)
                    ->where('student_id', $resultData['student_id'])
                    ->first();

                if (!$existingResult) {
                    $percentage = ($resultData['marks'] / $exam->total_marks) * 100;
                    $grade = $this->calculateGrade($percentage);
                    $gradePoint = $this->calculateGradePoint($grade);

                    Result::create([
                        'exam_id' => $request->exam_id,
                        'student_id' => $resultData['student_id'],
                        'marks' => $resultData['marks'],
                        'grade' => $grade,
                        'grade_point' => $gradePoint,
                        'remarks' => $resultData['remarks'] ?? null,
                        'is_published' => false,
                    ]);

                    $createdCount++;
                }
            }
        });

        return redirect()->route('admin.results.index')
            ->with('success', "{$createdCount} results created successfully.");
    }

    /**
     * Publish results for an exam
     */
    public function publishExamResults(Exam $exam)
    {
        $updatedCount = Result::where('exam_id', $exam->id)
            ->where('is_published', false)
            ->update(['is_published' => true]);

        return redirect()->back()
            ->with('success', "Published {$updatedCount} results for {$exam->title}.");
    }

    /**
     * Unpublish results for an exam
     */
    public function unpublishExamResults(Exam $exam)
    {
        $updatedCount = Result::where('exam_id', $exam->id)
            ->where('is_published', true)
            ->update(['is_published' => false]);

        return redirect()->back()
            ->with('success', "Unpublished {$updatedCount} results for {$exam->title}.");
    }

    /**
     * Get students for bulk result entry
     */
    public function getStudentsForExam(Exam $exam)
    {
        $students = $exam->course->students()
            ->with('user')
            ->where('enrollments.status', 'enrolled')
            ->get();

        return response()->json($students);
    }

    /**
     * Calculate grade based on percentage
     */
    private function calculateGrade($percentage)
    {
        if ($percentage >= 90) return 'A+';
        if ($percentage >= 85) return 'A';
        if ($percentage >= 80) return 'A-';
        if ($percentage >= 75) return 'B+';
        if ($percentage >= 70) return 'B';
        if ($percentage >= 65) return 'B-';
        if ($percentage >= 60) return 'C+';
        if ($percentage >= 55) return 'C';
        if ($percentage >= 50) return 'C-';
        if ($percentage >= 45) return 'D';
        return 'F';
    }

    /**
     * Calculate grade point based on grade
     */
    private function calculateGradePoint($grade)
    {
        $gradePoints = [
            'A+' => 4.0,
            'A' => 3.75,
            'A-' => 3.5,
            'B+' => 3.25,
            'B' => 3.0,
            'B-' => 2.75,
            'C+' => 2.5,
            'C' => 2.25,
            'C-' => 2.0,
            'D' => 1.0,
            'F' => 0.0,
        ];

        return $gradePoints[$grade] ?? 0.0;
    }

    /**
     * Export results to CSV
     */
    public function export(Request $request)
    {
        $query = Result::with(['student.user', 'exam.course']);

        // Apply same filters as index
        if ($request->has('course_id') && $request->course_id) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('course_id', $request->course_id);
            });
        }

        if ($request->has('exam_id') && $request->exam_id) {
            $query->where('exam_id', $request->exam_id);
        }

        $results = $query->get();

        $filename = 'results_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($results) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Student Name',
                'Student ID',
                'Course',
                'Exam',
                'Marks',
                'Grade',
                'Grade Point',
                'Published',
                'Created At'
            ]);

            // CSV data
            foreach ($results as $result) {
                fputcsv($file, [
                    $result->student->user->name,
                    $result->student->student_id,
                    $result->exam->course->title,
                    $result->exam->title,
                    $result->marks,
                    $result->grade,
                    $result->grade_point,
                    $result->is_published ? 'Yes' : 'No',
                    $result->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
