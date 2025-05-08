<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SportField extends Model
{
    public function images()
    {
    return $this->hasMany(FieldImage::class);
    }


 
    public function defaultSchedule()
    {
       
        return $this->belongsTo(DefaultSchedule::class, 'default_schedule_id');
    }


    
    
    

}
