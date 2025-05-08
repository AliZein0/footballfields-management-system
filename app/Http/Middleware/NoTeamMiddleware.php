<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class NoTeamMiddleware
{
    /**
     * Handle an incoming request, ensuring the user doesn't already have a team.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            // User not logged in, redirect to login
            return redirect()->route('login')
                ->with('error', 'You must be logged in to create a team.');
        }

        $user = Auth::user();
        
        // Check if user is a captain of a team
        $captainedTeam = Team::where('captain_id', $user->id)->first();
        if ($captainedTeam) {
            return redirect()->route('teams.show', $captainedTeam)
                ->with('info', 'You already captain a team.');
        }
        
        // Check if user has a player profile with a team
        $player = Player::find($user->id);
        if ($player && $player->team_id) {
            return redirect()->route('teams.show', $player->team)
                ->with('info', 'You are already a member of a team.');
        }

        return $next($request);
    }
}