<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Fee;
use App\Services\BkashPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $bkashService;

    public function __construct(BkashPaymentService $bkashService)
    {
        $this->bkashService = $bkashService;
    }

    /**
     * Display payment page for a specific fee
     */
    public function showPaymentForm(Fee $fee)
    {
        $this->authorize('view', $fee);
        
        return view('payments.form', compact('fee'));
    }

    /**
     * Process payment request
     */
    public function processPayment(Request $request, Fee $fee)
    {
        $this->authorize('pay', $fee);

        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $fee->amount,
            'payment_method' => 'required|in:cash,bank_transfer,bkash,nagad,rocket',
        ]);

        $amount = $request->amount;
        $paymentMethod = $request->payment_method;

        // Create payment record
        $payment = Payment::create([
            'student_id' => Auth::user()->student->id,
            'fee_id' => $fee->id,
            'amount' => $amount,
            'payment_method' => $paymentMethod,
            'payment_date' => now(),
            'status' => 'pending',
            'reference_number' => 'PAY_' . time() . '_' . Auth::id(),
        ]);

        // Handle different payment methods
        if (in_array($paymentMethod, ['bkash', 'nagad', 'rocket'])) {
            return $this->processMobilePayment($payment, $amount);
        } else {
            return $this->processManualPayment($payment, $amount, $paymentMethod);
        }
    }

    /**
     * Process mobile payment (bKash, Nagad, Rocket)
     */
    private function processMobilePayment(Payment $payment, $amount)
    {
        try {
            $invoiceNumber = $payment->reference_number;
            $callbackUrl = route('payment.callback');

            $result = $this->bkashService->createPayment($amount, $invoiceNumber, $callbackUrl);

            if (isset($result['error'])) {
                $payment->update(['status' => 'failed']);
                return redirect()->back()->with('error', 'Payment failed: ' . $result['error']);
            }

            if ($result['success']) {
                // Store payment ID for callback verification
                $payment->update([
                    'transaction_id' => $result['paymentID'],
                    'status' => 'pending'
                ]);

                // Redirect to bKash payment page
                return redirect($result['bkashURL']);
            }

            return redirect()->back()->with('error', 'Payment initialization failed');

        } catch (\Exception $e) {
            Log::error('Mobile payment error: ' . $e->getMessage());
            $payment->update(['status' => 'failed']);
            return redirect()->back()->with('error', 'Payment processing error');
        }
    }

    /**
     * Process manual payment (Cash, Bank Transfer)
     */
    private function processManualPayment(Payment $payment, $amount, $paymentMethod)
    {
        $payment->update([
            'status' => 'completed',
            'notes' => 'Manual payment - requires verification'
        ]);

        // Update fee status
        $fee = $payment->fee;
        if ($fee) {
            $totalPaid = $fee->payments()->where('status', 'completed')->sum('amount');
            if ($totalPaid >= $fee->amount) {
                $fee->update(['is_paid' => true]);
            }
        }

        return redirect()->route('student.payments')
            ->with('success', 'Payment recorded successfully. Please contact admin for verification.');
    }

    /**
     * Handle payment callback from bKash
     */
    public function handleCallback(Request $request)
    {
        $paymentID = $request->input('paymentID');
        $status = $request->input('status');

        Log::info('Payment callback received', [
            'paymentID' => $paymentID,
            'status' => $status,
            'request_data' => $request->all()
        ]);

        if (!$paymentID) {
            return redirect()->route('student.payments')->with('error', 'Invalid payment callback');
        }

        $payment = Payment::where('transaction_id', $paymentID)->first();

        if (!$payment) {
            Log::error('Payment not found for callback', ['paymentID' => $paymentID]);
            return redirect()->route('student.payments')->with('error', 'Payment not found');
        }

        if ($status === 'success') {
            // Execute payment to confirm
            $result = $this->bkashService->executePayment($paymentID);

            if ($result['success']) {
                $payment->update([
                    'status' => 'completed',
                    'transaction_id' => $result['transactionID'] ?? $paymentID,
                    'notes' => 'bKash payment completed'
                ]);

                // Update fee status
                $fee = $payment->fee;
                if ($fee) {
                    $totalPaid = $fee->payments()->where('status', 'completed')->sum('amount');
                    if ($totalPaid >= $fee->amount) {
                        $fee->update(['is_paid' => true]);
                    }
                }

                return redirect()->route('student.payments')
                    ->with('success', 'Payment completed successfully!');
            } else {
                $payment->update(['status' => 'failed']);
                return redirect()->route('student.payments')
                    ->with('error', 'Payment execution failed: ' . ($result['statusMessage'] ?? 'Unknown error'));
            }
        } else {
            $payment->update(['status' => 'failed']);
            return redirect()->route('student.payments')
                ->with('error', 'Payment was cancelled or failed');
        }
    }

    /**
     * Handle payment cancellation
     */
    public function handleCancel(Request $request)
    {
        $paymentID = $request->input('paymentID');

        if ($paymentID) {
            $payment = Payment::where('transaction_id', $paymentID)->first();
            if ($payment) {
                $payment->update(['status' => 'failed']);
            }
        }

        return redirect()->route('student.payments')
            ->with('error', 'Payment was cancelled');
    }

    /**
     * Handle payment failure
     */
    public function handleFail(Request $request)
    {
        $paymentID = $request->input('paymentID');

        if ($paymentID) {
            $payment = Payment::where('transaction_id', $paymentID)->first();
            if ($payment) {
                $payment->update(['status' => 'failed']);
            }
        }

        return redirect()->route('student.payments')
            ->with('error', 'Payment failed');
    }

    /**
     * Test bKash payment page (for development)
     */
    public function testBkashPayment($paymentId)
    {
        if (!config('bkash.sandbox', true)) {
            abort(404);
        }

        $payment = Payment::where('transaction_id', $paymentId)->first();

        if (!$payment) {
            abort(404);
        }

        return view('payments.test-bkash', compact('payment'));
    }

    /**
     * Simulate successful payment (for testing)
     */
    public function simulateSuccess(Request $request, $paymentId)
    {
        if (!config('bkash.sandbox', true)) {
            abort(404);
        }

        $payment = Payment::where('transaction_id', $paymentId)->first();

        if (!$payment) {
            abort(404);
        }

        $payment->update([
            'status' => 'completed',
            'notes' => 'Test payment - simulated success'
        ]);

        // Update fee status
        $fee = $payment->fee;
        if ($fee) {
            $totalPaid = $fee->payments()->where('status', 'completed')->sum('amount');
            if ($totalPaid >= $fee->amount) {
                $fee->update(['is_paid' => true]);
            }
        }

        return redirect()->route('student.payments')
            ->with('success', 'Test payment completed successfully!');
    }

    /**
     * Get payment history for student
     */
    public function getPaymentHistory()
    {
        $student = Auth::user()->student;
        
        $payments = Payment::where('student_id', $student->id)
            ->with('fee')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('payments.history', compact('payments'));
    }

    /**
     * Get payment statistics
     */
    public function getPaymentStats()
    {
        $student = Auth::user()->student;
        
        $stats = [
            'total_paid' => Payment::where('student_id', $student->id)
                ->where('status', 'completed')
                ->sum('amount'),
            'pending_payments' => Payment::where('student_id', $student->id)
                ->where('status', 'pending')
                ->count(),
            'failed_payments' => Payment::where('student_id', $student->id)
                ->where('status', 'failed')
                ->count(),
            'total_fees' => Fee::where('student_id', $student->id)->sum('amount'),
        ];

        $stats['due_amount'] = $stats['total_fees'] - $stats['total_paid'];

        return response()->json($stats);
    }
}
