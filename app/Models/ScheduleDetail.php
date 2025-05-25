<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ScheduleDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date', 
        'start_time',
        'end_time',
        'status',
        'schedule_id'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
    ];

    /**
     * Get the default schedule that owns this detail
     */
    public function schedule()
    {
        return $this->belongsTo(DefaultSchedule::class, 'schedule_id');
    }

    /**
     * Scope for available schedules
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope for unavailable schedules
     */
    public function scopeUnavailable($query)
    {
        return $query->where('status', 'unavailable');
    }

    /**
     * Scope for schedules that apply to a specific date
     */
    public function scopeForDate($query, $date)
    {
        return $query->where('start_date', '<=', $date)
                    ->where('end_date', '>=', $date);
    }

    /**
     * Check if this schedule detail overlaps with a given time range
     */
    public function overlapsWithTime($startTime, $endTime)
    {
        $detailStart = Carbon::parse($this->start_time)->format('H:i');
        $detailEnd = Carbon::parse($this->end_time)->format('H:i');
        
        return ($startTime < $detailEnd) && ($endTime > $detailStart);
    }

    /**
     * Get formatted time range for display
     */
    public function getTimeRangeAttribute()
    {
        $startTime = Carbon::parse($this->start_time)->format('g:i A');
        $endTime = Carbon::parse($this->end_time)->format('g:i A');
        
        return "{$startTime} - {$endTime}";
    }

    /**
     * Get formatted date range for display
     */
    public function getDateRangeAttribute()
    {
        if ($this->start_date->equalTo($this->end_date)) {
            return $this->start_date->format('M d, Y');
        }
        
        return $this->start_date->format('M d, Y') . ' - ' . $this->end_date->format('M d, Y');
    }
}