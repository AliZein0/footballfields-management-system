<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'location',
        'description',
        'status',
    ];

    public function sportField()
    {
        return $this->belongsTo(SportField::class, 'field_id');
    }

    public function teams()
    {
        // Fix: Changed the pivot table name from 'tournament_team' to 'team_tournament'
        return $this->belongsToMany(Team::class, 'team_tournament')
                    ->withPivot('registered_at');
    }
}