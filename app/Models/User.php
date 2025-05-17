<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'preferred_sports' => 'array',
    ];

    /**
     * Get the player profile associated with the user.
     * 
     * @return HasOne
     */
    public function player(): HasOne 
    {
        return $this->hasOne(Player::class, 'id', 'id');
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
            'id',      // Foreign key on players table (matching user id)
            'id',      // Primary key on teams table
            'id',      // Local key on users table
            'team_id'  // Foreign key on players table referencing teams
        );
    }

    /**
     * Get the user's role.
     * 
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if the user has a player profile with a team.
     * 
     * @return bool
     */
    public function hasTeam(): bool
    {
        return $this->player && $this->player->team_id !== null;
    }

    /**
     * Check if the user is a captain of their current team.
     * 
     * @return bool
     */
    public function isCaptainOfCurrentTeam(): bool
    {
        return $this->hasTeam() && $this->team && $this->id === $this->team->captain_id;
    }

    /**
     * Check if the user has a specific role.
     * 
     * @param string $roleName
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->name === $roleName;
    }

    /**
     * Scope a query to only include users with a specific role.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $roleName
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithRole($query, string $roleName)
    {
        return $query->whereHas('role', function($q) use ($roleName) {
            $q->where('name', $roleName);
        });
    }

    /**
     * Scope a query to only include users on a team.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnTeam($query)
    {
        return $query->whereHas('player', function($q) {
            $q->whereNotNull('team_id');
        });
    }

    /**
     * Scope a query to only include team captains.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCaptains($query)
    {
        return $query->whereHas('team', function($q) {
            $q->where('captain_id', 'users.id');
        });
    }

    /**
     * Get the tournaments the user's team is participating in.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function tournaments()
    {
        return $this->hasManyThrough(
            Tournament::class,
            Team::class,
            'captain_id',  // Foreign key on teams table
            'id',          // Primary key on tournaments table
            'id',          // Local key on users table
            'id'           // Local key on teams table
        )->with('pivot');
    }
}