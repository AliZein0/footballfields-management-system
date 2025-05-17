<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SportField extends Model
{
     use HasFactory;
    
    protected $fillable = [
        'fees', 'name', 'size', 'rating', 'location', 
        'mapEmbed', 'details', 'is_covered', 'main_image_path',
        'type', 'manager_id', 'default_schedule_id'
    ];
    
    /**
     * The possible location values
     */
    const LOCATIONS = [
        'kafartoun' => 'Kafartoun',
        'akroum' => 'Akroum',
        'al sehle' => 'Al Sehle',
        'kenya' => 'Kenya'
    ];
    
   
    public function getFormattedLocationAttribute()
    {
        return self::LOCATIONS[$this->location] ?? $this->location;
    }

      /**
     * Get the manager of the field.
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    

    public function images()
    {
    return $this->hasMany(FieldImage::class);
    }


 
    public function defaultSchedule()
    {
       
        return $this->belongsTo(DefaultSchedule::class, 'default_schedule_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class , 'field_id');
    }

    
    
    

}
