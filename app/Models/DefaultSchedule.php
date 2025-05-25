<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_time',
        'to_time'
    ];

   

    /**
     * Get the sport fields that use this default schedule
     */
    public function sportFields()
    {
        return $this->hasMany(SportField::class, 'default_schedule_id');
    }

    /**
     * Get the schedule details for this default schedule
     */
    public function scheduleDetails()
    {
        return $this->hasMany(ScheduleDetail::class, 'schedule_id');
    }

    /**
     * Get schedule details for a specific date
     */
    public function scheduleDetailsForDate($date)
    {
        return $this->scheduleDetails()
                   ->forDate($date)
                   ->get();
    }

    /**
     * Check if a time slot is available on a specific date
     */
    public function isTimeSlotAvailable($date, $startTime, $endTime)
    {
        $unavailableDetails = $this->scheduleDetails()
                                  ->forDate($date)
                                  ->unavailable()
                                  ->get();

        foreach ($unavailableDetails as $detail) {
            if ($detail->overlapsWithTime($startTime, $endTime)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get all unavailable time slots for a specific date
     */
    public function getUnavailableSlots($date)
    {
        return $this->scheduleDetails()
                   ->forDate($date)
                   ->unavailable()
                   ->get()
                   ->map(function ($detail) {
                       return [
                           'start_time' => $detail->start_time,
                           'end_time' => $detail->end_time,
                           'formatted_time' => $detail->time_range
                       ];
                   });
    }
}