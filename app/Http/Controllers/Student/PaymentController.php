<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display the student's payment history.
     */
    public function index(Request $request)
    {
        $student = auth()->user()->student;
        
        $query = Payment::where('student_id', $student->id)->with(['fee']);
        
        // Apply filters
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('payment_method') && $request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }
        
        $payments = $query->latest()->paginate(15);
        
        // Get statistics
        $stats = [
            'total_payments' => Payment::where('student_id', $student->id)->count(),
            'successful_payments' => Payment::where('student_id', $student->id)->where('status', 'completed')->count(),
            'failed_payments' => Payment::where('student_id', $student->id)->where('status', 'failed')->count(),
            'pending_payments' => Payment::where('student_id', $student->id)->where('status', 'pending')->count(),
            'total_amount' => Payment::where('student_id', $student->id)->where('status', 'completed')->sum('amount'),
        ];
        
        return view('student.payments.index', compact('payments', 'stats'));
    }
    
    /**
     * Show the form for creating a new payment.
     */
    public function create(Fee $fee)
    {
        $student = auth()->user()->student;
        
        // Check if fee belongs to student
        if ($fee->student_id !== $student->id) {
            abort(403, 'Unauthorized access to this fee.');
        }
        
        // Check if fee is already paid
        if ($fee->is_paid) {
            return redirect()->route('student.fees.index')->with('error', 'This fee has already been paid.');
        }
        
        return view('student.payments.create', compact('fee'));
    }
    
    /**
     * Process the payment.
     */
    public function process(Request $request, Fee $fee)
    {
        $student = auth()->user()->student;
        
        // Check if fee belongs to student
        if ($fee->student_id !== $student->id) {
            abort(403, 'Unauthorized access to this fee.');
        }
        
        // Check if fee is already paid
        if ($fee->is_paid) {
            return redirect()->route('student.fees.index')->with('error', 'This fee has already been paid.');
        }
        
        $request->validate([
            'payment_method' => 'required|in:bkash,nagad,rocket,bank_transfer',
            'transaction_id' => 'required|string|max:255',
        ]);
        
        // Create payment record
        $payment = Payment::create([
            'student_id' => $student->id,
            'fee_id' => $fee->id,
            'amount' => $fee->amount,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'status' => 'pending',
            'payment_date' => now(),
        ]);
        
        // For now, mark as completed (in real implementation, this would be verified)
        $payment->update(['status' => 'completed']);
        $fee->update(['is_paid' => true]);
        
        return redirect()->route('student.payments.index')->with('success', 'Payment processed successfully.');
    }
}
