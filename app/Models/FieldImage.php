<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldImage extends Model
{
    public function field()
{
    return $this->belongsTo(SportField::class);
}
}
