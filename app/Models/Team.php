<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sport_type',
        'size',
        'description',
        'home_venue',
        'founded_date',
        'logo_path',
        'motto',
        'captain_id',
        'twitter_handle',
        'instagram_handle',
        'facebook_page',
    ];

    protected $casts = [
        'founded_date' => 'date',
    ];

    /**
     * Get the team's captain.
     */
    public function captain()
    {
        return $this->belongsTo(User::class, 'captain_id');
    }

    /**
     * Get the players for the team.
     */
    public function players()
    {
        return $this->hasMany(Player::class);
    }

    /**
     * Get all pending invitations for the team.
     */
    public function pendingInvitations()
    {
        return $this->hasMany(TeamInvitation::class)->where('status', 'pending');
    }

    /**
     * Get all invitations for the team.
     */
    public function invitations()
    {
        return $this->hasMany(TeamInvitation::class);
    }

    /**
     * Check if a player has a pending invitation to this team.
     *
     * @param int $playerId
     * @return bool
     */
    public function hasPendingInvitationFor($playerId)
    {
        return $this->pendingInvitations()->where('player_id', $playerId)->exists();
    }

    /**
     * Invite a player to the team.
     *
     * @param int $playerId
     * @param int $invitedBy
     * @return TeamInvitation
     */
    public function invitePlayer($playerId, $invitedBy)
    {
        // Check if player already has a pending invitation
        if ($this->hasPendingInvitationFor($playerId)) {
            return null;
        }

        // Check if player is already in a team
        $player = Player::find($playerId);
        if ($player && $player->team_id) {
            return null;
        }

        // Create a new invitation
        return TeamInvitation::create([
            'team_id' => $this->id,
            'player_id' => $playerId,
            'invited_by' => $invitedBy,
            'status' => 'pending'
        ]);
    }
}