<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Student;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        $fees = Fee::with('student.user')
            ->latest()
            ->paginate(15);

        return view('admin.fees.index', compact('fees'));
    }

    public function create()
    {
        $students = Student::with('user')->get();
        return view('admin.fees.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_type' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date|after:today',
            'notes' => 'nullable|string',
        ]);

        Fee::create([
            'student_id' => $request->student_id,
            'fee_type' => $request->fee_type,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.fees.index')
            ->with('success', 'Fee record created successfully.');
    }

    public function show(Fee $fee)
    {
        $fee->load('student.user');
        return view('admin.fees.show', compact('fee'));
    }

    public function edit(Fee $fee)
    {
        $students = Student::with('user')->get();
        return view('admin.fees.edit', compact('fee', 'students'));
    }

    public function update(Request $request, Fee $fee)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_type' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0|max:' . $fee->amount,
            'due_date' => 'required|date',
            'paid_date' => 'nullable|date|before_or_equal:today',
            'status' => 'required|in:pending,partial,paid,overdue',
            'notes' => 'nullable|string',
        ]);

        $fee->update([
            'student_id' => $request->student_id,
            'fee_type' => $request->fee_type,
            'amount' => $request->amount,
            'paid_amount' => $request->paid_amount ?? 0,
            'due_date' => $request->due_date,
            'paid_date' => $request->paid_date,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.fees.index')
            ->with('success', 'Fee record updated successfully.');
    }

    public function destroy(Fee $fee)
    {
        $fee->delete();
        return redirect()->route('admin.fees.index')
            ->with('success', 'Fee record deleted successfully.');
    }

    public function markPaid(Fee $fee)
    {
        $fee->update([
            'status' => 'paid',
            'paid_amount' => $fee->amount,
            'paid_date' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Fee marked as paid successfully.');
    }
}