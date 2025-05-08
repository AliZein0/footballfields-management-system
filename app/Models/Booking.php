<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'details',
        'player_id',
        'field_id',
        'payment_code',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    /**
     * Get the player that owns the booking.
     */
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Get the field that is booked.
     */
    public function sportfield()
    {
        return $this->belongsTo(SportField::class, 'field_id');
    }

    /**
     * Get the payment associated with the booking.
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    
    /**
     * Calculate the duration of the booking in hours
     */
    public function getDurationAttribute()
    {
        $start = strtotime($this->start_time);
        $end = strtotime($this->end_time);
        
        return ($end - $start) / 3600; // Convert seconds to hours
    }
}