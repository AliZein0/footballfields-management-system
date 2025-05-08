<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'sport_type',
        'logo',
        'captain_id',
        // Add other fillable fields as needed
    ];

    /**
     * Get the team's captain.
     */
    public function captain()
    {
        return $this->belongsTo(User::class, 'captain_id');
    }

    /**
     * Get the team's players.
     */
    public function players()
    {
        return $this->hasMany(Player::class);
    }

    /**
     * Get tournaments that this team is participating in.
     */
    public function tournaments()
    {
        // Fix: Changed the pivot table name from 'tournament_team' to 'team_tournament'
        return $this->belongsToMany(Tournament::class, 'team_tournament')
                    ->withPivot('registered_at');
    }
}