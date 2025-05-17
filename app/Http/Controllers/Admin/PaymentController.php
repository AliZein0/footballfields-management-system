<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Payment::query();
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('transfer_type')) {
            $query->where('transfer_type', $request->transfer_type);
        }
        
        // Default sorting
        $query->orderBy('paid_at', 'desc');
        
        // Simplify by not eager loading complex relationships
        $payments = $query->paginate(10);
        
        // Get simple summary stats
        $totalPayments = Payment::where('status', 'completed')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        
        return view('admin.payments.index', compact('payments', 'totalPayments', 'pendingPayments'));
    }

    /**
     * Display the specified payment.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Verify a payment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify($id)
    {
        $payment = Payment::findOrFail($id);
        
        // Check if payment is already processed
        if ($payment->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'This payment has already been processed.');
        }
        
        // Update payment status
        $payment->status = 'completed';
        $payment->admin_id = Auth::id();
        $payment->save();
        
        return redirect()->back()
            ->with('success', 'Payment verified successfully.');
    }

    /**
     * Reject a payment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject($id)
    {
        $payment = Payment::findOrFail($id);
        
        // Check if payment is already processed
        if ($payment->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'This payment has already been processed.');
        }
        
        // Update payment status
        $payment->status = 'rejected';
        $payment->admin_id = Auth::id();
        $payment->save();
        
        return redirect()->back()
            ->with('success', 'Payment rejected successfully.');
    }
}