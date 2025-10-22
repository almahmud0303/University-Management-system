<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Course;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with('course.department')
            ->latest()
            ->paginate(15);

        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        $courses = Course::where('is_active', true)->with('department')->get();
        return view('admin.exams.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'type' => 'required|in:quiz,midterm,final,assignment',
            'exam_date' => 'required|date|after:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'total_marks' => 'required|integer|min:1|max:1000',
            'venue' => 'nullable|string|max:255',
        ]);

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
            'status' => 'scheduled',
        ]);

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam created successfully.');
    }

    public function show(Exam $exam)
    {
        $exam->load(['course.department', 'course.teacher.user', 'results.student.user']);
        
        $stats = [
            'total_students' => $exam->results()->count(),
            'average_marks' => $exam->results()->avg('marks_obtained') ?? 0,
            'highest_marks' => $exam->results()->max('marks_obtained') ?? 0,
            'lowest_marks' => $exam->results()->min('marks_obtained') ?? 0,
        ];

        $recentResults = $exam->results()
            ->with('student.user')
            ->latest()
            ->limit(10)
            ->get();

        $gradeDistribution = $exam->results()
            ->selectRaw('grade, COUNT(*) as count')
            ->groupBy('grade')
            ->pluck('count', 'grade');

        return view('admin.exams.show', compact('exam', 'stats', 'recentResults', 'gradeDistribution'));
    }

    public function edit(Exam $exam)
    {
        $courses = Course::where('is_active', true)->with('department')->get();
        return view('admin.exams.edit', compact('exam', 'courses'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'type' => 'required|in:quiz,midterm,final,assignment',
            'exam_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'total_marks' => 'required|integer|min:1|max:1000',
            'venue' => 'nullable|string|max:255',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
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
            'status' => $request->status,
        ]);

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam deleted successfully.');
    }
}