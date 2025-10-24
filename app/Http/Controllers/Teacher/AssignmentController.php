<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    /**
     * Display a listing of assignments for the teacher's courses
     */
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        $query = Assignment::with(['course', 'submissions'])
            ->where('teacher_id', $teacher->id);

        // Filter by course
        if ($request->has('course_id') && $request->course_id) {
            $query->where('course_id', $request->course_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            switch ($request->status) {
                case 'published':
                    $query->where('is_published', true);
                    break;
                case 'draft':
                    $query->where('is_published', false);
                    break;
                case 'upcoming':
                    $query->where('due_date', '>', now());
                    break;
                case 'overdue':
                    $query->where('due_date', '<', now());
                    break;
            }
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $assignments = $query->orderBy('due_date', 'desc')->paginate(15);
        $courses = Course::where('teacher_id', $teacher->id)->where('is_active', true)->get();

        return view('teacher.assignments.index', compact('assignments', 'courses'));
    }

    /**
     * Show the form for creating a new assignment
     */
    public function create()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        $courses = Course::where('teacher_id', $teacher->id)
            ->where('is_active', true)
            ->get();

        return view('teacher.assignments.create', compact('courses'));
    }

    /**
     * Store a newly created assignment
     */
    public function store(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after:now',
            'total_marks' => 'required|numeric|min:1',
            'instructions' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240', // 10MB max
            'is_published' => 'boolean',
        ]);

        // Verify the course belongs to this teacher
        $course = Course::where('id', $request->course_id)
            ->where('teacher_id', $teacher->id)
            ->firstOrFail();

        $assignmentData = [
            'course_id' => $request->course_id,
            'teacher_id' => $teacher->id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'total_marks' => $request->total_marks,
            'instructions' => $request->instructions,
            'is_published' => $request->has('is_published'),
            'created_by' => Auth::id(),
        ];

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('assignments', $filename, 'public');
            $assignmentData['file_path'] = $path;
        }

        Assignment::create($assignmentData);

        return redirect()->route('teacher.assignments.index')
            ->with('success', 'Assignment created successfully.');
    }

    /**
     * Display the specified assignment
     */
    public function show(Assignment $assignment)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        // Verify the assignment belongs to this teacher
        if ($assignment->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to assignment.');
        }

        $assignment->load(['course', 'submissions.student.user']);
        
        $stats = [
            'total_students' => $assignment->course->students()->count(),
            'submitted' => $assignment->submissions()->count(),
            'graded' => $assignment->submissions()->whereNotNull('marks')->count(),
            'pending' => $assignment->submissions()->whereNull('marks')->count(),
        ];

        return view('teacher.assignments.show', compact('assignment', 'stats'));
    }

    /**
     * Show the form for editing the specified assignment
     */
    public function edit(Assignment $assignment)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        // Verify the assignment belongs to this teacher
        if ($assignment->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to assignment.');
        }

        $courses = Course::where('teacher_id', $teacher->id)
            ->where('is_active', true)
            ->get();

        return view('teacher.assignments.edit', compact('assignment', 'courses'));
    }

    /**
     * Update the specified assignment
     */
    public function update(Request $request, Assignment $assignment)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        // Verify the assignment belongs to this teacher
        if ($assignment->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to assignment.');
        }

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'total_marks' => 'required|numeric|min:1',
            'instructions' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240',
            'is_published' => 'boolean',
        ]);

        // Verify the course belongs to this teacher
        $course = Course::where('id', $request->course_id)
            ->where('teacher_id', $teacher->id)
            ->firstOrFail();

        $assignmentData = [
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'total_marks' => $request->total_marks,
            'instructions' => $request->instructions,
            'is_published' => $request->has('is_published'),
        ];

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($assignment->file_path) {
                Storage::disk('public')->delete($assignment->file_path);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('assignments', $filename, 'public');
            $assignmentData['file_path'] = $path;
        }

        $assignment->update($assignmentData);

        return redirect()->route('teacher.assignments.index')
            ->with('success', 'Assignment updated successfully.');
    }

    /**
     * Remove the specified assignment
     */
    public function destroy(Assignment $assignment)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        // Verify the assignment belongs to this teacher
        if ($assignment->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to assignment.');
        }

        // Delete file if exists
        if ($assignment->file_path) {
            Storage::disk('public')->delete($assignment->file_path);
        }

        $assignment->delete();

        return redirect()->route('teacher.assignments.index')
            ->with('success', 'Assignment deleted successfully.');
    }

    /**
     * Show submissions for an assignment
     */
    public function submissions(Assignment $assignment)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        // Verify the assignment belongs to this teacher
        if ($assignment->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to assignment.');
        }

        $submissions = AssignmentSubmission::with('student.user')
            ->where('assignment_id', $assignment->id)
            ->orderBy('submitted_at', 'desc')
            ->paginate(20);

        return view('teacher.assignments.submissions', compact('assignment', 'submissions'));
    }

    /**
     * Grade a submission
     */
    public function grade(Request $request, AssignmentSubmission $submission)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        // Verify the submission belongs to teacher's assignment
        if ($submission->assignment->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to submission.');
        }

        $request->validate([
            'marks' => 'required|numeric|min:0|max:' . $submission->assignment->total_marks,
            'feedback' => 'nullable|string|max:1000',
        ]);

        $marks = $request->marks;
        $percentage = ($marks / $submission->assignment->total_marks) * 100;

        // Calculate grade and grade point
        $grade = $this->calculateGrade($percentage);
        $gradePoint = $this->calculateGradePoint($grade);

        $submission->update([
            'marks' => $marks,
            'feedback' => $request->feedback,
            'graded_at' => now(),
            'graded_by' => Auth::id(),
        ]);

        return redirect()->back()
            ->with('success', 'Submission graded successfully.');
    }

    /**
     * Publish/unpublish assignment
     */
    public function togglePublish(Assignment $assignment)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        // Verify the assignment belongs to this teacher
        if ($assignment->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to assignment.');
        }

        $assignment->update([
            'is_published' => !$assignment->is_published
        ]);

        $status = $assignment->is_published ? 'published' : 'unpublished';
        return redirect()->back()
            ->with('success', "Assignment {$status} successfully.");
    }

    /**
     * Get assignment statistics
     */
    public function statistics(Assignment $assignment)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        // Verify the assignment belongs to this teacher
        if ($assignment->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to assignment.');
        }

        $stats = [
            'total_students' => $assignment->course->students()->count(),
            'submitted' => $assignment->submissions()->count(),
            'graded' => $assignment->submissions()->whereNotNull('marks')->count(),
            'pending' => $assignment->submissions()->whereNull('marks')->count(),
            'late_submissions' => $assignment->submissions()->where('submitted_at', '>', $assignment->due_date)->count(),
            'average_marks' => $assignment->submissions()->whereNotNull('marks')->avg('marks'),
        ];

        return response()->json($stats);
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
}
