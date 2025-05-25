<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Player;
use App\Models\TeamInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamInvitationController extends Controller
{
    /**
     * Send an invitation to a player to join a team.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function invite(Request $request, $teamId)
    {
        $team = Team::findOrFail($teamId);
        
        // Check if the authenticated user is the team captain
        if (Auth::id() !== $team->captain_id) {
            return redirect()->route('teams.show', $team)
                ->with('error', 'Only the team captain can invite players.');
        }
        
        // Validate the player id
        $validated = $request->validate([
            'player_id' => 'required|exists:players,id',
        ]);
        
        // Check if player is already in a team
        $player = Player::find($validated['player_id']);
        if ($player->team_id) {
            return redirect()->route('teams.players.browse', $team->id)
                ->with('error', 'This player is already a member of a team.');
        }
        
        // Check if player already has a pending invitation
        if ($team->hasPendingInvitationFor($player->id)) {
            return redirect()->route('teams.players.browse', $team->id)
                ->with('info', 'This player already has a pending invitation to your team.');
        }
        
        // Create the invitation
        $invitation = $team->invitePlayer($player->id, Auth::id());
        
        if ($invitation) {
            return redirect()->route('teams.players.browse', $team->id)
                ->with('success', 'Invitation sent successfully.');
        } else {
            return redirect()->route('teams.players.browse', $team->id)
                ->with('error', 'Failed to send invitation.');
        }
    }
    
    /**
     * Display all pending invitations for a team.
     *
     * @param  int  $teamId
     * @return \Illuminate\View\View
     */
    public function teamInvitations($teamId)
    {
        $team = Team::findOrFail($teamId);
        
        // Check if the authenticated user is the team captain
        if (Auth::id() !== $team->captain_id) {
            return redirect()->route('teams.show', $team)
                ->with('error', 'Only the team captain can view invitations.');
        }
        
        $pendingInvitations = $team->pendingInvitations()->with('player.user')->get();
        
        return view('player.teams.invitations', compact('team', 'pendingInvitations'));
    }
    
    /**
     * Display all invitations for the authenticated player.
     *
     * @return \Illuminate\View\View
     */
    public function playerInvitations()
    {
        $player = Player::where('id', Auth::id())->firstOrFail();
        
        $pendingInvitations = $player->pendingTeamInvitations()->with(['team', 'inviter'])->get();
        
        return view('player.players.invitations', compact('player', 'pendingInvitations'));
    }
    
    /**
     * Accept a team invitation.
     *
     * @param  int  $invitationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept($invitationId)
    {
        $invitation = TeamInvitation::findOrFail($invitationId);
        
        // Check if the authenticated user is the invited player
        if (Auth::id() !== $invitation->player_id) {
            return redirect()->back()
                ->with('error', 'You do not have permission to accept this invitation.');
        }
        
        // Check if invitation is still pending
        if ($invitation->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'This invitation has already been responded to.');
        }
        
        // Check if player is already in a team
        $player = $invitation->player;
        if ($player->team_id) {
            $invitation->decline();
            return redirect()->back()
                ->with('error', 'You are already a member of a team. Leave your current team first.');
        }
        
        // Accept the invitation
        $invitation->accept();
        
        return redirect()->route('teams.show', $invitation->team_id)
            ->with('success', 'You have joined the team successfully!');
    }
    
    /**
     * Decline a team invitation.
     *
     * @param  int  $invitationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function decline($invitationId)
    {
        $invitation = TeamInvitation::findOrFail($invitationId);
        
        // Check if the authenticated user is the invited player
        if (Auth::id() !== $invitation->player_id) {
            return redirect()->back()
                ->with('error', 'You do not have permission to decline this invitation.');
        }
        
        // Check if invitation is still pending
        if ($invitation->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'This invitation has already been responded to.');
        }
        
        // Decline the invitation
        $invitation->decline();
        
        return redirect()->back()
            ->with('success', 'Invitation declined successfully.');
    }
    
    /**
     * Cancel a team invitation (by team captain).
     *
     * @param  int  $invitationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel($invitationId)
    {
        $invitation = TeamInvitation::with('team')->findOrFail($invitationId);
        
        // Check if the authenticated user is the team captain
        if (Auth::id() !== $invitation->team->captain_id) {
            return redirect()->back()
                ->with('error', 'Only the team captain can cancel invitations.');
        }
        
        // Check if invitation is still pending
        if ($invitation->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'This invitation has already been responded to.');
        }
        
        // Delete the invitation
        $invitation->delete();
        
        return redirect()->back()
            ->with('success', 'Invitation cancelled successfully.');
    }
}