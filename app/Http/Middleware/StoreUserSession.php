<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade

class StoreUserSession
{
    public function handle(Request $request, Closure $next)
    {
        // Use the Auth facade instead of the auth() helper
        if (Auth::check()) {
            $user = Auth::user();
            
            session([
                'user_id' => $user->id,
                'user_role' => $user->role_id
            ]);
            
            if ($user->role_id == 2 && $user->player) {
                session(['player_id' => $user->player->id]);
            }
        } else {
            session()->forget(['user_id', 'user_role', 'player_id']);
        }

        return $next($request);
    }
}