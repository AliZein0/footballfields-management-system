<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use Carbon\Carbon;
use App\Models\Team;
use App\Models\SportField;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class TournamentController extends Controller
{
    // TournamentController.php
    public function browse(Request $request)
    {
        // Get filter parameters (no defaults)
        $sportType = $request->input('sport_type');
        $status = $request->input('status');
        
        // Base query with sportField relationship
        $query = Tournament::with('sportField');
        
        // Apply filters only if values are provided
        if ($sportType) {
            // Join with sportField table and filter by type
            $query->whereHas('sportField', function($q) use ($sportType) {
                $q->where('type', $sportType);
            });
        }
        
        if ($status) {
            $now = Carbon::now();
            if ($status === 'upcoming') {
                $query->where('start_date', '>', $now);
            } elseif ($status === 'ongoing') {
                $query->where('start_date', '<=', $now)
                      ->where('end_date', '>=', $now);
            } elseif ($status === 'past') {
                $query->where('end_date', '<', $now);
            }
        }
        
        // Get tournaments with pagination
        $tournaments = $query->paginate(10);
        
        // Get unique sport types from sportField for the filter dropdown
        $sportTypes = SportField::distinct()->pluck('type');
        
        return view('tournaments.browse', compact('tournaments', 'sportType', 'status', 'sportTypes'));
    }
    // Method to handle tournament joining
// Method to handle tournament joining
public function join(Request $request, Tournament $tournament)
{
    $request->validate([
        'team_id' => 'required|exists:teams,id'
    ]);
         
    $team = Team::findOrFail($request->team_id);
    
    // Check if the user is the captain of this team
    if ($team->captain_id !== $this->user()->id) {
        return redirect()->back()->with('error', 'You can only register teams that you captain.');
    }
         
    // Check if team already joined
    if (DB::table('team_tournament')->where('team_id', $team->id)
                                   ->where('tournament_id', $tournament->id)
                                   ->exists()) {
        return redirect()->back()->with('error', 'This team has already joined the tournament.');
    }
         
    // Check if tournament is open for registration
    // Check if tournament is open for registration
if ($tournament->start_date && Carbon::now()->gt($tournament->start_date)) {
    return redirect()->back()->with('error', 'Registration for this tournament has closed.');
}
         
    // Check if tournament is full
   // Check if tournament is full
$currentTeamsCount = DB::table('team_tournament')
->where('tournament_id', $tournament->id)
->count();
     
if ($tournament->team_count > 0 && $currentTeamsCount >= $tournament->team_count) {
return redirect()->back()->with('error', 'This tournament is already full.');
}
    
    // Check if team's sport type matches tournament's sport field type
    if(!$tournament->sportField) {
        return redirect()->back()->with('error', 'Tournament\'s sport field not found.');
    }
    $tournamentSportType = $tournament->sportField->type;
    if ($team->sport_type !== $tournamentSportType) {
        return redirect()->back()->with('error', 'This team\'s sport type does not match the tournament\'s sport type.');
    }
         
    // Join tournament with current timestamp for registered_at
    DB::table('team_tournament')->insert([
        'team_id' => $team->id,
        'tournament_id' => $tournament->id,
        'registered_at' => Carbon::now()
    ]);
         
    return redirect()->back()->with('success', $team->name . ' has successfully joined the tournament!');
}
    /**
     * Get the authenticated user
     *
     * @return \App\Models\User|null
     */
    protected function user()
    {
        // Returns the authenticated user with their teams loaded
        return Auth::user();
    }
    
  /**
 * Show tournament details
 *
 * @param Tournament $tournament
 * @return \Illuminate\View\View
 */
public function show(Tournament $tournament)
{
    // Load tournament with related teams and their registration dates
    $tournament->load(['teams' => function($query) {
        $query->withPivot('registered_at')->orderBy('team_tournament.registered_at', 'asc');
    }, 'sportField']);
    
    // Load additional relationships for each team
    $tournament->teams->each(function($team) {
        $team->load(['captain', 'players']);
    });
    
    // Get user's eligible teams that haven't joined this tournament yet
    $userEligibleTeams = collect([]);
    
    if (Auth::check()) {
        $user = Auth::user();
        
        // Get the user's player profile
        $player = DB::table('players')->where('id', $user->id)->first();
        
        // Check if user has a player with a team
        if ($player && $player->team_id) {
            // Get the team
            $userTeam = Team::find($player->team_id);
            
            if ($userTeam) {
                // Check if this team hasn't already joined this tournament
                $alreadyJoined = DB::table('team_tournament')
                    ->where('team_id', $userTeam->id)
                    ->where('tournament_id', $tournament->id)
                    ->exists();
                
                // Check if user is the captain of this team
                $isCaptain = ($userTeam->captain_id === $user->id);
                
                // Check if team's sport type matches the tournament
                $sportTypeMatches = ($userTeam->sport_type === $tournament->sportField->type);
                
                // If all conditions are met, add team to eligible teams
                if (!$alreadyJoined && $isCaptain && $sportTypeMatches) {
                    $userEligibleTeams->push($userTeam);
                }
            }
        }
    }
    
    return view('tournaments.show', compact('tournament', 'userEligibleTeams'));
}




/**
 * Cancel team's registration from a tournament
 */
public function cancelRegistration(Request $request, Tournament $tournament)
{
    // Get the authenticated user's team
    $user = Auth::user();
   
        
        // Get the user's player profile
        $player = DB::table('players')->where('id', $user->id)->first();
    if (!$player->team_id) {
        return redirect()->route('tournaments.show', $tournament)
            ->with('error', 'You do not have a team to withdraw from this tournament.');
    }
    
    $team = $user->team;
    
    // Check if user is the team captain
    if ($user->id !== $team->captain_id) {
        return redirect()->route('tournaments.show', $tournament)
            ->with('error', 'Only the team captain can withdraw from tournaments.');
    }
    
    // Check if the team is actually registered for this tournament
    if (!$tournament->teams->contains($team->id)) {
        return redirect()->route('tournaments.show', $tournament)
            ->with('error', 'Your team is not registered for this tournament.');
    }
    
    // Check if tournament has already started
    if (Carbon::now()->gte($tournament->start_date)) {
        return redirect()->route('tournaments.show', $tournament)
            ->with('error', 'Cannot withdraw from a tournament that has already started.');
    }
    
    // Remove the team from the tournament
    $tournament->teams()->detach($team->id);
    
    return redirect()->route('tournaments.show', $tournament)
        ->with('success', 'Your team has been withdrawn from the tournament successfully.');
}





}