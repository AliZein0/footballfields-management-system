<?php

namespace App\Http\Controllers;

use App\Models\SportField;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\User;

class PlayerController extends Controller
{
    /**
     * Display the homepage with a list of players.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('players.index', [
            'fields' => SportField::all(),
        ]);
    }
    
    public function profile(Player $player)
    {
        return view('players.profile', [
            'player' => $player,
            'sportfield' => SportField::all(),
        ]);
    }
    
    public function edit($id)
    {
        $player = Player::findOrFail($id);
        
        // Get list of available sports for the dropdown
        $availableSports = [
            'tennis' => 'Tennis',
            'football' => 'Football',
            'basketball' => 'Basketball',
            'volleyball' => 'Volleyball',
        ];
        
        return view('players.edit', compact('player', 'availableSports'));
    }
    
    /**
     * Update the player profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $player = Player::findOrFail($id);
        $user = $player->user;
        
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'preferred_sports' => 'sometimes|array',
            'bio' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|max:2048',
        ]);
        
        // Update user data
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->address = $request->location;
        $user->save();
        
        // Update player data
        // Store preferred sports as a single sport value (for enum field)
        if ($request->has('preferred_sports') && !empty($request->preferred_sports)) {
            // If your DB column can only store a single value, just take the first one
            $player->sport = $request->preferred_sports[0];
        } else {
            $player->sport = null;
        }
        
        $player->bio = $request->bio;
        
        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
            $user->save();
        }
        
        $player->save();
        
        return redirect()->route('players.profile', $player->id)
            ->with('success', 'Profile updated successfully!');
    }

    public function browseAll($teamId)
{
    $team = Team::findOrFail($teamId);
    
    // Get all players who aren't already in this team
    $availablePlayers = Player::where(function($query) use ($teamId) {
            $query->whereNull('team_id')
                ->orWhere('team_id', '!=', $teamId);
        })
        ->with('user')
        ->paginate(10);
        
    return view('players.browse', compact('team', 'availablePlayers'));
}

/**
 * Add existing player to the team.
 */
public function storeToTeam(Request $request, $teamId)
{
    $team = Team::findOrFail($teamId);
    
    // Validate player selection
    $validated = $request->validate([
        'player_id' => 'required|exists:players,id',
    ]);
    
    // Get the player and assign to team
    $player = Player::findOrFail($validated['player_id']);
    $player->team_id = $team->id;
    $player->save();
    
    return redirect()->route('teams.show', $team->id)
        ->with('success', 'Player added to team successfully!');
}

public function show($teamId, $playerId)
{
    $team = Team::findOrFail($teamId);
    $player = Player::with(['user', 'favoriteVenues'])->findOrFail($playerId);
    
    // Format member since date for display
    $player->member_since_formatted = $player->member_since ? 
        $player->member_since->format('F j, Y') : null;
    
    return view('players.show', compact('team', 'player'));
}

/**
 * Show the player details.
 */


/**
 * Remove the player from the team (not deleting the player).
 */
public function removeFromTeam($teamId, $playerId)
{
    $team = Team::findOrFail($teamId);
    $player = Player::where('id', $playerId)
        ->where('team_id', $teamId)
        ->firstOrFail();
    
    // Just remove from team, don't delete the player
    $player->team_id = null;
    $player->save();
    
    return redirect()->route('teams.show', $team->id)
        ->with('success', 'Player removed from team successfully!');
}


/**
 * Log the player out and redirect to login page.
 *
 * @return \Illuminate\Http\RedirectResponse
 */
public function logout(Request $request)
{
    // Clear player session data
    $request->session()->forget('player_id');
    $request->session()->forget('player_name');
    $request->session()->forget('player_email');
    
    // Flash using with() method on redirect
    return redirect()->route('players.login')
        ->with('success', 'You have been successfully logged out.');
}


}