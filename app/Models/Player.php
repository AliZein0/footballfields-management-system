<?php
// app/Models/Player.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Player extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'team_id',
        'preferred_sports',
        'location',
        'phone_number',
        'member_since',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'preferred_sports' => 'array',
        'member_since' => 'date',
    ];

    /**
     * Get the user that the player profile belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }

    /**
     * Get the team that the player belongs to.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the bookings for the player.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function favoriteVenues(): BelongsToMany
{
    return $this->belongsToMany(SportField::class, 'player_favorite_venues');
}

    /**
     * Get the favorite venues for the player.
     */
    


    public function upcomingBookings()
    {
        return $this->bookings()->where('status', 'upcoming');
            // ->where('start_time', '>', now())
            // ->orderBy('start_time');
    }
    
    /**
     * Get the player's member since formatted.
     */
    protected function memberSinceFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->member_since ? $this->member_since->format('F Y') : null,
        );
    }
}



