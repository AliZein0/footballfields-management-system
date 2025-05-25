<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TeamController extends Controller
{
    /**
     * Get current time in Beirut timezone
     */
    private function getCurrentBeirut()
    {
        return Carbon::now('Asia/Beirut');
    }

    /**
     * Get current date in Beirut timezone
     */
    private function getCurrentBeirutDate()
    {
        return Carbon::now('Asia/Beirut')->toDateString();
    }

    /**
     * Display a listing of teams.
     */
    public function index()
    {
        $teams = Team::with('captain')->paginate(10);
        return view('player.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new team.
     */
    public function create(Team $team = null)
    {
       $user = Auth::user();
    $player = Player::find($user->id);
    
    // Case 1: User has no team - Show team creation view
    if (!$player || !$player->team_id) {
        return view('player.teams.create');
    }
    
    // If no team is specified but user has a team, get the user's team
    if (!$team && $player->team_id) {
        $team = Team::find($player->team_id);
    }
    
    // Load team with related data
    $team->load(['captain', 'players.user']);
    
    // Case 2: User is the team captain - Show team management view
    if ($user->id === $team->captain_id) {
        return view('player.teams.manage', compact('team'));
    }
    // Case 3: User is a regular team member - Show team details view
     
    return view('player.teams.member', compact('team' ));
    }

    /**
     * Store a newly created team in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'teamName' => 'required|string|max:255',
            'sportType' => 'required|string',
            'teamSize' => 'required|integer',
            'teamDescription' => 'nullable|string',
            'homeVenue' => 'nullable|string|max:255',
            'foundingDate' => 'nullable|date',
            'teamLogo' => 'nullable|image|max:5120', // 5MB max
            'teamMotto' => 'nullable|string|max:255',
            'twitterHandle' => 'nullable|string|max:255',
            'instagramHandle' => 'nullable|string|max:255',
            'facebookPage' => 'nullable|string|max:255',
        ]);

        // Create a new team
        $team = new Team();
        $team->name = $validated['teamName'];
        $team->sport_type = $validated['sportType'];
        $team->size = $validated['teamSize'];
        $team->description = $validated['teamDescription'] ?? null;
        $team->home_venue = $validated['homeVenue'] ?? null;
        $team->founded_date = $validated['foundingDate'] ?? null;
        $team->motto = $validated['teamMotto'] ?? null;
        $team->twitter_handle = $validated['twitterHandle'] ?? null;
        $team->instagram_handle = $validated['instagramHandle'] ?? null;
        $team->facebook_page = $validated['facebookPage'] ?? null;
        $team->captain_id = Auth::id();

        // Handle logo upload if present
        if ($request->hasFile('teamLogo')) {
            $path = $request->file('teamLogo')->store('team-logos', 'public');
            $team->logo_path = $path;
        }

        // Start a transaction
        DB::beginTransaction();
        
        try {
            // Save the team
            $team->save();

            // Get the user and their player profile
            $user = Auth::user();
            $player = Player::find($user->id);

            // If the user doesn't have a player profile, create one
            if (!$player) {
                $player = new Player();
                // Since Player's primary key is defined as non-incrementing,
                // we need to manually set it to the user's ID
                $player->id = $user->id;
                $player->sport = $validated['sportType'];
            }

            // Update the player's team association
            $player->team_id = $team->id;
            $player->save();

            // Commit the transaction
            DB::commit();

            return redirect()->route('teams.show', $team)
                ->with('success', 'Team created successfully!');
        } catch (\Exception $e) {
            // Something went wrong, rollback
            DB::rollBack();
            
            return back()->withErrors(['error' => 'Failed to create team: ' . $e->getMessage()]);
        }
    }

    public function show(Team $team = null)
    {
        $user = Auth::user();
        $player = Player::find($user->id);
        
        // Case 1: User has no team - Show team creation view
        if (!$player || !$player->team_id) {
            return view('player.teams.create');
        }
        
        // If no team is specified but user has a team, get the user's team
        if (!$team && $player->team_id) {
            $team = Team::find($player->team_id);
        }
        
        // Load team with related data
        $team->load(['captain', 'players.user']);
        
        // Case 2: User is the team captain - Show team management view
        if ($user->id === $team->captain_id) {
            return view('player.teams.manage', compact('team'));
        }
        
        // Case 3: User is a regular team member - Show team details view
        return view('player.teams.member', compact('team'));
    }

    /**
     * Show the form for editing the specified team.
     */
    public function edit(Team $team)
    {
        // Authorization: only team captain can edit
        if (Auth::id() !== $team->captain_id) {
            return redirect()->route('teams.show', $team)
                ->with('error', 'You do not have permission to edit this team.');
        }

        return view('player.teams.edit', compact('team'));
    }

    /**
     * Update the specified team in storage.
     */
    public function update(Request $request, Team $team)
    {
        // Authorization: only team captain can update
        if (Auth::id() !== $team->captain_id) {
            return redirect()->route('teams.show', $team)
                ->with('error', 'You do not have permission to update this team.');
        }

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sport_type' => 'required|string',
            'size' => 'required|integer',
            'description' => 'nullable|string',
            'home_venue' => 'nullable|string|max:255',
            'founded_date' => 'nullable|date',
            'logo' => 'nullable|image|max:5120', // 5MB max
            'motto' => 'nullable|string|max:255',
            'twitter_handle' => 'nullable|string|max:255',
            'instagram_handle' => 'nullable|string|max:255',
            'facebook_page' => 'nullable|string|max:255',
        ]);

        // Handle logo upload if present
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($team->logo_path) {
                Storage::disk('public')->delete($team->logo_path);
            }
            
            $path = $request->file('logo')->store('team-logos', 'public');
            $team->logo_path = $path;
        }

        // Update team attributes
        $team->name = $validated['name'];
        $team->sport_type = $validated['sport_type'];
        $team->size = $validated['size'];
        $team->description = $validated['description'] ?? null;
        $team->home_venue = $validated['home_venue'] ?? null;
        $team->founded_date = $validated['founded_date'] ?? null;
        $team->motto = $validated['motto'] ?? null;
        $team->twitter_handle = $validated['twitter_handle'] ?? null;
        $team->instagram_handle = $validated['instagram_handle'] ?? null;
        $team->facebook_page = $validated['facebook_page'] ?? null;

        // Save the team
        $team->save();

        return redirect()->route('teams.show', $team)
            ->with('success', 'Team updated successfully!');
    }

    /**
     * Remove the specified team from storage.
     */
    public function destroy(Team $team)
    {
        // Authorization: only team captain can delete
        if (Auth::id() !== $team->captain_id) {
            return redirect()->route('teams.show', $team)
                ->with('error', 'Only the team captain can delete this team.');
        }

        // Start a transaction
        DB::beginTransaction();

        try {
            // Remove team association from all players
            Player::where('team_id', $team->id)->update(['team_id' => null]);

            // Delete team logo if exists
            if ($team->logo_path) {
                Storage::disk('public')->delete($team->logo_path);
            }

            // Delete the team
            $team->delete();

            // Commit the transaction
            DB::commit();

            return redirect()->route('dashboard')
                ->with('success', 'Team deleted successfully!');
        } catch (\Exception $e) {
            // Something went wrong, rollback
            DB::rollBack();
            
            return back()->withErrors(['error' => 'Failed to delete team: ' . $e->getMessage()]);
        }
    }

    /**
     * Add a player to the team.
     */
    public function addPlayer(Request $request, Team $team)
    {
        // Authorization: only team captain can add players
        if (Auth::id() !== $team->captain_id) {
            return redirect()->route('teams.show', $team)
                ->with('error', 'You do not have permission to add players to this team.');
        }

        // Validate the request
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Get the user
        $user = User::findOrFail($validated['user_id']);
        
        // Find or create player profile
        $player = Player::find($user->id);

        // If no player profile exists, create one
        if (!$player) {
            $player = new Player();
            $player->id = $user->id;
            $player->sport = $team->sport_type;
        } elseif ($player->team_id) {
            // Check if the player is already in a team
            return redirect()->route('teams.show', $team)
                ->with('error', 'This player is already a member of a team.');
        }

        // Add the player to the team
        $player->team_id = $team->id;
        $player->save();

        return redirect()->route('teams.show', $team)
            ->with('success', 'Player added to the team successfully!');
    }

    /**
     * Remove a player from the team.
     */
    public function removePlayer(Request $request, Team $team)
    {
        // Authorization: only team captain can remove players
        if (Auth::id() !== $team->captain_id) {
            return redirect()->route('teams.show', $team)
                ->with('error', 'You do not have permission to remove players from this team.');
        }

        // Validate the request
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Prevent removing the team captain
        if ($validated['user_id'] == $team->captain_id) {
            return redirect()->route('teams.show', $team)
                ->with('error', 'You cannot remove the team captain.');
        }

        // Get the player
        $player = Player::find($validated['user_id']);

        // Check if the player exists and is actually in this team
        if (!$player || $player->team_id != $team->id) {
            return redirect()->route('teams.show', $team)
                ->with('error', 'This player is not a member of this team.');
        }

        // Remove the player from the team
        $player->team_id = null;
        $player->save();

        return redirect()->route('teams.show', $team)
            ->with('success', 'Player removed from the team successfully!');
    }

    /**
     * Show the list of available players to invite.
     *
     * @param int $teamId
     * @return \Illuminate\View\View
     */
    public function browsePlayers($teamId)
    {
        $team = Team::findOrFail($teamId);
        
        // Authorization: only team captain can browse players
        if (Auth::id() !== $team->captain_id) {
            return redirect()->route('teams.show', $team)
                ->with('error', 'Only the team captain can add players to the team.');
        }
        
        // Get all players who aren't already in this team
        $availablePlayers = Player::whereNull('team_id')
            ->with(['user', 'pendingTeamInvitations' => function($query) use ($team) {
                $query->where('team_id', $team->id);
            }])
            ->paginate(10);
            
        return view('player.teams.browse_players', compact('team', 'availablePlayers'));
    }
    
    /**
     * Show the team members.
     *
     * @param int $teamId
     * @return \Illuminate\View\View
     */
    public function showPlayer(Team $team, Player $player)
    {
        return view('player.players.show', compact('team', 'player'));
    }
        
    /**
     * Leave the team (for players who are not captains).
     *
     * @param int $teamId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function leaveTeam($teamId)
    {
        $team = Team::findOrFail($teamId);
        $player = Player::where('id', Auth::id())->firstOrFail();
        
        // Check if player is in this team
        if ($player->team_id != $teamId) {
            return redirect()->route('dashboard')
                ->with('error', 'You are not a member of this team.');
        }
        
        // Prevent team captain from leaving
        if (Auth::id() == $team->captain_id) {
            return redirect()->route('teams.show', $team)
                ->with('error', 'As team captain, you cannot leave the team. You must either delete the team or transfer captaincy first.');
        }
        
        // Remove team association
        $player->team_id = null;
        $player->save();
        
        return redirect()->route('dashboard')
            ->with('success', 'You have left the team successfully.');
    }
    
    /**
     * Transfer team captaincy to another player.
     *
     * @param Request $request
     * @param int $teamId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function transferCaptaincy(Request $request, $teamId)
    {
        $team = Team::findOrFail($teamId);
        
        // Authorization: only team captain can transfer captaincy
        if (Auth::id() !== $team->captain_id) {
            return redirect()->route('teams.show', $team)
                ->with('error', 'Only the team captain can transfer captaincy.');
        }
        
        // Validate the new captain
        $validated = $request->validate([
            'new_captain_id' => 'required|exists:players,id',
        ]);
        
        $newCaptain = Player::where('id', $validated['new_captain_id'])
            ->where('team_id', $teamId)
            ->first();
        
        if (!$newCaptain) {
            return redirect()->route('teams.show', $team)
                ->with('error', 'The selected player is not a member of this team.');
        }
        
        // Transfer captaincy
        $team->captain_id = $newCaptain->id;
        $team->save();
        
        return redirect()->route('teams.show', $team)
            ->with('success', 'Team captaincy transferred successfully.');
    }

    public function showMatches(Team $team)
    {
        $user = Auth::user();
        $player = Player::find($user->id);
        
        // Check if user has access to view this team's matches
        if (!$player || ($player->team_id != $team->id && $user->id !== $team->captain_id)) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to view this team\'s matches.');
        }
        
        // Get current date in Beirut timezone
        $currentDate = $this->getCurrentBeirutDate();
        
        // Get all tournaments the team is participating in
        $tournaments = DB::table('tournaments')
            ->join('team_tournament', 'tournaments.id', '=', 'team_tournament.tournament_id')
            ->join('sport_fields', 'tournaments.field_id', '=', 'sport_fields.id')
            ->where('team_tournament.team_id', $team->id)
            ->select('tournaments.*', 'sport_fields.name as field_name', 'sport_fields.location as field_city')
            ->get();
        
        // Get all matches for this team
        $matches = DB::table('matches')
            ->join('tournaments', 'matches.tournament_id', '=', 'tournaments.id')
            ->join('teams as team_a', 'matches.team_a_id', '=', 'team_a.id')
            ->join('teams as team_b', 'matches.team_b_id', '=', 'team_b.id')
            ->leftJoin('teams as winner', 'matches.winner_id', '=', 'winner.id')
            ->join('sport_fields', 'tournaments.field_id', '=', 'sport_fields.id')
            ->where(function($query) use ($team) {
                $query->where('matches.team_a_id', $team->id)
                      ->orWhere('matches.team_b_id', $team->id);
            })
            ->select(
                'matches.*',
                'tournaments.name as tournament_name',
                'tournaments.start_date as tournament_start',
                'tournaments.end_date as tournament_end',
                'team_a.name as team_a_name',
                'team_a.logo_path as team_a_logo',
                'team_b.name as team_b_name', 
                'team_b.logo_path as team_b_logo',
                'winner.name as winner_name',
                'sport_fields.name as field_name',
                'sport_fields.location as field_city'
            )
            ->orderBy('tournaments.start_date', 'desc')
            ->orderBy('matches.date', 'asc')
            ->orderBy('matches.start_time', 'asc')
            ->get();
        
        // Group matches by tournament
        $matchesByTournament = $matches->groupBy('tournament_name');
        
        // Separate matches by status with proper logic
        $upcomingMatches = $matches->filter(function($match) use ($currentDate) {
            // Match is upcoming if:
            // 1. Status is 'upcoming' or 'scheduled'
            // 2. Date is today or in the future
            return in_array($match->status, ['upcoming', 'scheduled']) && 
                   $match->date >= $currentDate;
        });
        
        $completedMatches = $matches->filter(function($match) use ($currentDate) {
            // Match is completed if:
            // 1. Status is explicitly 'completed'
            // 2. Status is 'cancelled'
            // 3. Date has passed and status is still 'scheduled' or 'upcoming' (should be marked as pending)
            return $match->status === 'completed' || 
                   $match->status === 'cancelled' ||
                   ($match->date < $currentDate && in_array($match->status, ['scheduled', 'upcoming']));
        });
        
        // Calculate statistics
        $stats = [
            'total_matches' => $matches->count(),
            'wins' => $matches->where('status', 'completed')->where('winner_id', $team->id)->count(),
            'losses' => $matches->where('status', 'completed')
                              ->where('winner_id', '!=', null)
                              ->where('winner_id', '!=', $team->id)
                              ->count(),
            'upcoming' => $upcomingMatches->count(),
            'completed' => $completedMatches->where('status', 'completed')->count(),
            'cancelled' => $completedMatches->where('status', 'cancelled')->count(),
            'pending' => $completedMatches->filter(function($match) use ($currentDate) {
                return $match->date < $currentDate && in_array($match->status, ['scheduled', 'upcoming']);
            })->count(),
            'tournaments_count' => $tournaments->count(),
        ];
        
        return view('player.teams.matches', compact(
            'team', 
            'tournaments', 
            'matches', 
            'matchesByTournament', 
            'upcomingMatches', 
            'completedMatches',
            'stats'
        ));
    }
}