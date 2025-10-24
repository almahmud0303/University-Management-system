<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    /**
     * Display the student's fees.
     */
    public function index(Request $request)
    {
        $student = auth()->user()->student;
        
        $query = Fee::where('student_id', $student->id);
        
        // Apply filters
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_paid', $request->status === 'paid');
        }
        
        if ($request->has('academic_year') && $request->academic_year) {
            $query->where('academic_year', $request->academic_year);
        }
        
        if ($request->has('semester') && $request->semester) {
            $query->where('semester', $request->semester);
        }
        
        $fees = $query->latest()->paginate(15);
        
        // Get statistics
        $stats = [
            'total_fees' => Fee::where('student_id', $student->id)->count(),
            'paid_fees' => Fee::where('student_id', $student->id)->where('is_paid', true)->count(),
            'pending_fees' => Fee::where('student_id', $student->id)->where('is_paid', false)->count(),
            'total_amount' => Fee::where('student_id', $student->id)->sum('amount'),
            'paid_amount' => Fee::where('student_id', $student->id)->where('is_paid', true)->sum('amount'),
            'pending_amount' => Fee::where('student_id', $student->id)->where('is_paid', false)->sum('amount'),
        ];
        
        $academicYears = Fee::where('student_id', $student->id)->distinct()->pluck('academic_year');
        $semesters = Fee::where('student_id', $student->id)->distinct()->pluck('semester');
        
        return view('student.fees.index', compact('fees', 'stats', 'academicYears', 'semesters'));
    }
}
