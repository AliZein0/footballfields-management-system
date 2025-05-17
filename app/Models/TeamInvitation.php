<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamInvitation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_id',
        'player_id',
        'invited_by',
        'status',
        'responded_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'responded_at' => 'datetime',
    ];

    /**
     * Get the team that sent the invitation.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the player that received the invitation.
     */
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Get the user who sent the invitation.
     */
    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    /**
     * Scope a query to only include pending invitations.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Accept the invitation.
     */
    public function accept()
    {
        $this->status = 'accepted';
        $this->responded_at = now();
        $this->save();

        // Add player to the team
        $player = $this->player;
        $player->team_id = $this->team_id;
        $player->save();

        return $this;
    }

    /**
     * Decline the invitation.
     */
    public function decline()
    {
        $this->status = 'declined';
        $this->responded_at = now();
        $this->save();

        return $this;
    }
}