<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'comment',
        'rating',
        'player_id',
        'field_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'rating' => 'integer',
    ];

    /**
     * Get the player who wrote the review.
     */
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Get the sport field being reviewed.
     */
    public function field()
    {
        return $this->belongsTo(SportField::class, 'field_id');
    }
    
    /**
     * Scope a query to include only reviews for a specific field.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $fieldId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForField($query, $fieldId)
    {
        return $query->where('field_id', $fieldId);
    }
    
    /**
     * Scope a query to only include reviews from a specific player.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $playerId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFromPlayer($query, $playerId)
    {
        return $query->where('player_id', $playerId);
    }
    
    /**
     * Scope a query to only include reviews with a minimum rating.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $minRating
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithMinRating($query, $minRating)
    {
        return $query->where('rating', '>=', $minRating);
    }
}