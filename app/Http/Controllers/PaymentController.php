<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['booking.player.user', 'booking.sport_field', 'admin.user']);
        
        // Apply filters
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('booking_id', 'like', '%' . $request->search . '%')
                  ->orWhere('transfer_code', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('date_range')) {
            $dates = explode(' - ', $request->date_range);
            if (count($dates) == 2) {
                $query->whereBetween('paid_at', [
                    Carbon::parse($dates[0])->startOfDay(),
                    Carbon::parse($dates[1])->endOfDay()
                ]);
            }
        }
        
        $payments = $query->latest('paid_at')->paginate(10);
        
        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['booking.player.user', 'booking.sport_field', 'admin.user']);
        
        return view('admin.payments.show', compact('payment'));
    }

    public function verify(Payment $payment)
    {
        // Ensure payment is pending
        if ($payment->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'This payment is already processed');
        }
        
        $payment->status = 'completed';
        $payment->admin_id = Auth::user()->admin->id;
        $payment->save();
        
        return redirect()->back()
            ->with('success', 'Payment verified successfully');
    }

    public function reject(Payment $payment)
    {
        // Ensure payment is pending
        if ($payment->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'This payment is already processed');
        }
        
        $payment->status = 'rejected';
        $payment->admin_id = Auth::user()->admin->id;
        $payment->save();
        
        return redirect()->back()
            ->with('success', 'Payment rejected successfully');
    }
}