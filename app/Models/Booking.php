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
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the field that owns the booking.
     */
    public function field()
    {
        return $this->belongsTo(SportField::class);
    }

    /**
     * Get the player that owns the booking.
     */
    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}