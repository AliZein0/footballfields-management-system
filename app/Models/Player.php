<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TeamInvitation;
class Player extends Model
{
    use HasFactory;

    // Define primary key if not using auto-incrementing 'id'
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id', // Make sure this is fillable if you're manually setting it
        'user_id',
        'team_id',
        'sport',
        'bio',
        'member_since',
        'location'
    ];

    protected $casts = [
        'member_since' => 'datetime',
    ];

    /**
     * Get the user that owns the player profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    /**
     * Get the team that the player belongs to.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the favorite venues for the player.
     */
    public function favoriteVenues()
    {
        return $this->belongsToMany(SportField::class, 'player_favorite_venues')
                    ->withPivot('last_visited')
                    ->withTimestamps();
    }

    /**
     * Get all pending team invitations for the player.
     */
    public function pendingTeamInvitations()
    {
        return $this->hasMany(TeamInvitation::class, 'player_id')->where('status', 'pending');
    }

    /**
     * Get all team invitations for the player.
     */
    public function teamInvitations()
    {
        return $this->hasMany(TeamInvitation::class, 'player_id');
    }

    /**
     * Check if the player has any pending team invitations.
     *
     * @return bool
     */
    public function hasPendingTeamInvitations()
    {
        return $this->pendingTeamInvitations()->exists();
    }

    /**
     * Check if the player has a pending invitation from a specific team.
     *
     * @param int $teamId
     * @return bool
     */
    public function hasPendingInvitationFrom($teamId)
    {
        return $this->pendingTeamInvitations()->where('team_id', $teamId)->exists();
    }

    /**
 * Get all the reviews written by the player.
 */
public function reviews()
{
    return $this->hasMany(Review::class);
}
}