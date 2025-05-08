<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Player;
use App\Models\SportField;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BookingController extends Controller
{
    
    public function show($playerId, $fieldId)
    {
        $field = SportField::where('id', $fieldId)->first();
        $player = User::where('id', $playerId)->first();
        
        // If a booking_id is passed in the request, fetch the booking and its payment
        $bookingId = request()->query('booking_id');
        $booking = null;
        $payment = null;
        
        if ($bookingId) {
            $booking = Booking::find($bookingId);
            if ($booking) {
                $payment = DB::table('payments')->where('booking_id', $bookingId)->first();
            }
        }
        
        return view('booking.show', compact('field', 'player', 'booking', 'payment'));
    }

    public function store(Request $request)
{
    // Validate the request data
    $validated = $request->validate([
        'field_id' => 'required|exists:sport_fields,id',
        'booking_date' => 'required|date|date_format:Y-m-d',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'details' => 'nullable|string|max:1000',
        'payment_method' => 'required|in:omt,wish',
        'payment_code' => 'required|string|max:100',
        'total_price' => 'required|numeric',
        'website_fee' => 'required|numeric',
        'field_fee' => 'required|numeric',
    ]);

    
    // Begin a database transaction
    DB::beginTransaction();
    
    // Check if the time slot is already booked, EXCLUDING cancelled bookings
    $conflictingBooking = Booking::where('field_id', $request->field_id)
        ->where('date', $request->booking_date)
        ->where('status', '!=', 'cancelled') // Add this line to exclude cancelled bookings
        ->where(function($query) use ($request) {
            $query->where(function($q) use ($request) {
                // Booking starts during an existing booking
                $q->where('start_time', '<=', $request->start_time)
                  ->where('end_time', '>', $request->start_time);
            })
            ->orWhere(function($q) use ($request) {
                // Booking ends during an existing booking
                $q->where('start_time', '<', $request->end_time)
                  ->where('end_time', '>=', $request->end_time);
            })
            ->orWhere(function($q) use ($request) {
                // Booking completely contains an existing booking
                $q->where('start_time', '>=', $request->start_time)
                  ->where('end_time', '<=', $request->end_time);
            });
        })
        ->first();
    
    if ($conflictingBooking) {
        return response()->json([
            'success' => false,
            'message' => 'This time slot is already booked. Please select another time.'
        ], 409);
    }
    
    // Create the new booking
    $booking = Booking::create([
        'date' => $request->booking_date,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'details' => $request->details,
        'player_id' => session('player_id'), // Assuming the player ID is stored in the session
        'field_id' => $request->field_id,
        'status' => 'upcoming',
    ]);
    
    // Create the payment record associated with the booking
    $payment = DB::table('payments')->insert([
        'website_fee' => $request->website_fee,
        'field_fee' => $request->field_fee,
        'transfer_code' => $request->payment_code,
        'transfer_type' => $request->payment_method,
        'paid_at' => now()->timezone('Asia/Beirut'),
        'status' => 'pending',
        'booking_id' => $booking->id,
        'created_at' => now()->timezone('Asia/Beirut'),
        'updated_at' => now()->timezone('Asia/Beirut'),
    ]);

    // Generate a reference number
    $reference = 'BK-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
    
    // Commit the transaction
    DB::commit();
    
    return response()->json([
        'success' => true,
        'message' => 'Booking confirmed successfully!',
        'reference' => $reference,
        'booking_id' => $booking->id
    ]);
}


    public function getBookedSlots(Request $request, $fieldId)
    {
        $date = $request->query('date');
        $timezone = 'Asia/Beirut';
        $now = now()->timezone($timezone);
        if (!$date) {
            return response()->json(['success' => false, 'message' => 'Date parameter is required'], 400);
        }
        
        try {
            // Get field and its schedule
            $field = SportField::findOrFail($fieldId);
            $operatingStart = Carbon::parse($field->defaultSchedule->from_time);
            $operatingEnd = Carbon::parse($field->defaultSchedule->to_time);
            $slotDuration = 60; // minutes - adjust based on your system
            
            // Get existing bookings - FILTER OUT CANCELLED BOOKINGS
            $bookingsQuery = Booking::where('field_id', $fieldId)
                ->where('date', $date)
                ->where('status', '!=', 'cancelled'); 
            if ($request->has('exclude_booking')) {
                $bookingsQuery->where('id', '!=', $request->query('exclude_booking'));
            }
            
            $bookings = $bookingsQuery->get();
            
            // Format booked slots
            $bookedSlots = [];
            foreach ($bookings as $booking) {
                // Format times consistently as HH:MM
                $startTime = is_object($booking->start_time) 
                    ? $booking->start_time->format('H:i') 
                    : (substr($booking->start_time, 0, 5));
                
                $endTime = is_object($booking->end_time) 
                    ? $booking->end_time->format('H:i') 
                    : (substr($booking->end_time, 0, 5));
                
                $bookedSlots[$startTime] = $endTime;
            }
            
            
            if ($date == $now->format('Y-m-d')) {
                $currentTime = $now->format('H:i');
                $current = Carbon::parse($currentTime);
                
                // Generate all possible slots based on operating hours
                $slotStart = $operatingStart->copy();
                
                while ($slotStart < $operatingEnd) {
                    $slotEnd = $slotStart->copy()->addMinutes($slotDuration);
                    $slotKey = $slotStart->format('H:i');
                    
                    // Mark slot as booked if:
                    // 1. It's completely in the past, or
                    // 2. It's the current slot and we're halfway through it
                    if ($slotEnd <= $current || 
                        ($slotStart <= $current && $current->diffInMinutes($slotStart) >= ($slotDuration / 2))) {
                        
                        if (!isset($bookedSlots[$slotKey])) {
                            $bookedSlots[$slotKey] = $slotEnd->format('H:i');
                        }
                    }
                    
                    $slotStart->addMinutes($slotDuration);
                }
            }
            
            return response()->json([
                'success' => true,
                'slots' => $bookedSlots,
                'date' => $date,
                'field_id' => $fieldId
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch booked slots: ' . $e->getMessage()
            ], 500);
        }
    }
   /**
 * Show the form for editing the specified booking.
 *
 * @param  Booking  $booking
 * @return \Illuminate\View\View
 */
public function edit(Booking $booking)
{
   
    
    // Fetch payment details for this booking
    $payment = DB::table('payments')->where('booking_id', $booking->id)->first();
    
    // Return the view with the booking and payment data
    return view('booking.edit', compact('booking', 'payment'));
}
   /**
 * Update the specified booking in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  Booking  $booking
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, Booking $booking)
{
    
    $validated = $request->validate([
        'booking_date' => 'required|date',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'details' => 'nullable|string|max:1000',
        'new_field_fee' => 'required|numeric',
        'new_website_fee' => 'required|numeric',
        'new_total_price' => 'required|numeric',
    ]);
    
    
       // Begin a database transaction
        DB::beginTransaction();
        
       // Check if the time slot is already booked by someone else
        $conflictingBooking = Booking::where('field_id', $booking->field_id)
            ->where('id', '!=', $booking->id)
            ->where('date', $request->booking_date)
            ->where('status', '!=', 'cancelled') 
            ->where(function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    // Booking starts during an existing booking
                    $q->where('start_time', '<=', $request->start_time)
                      ->where('end_time', '>', $request->start_time);
                })
                ->orWhere(function($q) use ($request) {
                    // Booking ends during an existing booking
                    $q->where('start_time', '<', $request->end_time)
                      ->where('end_time', '>=', $request->end_time);
                })
                ->orWhere(function($q) use ($request) {
                    // Booking completely contains an existing booking
                    $q->where('start_time', '>=', $request->start_time)
                      ->where('end_time', '<=', $request->end_time);
                });
            })
            ->first();
        
        if ($conflictingBooking) {
            return redirect()->back()->with('error', 'This time slot is already booked. Please select another time.');
        }
        
        // Update the booking
        $booking->update([
            'date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'details' => $request->details,
            // No change to status
        ]);
        
        // Log the update for debugging
        Log::info('Booking updated', [
            'booking_id' => $booking->id,
            'new_date' => $request->booking_date,
            'new_start_time' => $request->start_time,
            'new_end_time' => $request->end_time
        ]);
        
        // Update the payment record
        $payment = DB::table('payments')->where('booking_id', $booking->id)->first();
        
        if ($payment) {
            DB::table('payments')->where('booking_id', $booking->id)->update([
                'field_fee' => $request->new_field_fee,
                'website_fee' => $request->new_website_fee,
                'updated_at' => now()->timezone('Asia/Beirut'),
            ]);
            
            // Log payment update
            Log::info('Payment updated', [
                'payment_id' => $payment->id,
                'booking_id' => $booking->id,
                'new_field_fee' => $request->new_field_fee,
                'new_website_fee' => $request->new_website_fee
            ]);
        } else {
            // If payment record doesn't exist, create one
            DB::table('payments')->insert([
                'booking_id' => $booking->id,
                'field_fee' => $request->new_field_fee,
                'website_fee' => $request->new_website_fee,
                'transfer_code' => 'UPDATED',
                'transfer_type' => 'omt',
                'status' => 'pending',
                'paid_at' => now()->timezone('Asia/Beirut'),
                'created_at' => now()->timezone('Asia/Beirut'),
                'updated_at' => now()->timezone('Asia/Beirut'),
            ]);
            
            // Log payment creation
            Log::info('Payment created', [
                'booking_id' => $booking->id,
                'field_fee' => $request->new_field_fee,
                'website_fee' => $request->new_website_fee
            ]);
        }
        
        // Commit the transaction
        DB::commit();
        
        return redirect()->back()
            ->with('success', 'Booking updated successfully');
            
    
}

/**
 * Remove the specified booking from storage.
 *
 * @param  \App\Models\Booking  $booking
 * @return \Illuminate\Http\Response
 */
public function destroy(Booking $booking)
{
    try {
        // Begin transaction
        DB::beginTransaction();
        
        // Check if the booking exists
        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found');
        }
        
        // Log this cancellation
        Log::info('Cancelling booking', [
            'booking_id' => $booking->id,
            'date' => $booking->date,
            'time' => $booking->start_time . ' - ' . $booking->end_time
        ]);
        
        // Update the booking status instead of deleting it
        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now()->timezone('Asia/Beirut')
        ]);
        
        // Update payment status if exists
        $payment = DB::table('payments')->where('booking_id', $booking->id)->first();
        if ($payment) {
            DB::table('payments')->where('booking_id', $booking->id)->update([
                'status' => 'refunded',
                'updated_at' => now()->timezone('Asia/Beirut')
            ]);
        }
        
        // Commit transaction
        DB::commit();
        
        return redirect()->route('bookings.history')->with('success', 'Booking cancelled successfully');
        
    } catch (\Exception $e) {
        // Rollback transaction
        DB::rollBack();
        
        Log::error('Booking cancellation failed: ' . $e->getMessage(), [
            'exception' => $e,
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
    }
}

/**
 * Get payment details for a booking
 * 
 * @param int $bookingId
 * @return object|null
 */
public function getPaymentDetails($bookingId)
{
    return DB::table('payments')
        ->where('booking_id', $bookingId)
        ->first();
}

/**
 * Show a specific booking with payment details
 *
 * @param int $bookingId
 * @return \Illuminate\View\View
 */
public function showBooking($bookingId)
{
    $booking = Booking::findOrFail($bookingId);
    $payment = $this->getPaymentDetails($bookingId);
    
    return view('booking.show', compact('booking', 'payment'));
}

 /**
     * Display the user's booking history.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function history(Request $request)
    {
        // Get the currently logged in player's ID
        $playerId = session('player_id');
        
        // Check if player exists
        if (!$playerId) {
            return view('booking.history', [
                'bookings' => collect([]),
                'stats' => [
                    'total' => 0,
                    'upcoming' => 0,
                    'completed' => 0,
                    'cancelled' => 0,
                ]
            ]);
        }

        // Update statuses for past bookings that are still marked as 'upcoming'
        $this->updatePastBookingStatuses($playerId);
        
        // Create a query to fetch the player's bookings with field information
        $query = Booking::where('player_id', $playerId);
        
        // Apply filters
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhereHas('sportfield', function($q2) use ($search) {
                      $q2->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        if ($request->has('from_date') && !empty($request->from_date)) {
            $query->where('date', '>=', $request->from_date);
        }
        
        if ($request->has('to_date') && !empty($request->to_date)) {
            $query->where('date', '<=', $request->to_date);
        }
        
        // Filter by status
        $status = $request->input('status', 'upcoming');
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        // Get booking statistics with accurate counts
        $stats = [
            'total' => Booking::where('player_id', $playerId)->count(),
            'upcoming' => Booking::where('player_id', $playerId)
                          ->where('status', 'upcoming')
                          ->count(),
            'completed' => Booking::where('player_id', $playerId)
                          ->where('status', 'completed')
                          ->count(),
            'cancelled' => Booking::where('player_id', $playerId)
                          ->where('status', 'cancelled')
                          ->count(),
        ];
        
        // Order bookings by date (newest first)
        $bookings = $query->orderBy('date', 'desc')
                          ->orderBy('start_time', 'asc')
                          ->paginate(10);
        
        
        
        return view('booking.history', compact('bookings', 'stats'));
    }

    /**
     * Update statuses for past bookings that are still marked as 'upcoming'
     *
     * @param int $playerId
     * @return void
     */
    private function updatePastBookingStatuses($playerId)
    {
        try {
            ;
            // Find all bookings that have passed but still marked as upcoming
            $pastBookings = Booking::where('player_id', $playerId)
                ->where('status', 'upcoming')
                ->where('date', '<', Carbon::now()->timezone('Asia/Beirut')->format('Y-m-d'))
                ->orWhere(function($query) {
                    $query->where('date', '=', Carbon::now()->timezone('Asia/Beirut')->format('Y-m-d'))
                          ->where('end_time', '<', Carbon::now()->timezone('Asia/Beirut')->format('H:i:s'));
                })
                ->get();
            
            // Update their status to completed
            foreach ($pastBookings as $booking) {
                $booking->update(['status' => 'completed']);
                Log::info('Updated past booking status to completed', ['booking_id' => $booking->id]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to update past booking statuses: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Cancel the specified booking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Request $request, Booking $booking)
    {
        try {
            // Begin transaction
            DB::beginTransaction();
            
            // Check if the booking exists and belongs to the current player
            if (!$booking || $booking->player_id != session('player_id')) {
                return redirect()->back()->with('error', 'Booking not found or you do not have permission to cancel it.');
            }
            
            // Check if the booking is already cancelled
            if ($booking->status === 'cancelled') {
                return redirect()->back()->with('error', 'This booking has already been cancelled.');
            }
            
            // Check if the booking is in the past
            if ($booking->date < now()->timezone('Asia/Beirut')->format('Y-m-d') || 
                ($booking->date == now()->timezone('Asia/Beirut')->format('Y-m-d') && $booking->end_time < now()->timezone('Asia/Beirut')->format('H:i:s'))) {
                return redirect()->back()->with('error', 'You cannot cancel a booking that has already occurred.');
            }
            
            // Validate the cancellation reason
            $validated = $request->validate([
                'cancellation_reason' => 'nullable|string|max:500',
            ]);
            
            // Log this cancellation
            Log::info('Cancelling booking from history page', [
                'booking_id' => $booking->id,
                'date' => $booking->date,
                'time' => $booking->start_time . ' - ' . $booking->end_time,
                'reason' => $request->cancellation_reason
            ]);
            
            // Update the booking status
            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => now()->timezone('Asia/Beirut'),
                'details' => $booking->details . "\n\nCancellation reason: " . ($request->cancellation_reason ?? 'No reason provided')
            ]);
            
            // Update payment status if exists
            $payment = DB::table('payments')->where('booking_id', $booking->id)->first();
            if ($payment) {
                // Determine refund amount based on cancellation time
                $bookingDate = Carbon::parse($booking->date . ' ' . $booking->start_time);
                $hoursTillBooking = Carbon::now()->timezone('Asia/Beirut')->diffInHours($bookingDate, false);
                
                $refundStatus = 'refunded';
                
                // If cancellation is less than 24 hours before booking
                if ($hoursTillBooking < 24) {
                    $refundStatus = 'partial_refund';
                }
                
                DB::table('payments')->where('booking_id', $booking->id)->update([
                    'status' => $refundStatus,
                    'updated_at' => now()->timezone('Asia/Beirut')
                ]);
            }
            
            // Commit transaction
            DB::commit();
            
            return redirect()->route('bookings.history')->with('success', 'Booking cancelled successfully. Any applicable refund will be processed shortly.');
            
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            
            Log::error('Booking cancellation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'An error occurred while cancelling your booking. Please try again or contact support.');
        }
    }


}