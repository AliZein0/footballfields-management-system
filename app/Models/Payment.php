<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_fee',
        'field_fee',
        'transfer_code',
        'transfer_type',
        'paid_at',
        'status',
        'admin_id',
        'booking_id'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    /**
     * Get the booking associated with the payment
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    
    /**
     * Get the total amount of the payment
     */
    public function getTotalAmount()
    {
        return $this->website_fee + $this->field_fee;
    }
}