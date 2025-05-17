<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\SportField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminBookingController extends Controller
{
    /**
     * Display a listing of the bookings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Booking::with(['player.user', 'sportField', 'payment']);
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('field_id')) {
            $query->where('sport_field_id', $request->field_id);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('start_time', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('start_time', '<=', $request->date_to);
        }
        
        // Default sorting by start_time (upcoming bookings first)
        $query->orderBy('start_time', 'asc');
        
        $bookings = $query->paginate(10);
        
        // Get fields for filter dropdown
        $fields = SportField::orderBy('name')->get();
        
        return view('admin.bookings.index', compact('bookings', 'fields'));
    }

    /**
     * Display the specified booking.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\View\View
     */
    public function show(Booking $booking)
    {
        // Load relationships
        $booking->load(['player.user', 'sportField', 'payment.admin']);
        
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Update the status of the specified booking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:upcoming,completed,cancelled'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Invalid status provided.');
        }
        
        // Don't allow changing from completed/cancelled back to upcoming
        if (($booking->status == 'completed' || $booking->status == 'cancelled') && $request->status == 'upcoming') {
            return redirect()->back()
                ->with('error', 'Cannot change a completed or cancelled booking back to upcoming.');
        }
        
        // Update the status
        $booking->status = $request->status;
        $booking->save();
        
        return redirect()->back()
            ->with('success', 'Booking status updated successfully.');
    }
}