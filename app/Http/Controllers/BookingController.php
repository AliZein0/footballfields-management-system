<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Player;
use App\Models\SportField;
use App\Models\DefaultSchedule;

use App\Models\ScheduleDetail;
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
        
        // Check if the time slot is available according to schedule details
        $scheduleConflict = $this->checkScheduleAvailability(
            $request->field_id, 
            $request->booking_date, 
            $request->start_time, 
            $request->end_time
        );
        
        if ($scheduleConflict) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'This time slot is not available according to field schedule. Please select another time.'
            ], 409);
        }
        
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
            DB::rollBack();
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

    /**
     * Check if a time slot is available according to schedule details
     */
    private function checkScheduleAvailability($fieldId, $date, $startTime, $endTime)
    {
        // Get the field's default schedule
        $field = SportField::with('defaultSchedule')->findOrFail($fieldId);
        
        // Check if there are any schedule details that override the default for this date
        $scheduleDetails = ScheduleDetail::whereHas('schedule', function($query) use ($field) {
            $query->where('id', $field->default_schedule_id);
        })
        ->where('start_date', '<=', $date)
        ->where('end_date', '>=', $date)
        ->get();
        
        // If no specific schedule details, use default schedule
        if ($scheduleDetails->isEmpty()) {
            return false; // Default schedule is always available
        }
        
        // Check each schedule detail that applies to this date
        foreach ($scheduleDetails as $detail) {
            // If status is unavailable, check if our booking time overlaps
            if ($detail->status === 'unavailable') {
                $detailStartTime = $detail->start_time;
                $detailEndTime = $detail->end_time;
                
                // Check for time overlap
                if ($this->timesOverlap($startTime, $endTime, $detailStartTime, $detailEndTime)) {
                    return true; // There's a conflict
                }
            }
        }
        
        return false; // No conflicts found
    }
    
    /**
     * Check if two time ranges overlap
     */
    private function timesOverlap($start1, $end1, $start2, $end2)
    {
        return ($start1 < $end2) && ($end1 > $start2);
    }

    public function getBookedSlots(Request $request, $fieldId)
    {
        $date = $request->query('date');
        $timezone = 'Asia/Beirut';
        $now = now()->timezone($timezone);
        
        if (!$date) {
            return response()->json(['success' => false, 'message' => 'Date parameter is required'], 400);
        }
        
       
            // Get field and its schedule
            $field = SportField::with('defaultSchedule')->findOrFail($fieldId);
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
            
            // Get schedule details for this date
            $scheduleDetails = ScheduleDetail::whereHas('schedule', function($query) use ($field) {
                $query->where('id', $field->default_schedule_id);
            })
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->get();
            
            // Format booked slots from actual bookings
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
            
            // Add unavailable slots from schedule details
            foreach ($scheduleDetails as $detail) {
                if ($detail->status === 'unavailable') {
                    $detailStartTime = Carbon::parse($detail->start_time)->format('H:i');
                    $detailEndTime = Carbon::parse($detail->end_time)->format('H:i');
                    
                    // Generate all slots within this unavailable period
                    $unavailableStart = Carbon::parse($detail->start_time);
                    $unavailableEnd = Carbon::parse($detail->end_time);
                    
                    $currentSlot = $unavailableStart->copy();
                    while ($currentSlot < $unavailableEnd) {
                        $slotKey = $currentSlot->format('H:i');
                        $slotEnd = $currentSlot->copy()->addMinutes($slotDuration);
                        
                        // Only add if the slot is completely within the unavailable period
                        if ($slotEnd <= $unavailableEnd) {
                            $bookedSlots[$slotKey] = $slotEnd->format('H:i');
                        }
                        
                        $currentSlot->addMinutes($slotDuration);
                    }
                }
            }
            
            // Handle past time slots for today
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
                'field_id' => $fieldId,
                'schedule_info' => [
                    'has_custom_schedule' => $scheduleDetails->isNotEmpty(),
                    'unavailable_periods' => $scheduleDetails->where('status', 'unavailable')->map(function($detail) {
                        return [
                            'start_time' => $detail->start_time,
                            'end_time' => $detail->end_time,
                            'start_date' => $detail->start_date,
                            'end_date' => $detail->end_date
                        ];
                    })->values()
                ]
            ]);
            
       
    }
    
    // ... rest of your existing methods remain unchanged ...
    
    public function edit(Booking $booking)
    {
        // Fetch payment details for this booking
        $payment = DB::table('payments')->where('booking_id', $booking->id)->first();
        
        // Return the view with the booking and payment data
        return view('booking.edit', compact('booking', 'payment'));
    }

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
        
        // Check schedule availability for the new time slot
        $scheduleConflict = $this->checkScheduleAvailability(
            $booking->field_id, 
            $request->booking_date, 
            $request->start_time, 
            $request->end_time
        );
        
        if ($scheduleConflict) {
            DB::rollBack();
            return redirect()->back()->with('error', 'This time slot is not available according to field schedule. Please select another time.');
        }
        
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
            DB::rollBack();
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

    // ... rest of your existing methods remain unchanged ...
    
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

    public function getPaymentDetails($bookingId)
    {
        return DB::table('payments')
            ->where('booking_id', $bookingId)
            ->first();
    }

    public function showBooking($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $payment = $this->getPaymentDetails($bookingId);
        
        return view('booking.show', compact('booking', 'payment'));
    }

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

    private function updatePastBookingStatuses($playerId)
    {
        try {
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
    
    public static function getLastVisitedFields($playerId)
    {
        // Get the player's booking history, excluding cancelled bookings
        $bookings = Booking::where('player_id', $playerId)
                    ->where('status', '!=', 'cancelled')
                    ->orderBy('date', 'desc')
                    ->orderBy('start_time', 'desc')
                    ->get();
                    
        if ($bookings->isEmpty()) {
            return collect([]);
        }
        
        // Extract field IDs from bookings (without duplicates)
        $fieldIds = $bookings->pluck('field_id')->unique();
        
        // Get the fields the player has visited, preserving the order of most recently visited
        $lastVisitedFields = collect();
        foreach ($fieldIds as $fieldId) {
            $field = SportField::find($fieldId);
            if ($field) {
                $lastVisitedFields->push($field);
            }
            
            // Limit to 4 fields as that's what we display on the homepage
            if ($lastVisitedFields->count() >= 4) {
                break;
            }
        }
        
        return $lastVisitedFields;
    }
}