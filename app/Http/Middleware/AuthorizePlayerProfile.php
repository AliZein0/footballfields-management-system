<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthorizePlayerProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get player ID from route parameters
        $playerId = $request->route('player');
        
        if (!$playerId && $request->route('id')) {
            $playerId = $request->route('id');
        }
        
        if (!$playerId) {
            return redirect()->route('home')->with('error', 'Player not found.');
        }
        
        // Get the player
        $player = null;
        if (is_numeric($playerId)) {
            $player = Player::find($playerId);
        } elseif ($playerId instanceof Player) {
            $player = $playerId;
        }
        
        if (!$player) {
            return redirect()->route('home')->with('error', 'Player not found.');
        }
        
        // Check if current user is allowed to view this profile
        if (Auth::id() != $player->user_id) {
            return redirect()->route('home')->with('error', 'You are not authorized to view this profile.');
        }
        
        return $next($request);
    }
}