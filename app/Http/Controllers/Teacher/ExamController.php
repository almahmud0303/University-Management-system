<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Course;
use App\Models\Result;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        $query = Exam::whereHas('course', function($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })
            ->with('course');

        // Filter by course if specified
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Filter by type if specified
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $exams = $query->latest()->paginate(15);

        $courses = Course::where('teacher_id', $teacher->id)
            ->where('is_active', true)
            ->get();

        return view('teacher.exams.index', compact('exams', 'courses'));
    }

    public function create()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        $courses = Course::where('teacher_id', $teacher->id)
            ->where('is_active', true)
            ->with('department')
            ->get();

        return view('teacher.exams.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'type' => 'required|in:quiz,midterm,assignment',
            'exam_date' => 'required|date|after:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'total_marks' => 'required|integer|min:1|max:1000',
            'venue' => 'nullable|string|max:255',
        ]);

        // Ensure the course belongs to this teacher
        $course = Course::find($request->course_id);
        if ($course->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to course.');
        }

        Exam::create([
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'type' => $request->type,
            'exam_date' => $request->exam_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'total_marks' => $request->total_marks,
            'venue' => $request->venue,
        ]);

        return redirect()->route('teacher.exams.index')
            ->with('success', 'Assessment created successfully.');
    }

    public function show(Exam $exam)
    {
        $teacher = Auth::user()->teacher;
        
        // Ensure teacher can only view their own exams
        if ($exam->course->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to exam.');
        }

        $exam->load(['course.department', 'results.student.user']);
        
        $stats = [
            'total_students' => $exam->results()->count(),
            'average_marks' => $exam->results()->avg('marks_obtained') ?? 0,
            'highest_marks' => $exam->results()->max('marks_obtained') ?? 0,
            'lowest_marks' => $exam->results()->min('marks_obtained') ?? 0,
        ];

        return view('teacher.exams.show', compact('exam', 'stats'));
    }

    public function edit(Exam $exam)
    {
        $teacher = Auth::user()->teacher;
        
        // Ensure teacher can only edit their own exams
        if ($exam->course->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to exam.');
        }

        $courses = Course::where('teacher_id', $teacher->id)
            ->where('is_active', true)
            ->with('department')
            ->get();

        return view('teacher.exams.edit', compact('exam', 'courses'));
    }

    public function update(Request $request, Exam $exam)
    {
        $teacher = Auth::user()->teacher;
        
        // Ensure teacher can only edit their own exams
        if ($exam->course->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to exam.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'type' => 'required|in:quiz,midterm,assignment',
            'exam_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'total_marks' => 'required|integer|min:1|max:1000',
            'venue' => 'nullable|string|max:255',
        ]);

        $exam->update([
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'type' => $request->type,
            'exam_date' => $request->exam_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'total_marks' => $request->total_marks,
            'venue' => $request->venue,
        ]);

        return redirect()->route('teacher.exams.index')
            ->with('success', 'Assessment updated successfully.');
    }

    public function destroy(Exam $exam)
    {
        $teacher = Auth::user()->teacher;
        
        // Ensure teacher can only delete their own exams
        if ($exam->course->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to exam.');
        }

        $exam->delete();
        return redirect()->route('teacher.exams.index')
            ->with('success', 'Assessment deleted successfully.');
    }

    public function enterMarks(Exam $exam)
    {
        $teacher = Auth::user()->teacher;
        
        // Ensure teacher can only manage their own exams
        if ($exam->course->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to exam.');
        }

        $exam->load(['course.enrollments.student.user']);
        
        $students = $exam->course->enrollments()
            ->where('status', 'enrolled')
            ->with('student.user')
            ->get()
            ->pluck('student');

        $results = $exam->results()->with('student.user')->get()->keyBy('student_id');

        return view('teacher.exams.enter-marks', compact('exam', 'students', 'results'));
    }

    public function storeMarks(Request $request, Exam $exam)
    {
        $teacher = Auth::user()->teacher;
        
        // Ensure teacher can only manage their own exams
        if ($exam->course->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to exam.');
        }

        $request->validate([
            'marks' => 'required|array',
            'marks.*' => 'required|integer|min:0|max:' . $exam->total_marks,
        ]);

        foreach ($request->marks as $studentId => $marksObtained) {
            $grade = $this->calculateGrade($marksObtained, $exam->total_marks);
            $gradePoint = $this->calculateGradePoint($grade);

            Result::updateOrCreate(
                [
                    'exam_id' => $exam->id,
                    'student_id' => $studentId,
                ],
                [
                    'marks_obtained' => $marksObtained,
                    'grade' => $grade,
                    'grade_point' => $gradePoint,
                    'is_published' => false,
                ]
            );
        }

        return redirect()->route('teacher.exams.show', $exam)
            ->with('success', 'Marks entered successfully.');
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
