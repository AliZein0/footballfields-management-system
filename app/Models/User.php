<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'location',
        'preferred_sports',
        'address',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the player profile associated with the user.
     * 
     * @return HasOne
     */
    public function player(): HasOne 
    {
        return $this->hasOne(Player::class, 'id');
    }

    /**
     * Get the team that the user belongs to via their player profile.
     * 
     * @return HasOneThrough
     */
    public function team(): HasOneThrough
    {
        return $this->hasOneThrough(
            Team::class,
            Player::class,
            'id', // Foreign key on players table
            'id',      // Foreign key on teams table
            'id',      // Local key on users table
            'team_id'  // Local key on players table
        );
    }

    /**
     * Check if the user has a player profile with a team.
     * 
     * @return bool
     */
    public function hasTeam(): bool
    {
        return $this->player && $this->player->team_id;
    }

    /**
     * Check if the user is a captain of their current team.
     * 
     * @return bool
     */
    public function isCaptainOfCurrentTeam(): bool
    {
        // Check if user has a team and is the captain of that team
        if ($this->hasTeam() && $this->team) {
            return $this->id === $this->team->captain_id;
        }
        
        return false;
    }
}