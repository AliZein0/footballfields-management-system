<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Player;
use App\Models\SportField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function show($playerId, $fieldId){
        $field = SportField::where('id',$fieldId )->first();
        $player = User::where('id', $playerId)->first();
        return view('booking.show', compact('field', 'player'));

    }


    /**
     * Store a new booking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'field_id' => 'required|exists:sport_fields,id',
            'booking_date' => 'required|date|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'details' => 'nullable|string|max:1000',
            
        ]);

        try {
            // Begin a database transaction
            DB::beginTransaction();
            
            // Find the player by their code
            // $player = Player::where('code', $request->player_code)
            //     ->orWhere('wish_code', $request->player_code)
            //     ->first();
            
            // if (!$player) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Player code not found. Please check and try again.'
            //     ], 422);
            // }
            
            // Check if the time slot is already booked
            $conflictingBooking = Booking::where('field_id', $request->field_id)
                ->where('date', $request->booking_date)
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
                'player_id' => '11',
                'field_id' => $request->field_id,
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
            
        } catch (\Exception $e) {
            // Rollback the transaction if anything goes wrong
            DB::rollBack();
            Log::error('Booking creation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your booking. Please try again later.'
            ], 500);
        }
    }

    /**
     * Get booked slots for a specific date and field.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $fieldId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBookedSlots(Request $request, $fieldId)
    {
        $date = $request->query('date');
        
        if (!$date) {
            return response()->json([
                'success' => false,
                'message' => 'Date parameter is required'
            ], 400);
        }
        
        try {
            // Get all bookings for this field on the specified date
            $bookings = Booking::where('field_id', $fieldId)
                ->where('date', $date)
                ->get(['start_time', 'end_time']);
            
            // Format the data as a slots object
            $bookedSlots = [];
            foreach ($bookings as $booking) {
                $bookedSlots[$booking->start_time] = $booking->end_time;
            }
            
            return response()->json([
                'success' => true,
                'slots' => $bookedSlots
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error fetching booked slots: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch booked slots'
            ], 500);
        }
    }
}