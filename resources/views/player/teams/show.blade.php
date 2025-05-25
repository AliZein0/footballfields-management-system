<x-layout title="{{ $team->name }}">
    <div class="container py-4">
        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    
        <!-- Team Header -->
        <div class="card mb-4 border-0 bg-primary bg-gradient text-white">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="team-logo rounded-circle bg-white p-2" style="width: 100px; height: 100px;">
                            @if($team->logo_path)
                                <img src="{{ asset('storage/' . $team->logo_path) }}" alt="{{ $team->name }}" class="img-fluid rounded-circle">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 bg-light rounded-circle">
                                    <span class="display-4 text-primary">{{ substr($team->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <h1 class="mb-0">{{ $team->name }}</h1>
                        <p class="mb-1 lead">
                            <i class="fas fa-{{ $team->sport_type === 'basketball' ? 'basketball-ball' : ($team->sport_type === 'football' ? 'futbol' : ($team->sport_type === 'tennis' ? 'table-tennis' : 'volleyball-ball')) }} me-2"></i>
                            {{ ucfirst($team->sport_type) }} Team
                        </p>
                        @if($team->motto)
                            <p class="font-italic mb-0">"{{ $team->motto }}"</p>
                        @endif
                    </div>
                    <div class="col-md-3 text-md-end mt-3 mt-md-0">
                        @if(Auth::id() === $team->captain_id)
                            <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-light me-2">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-light dropdown-toggle" type="button" id="teamActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="teamActionsDropdown">
                                    <li><a class="dropdown-item" href="{{ route('teams.players.browse', $team->id) }}"><i class="fas fa-user-plus me-2"></i> Invite Player</a></li>
                                    <li><a class="dropdown-item" href="{{ route('invitations.team', $team->id) }}"><i class="fas fa-envelope me-2"></i> Manage Invitations</a></li>
                                   <li><a class="dropdown-item" href="{{ route('teams.matches', $team->id) }}"><i class="fas fa-calendar-alt me-2"></i> View Matches</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('teams.destroy', $team->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-trash-alt me-2"></i> Delete Team
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <form action="{{ route('teams.leave', $team->id) }}" method="POST" class="d-inline leave-team-form">
                                @csrf
                                <button type="submit" class="btn btn-light">
                                    <i class="fas fa-sign-out-alt me-1"></i> Leave Team
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Team Dashboard Content -->
        <div class="row g-4">
            <!-- Team Details -->
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Team Information</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Sport</span>
                                <span class="text-primary">{{ ucfirst($team->sport_type) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Team Size</span>
                                <span class="text-primary">{{ $team->size }} Players</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Captain</span>
                                <span class="text-primary">{{ $team->captain->name }}</span>
                            </li>
                            @if($team->home_venue)
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Home Venue</span>
                                <span class="text-primary">{{ $team->home_venue }}</span>
                            </li>
                            @endif
                            @if($team->founded_date)
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Founded</span>
                                <span class="text-primary">{{ \Carbon\Carbon::parse($team->founded_date)->format('F j, Y') }}</span>
                            </li>
                            @endif
                        </ul>
    
                        @if($team->description)
                        <div class="mt-3">
                            <h6>About</h6>
                            <p class="text-muted">{{ $team->description }}</p>
                        </div>
                        @endif
    
                        @if($team->twitter_handle || $team->instagram_handle || $team->facebook_page)
                        <div class="mt-3">
                            <h6>Connect</h6>
                            <div class="d-flex gap-2">
                                @if($team->twitter_handle)
                                <a href="https://twitter.com/{{ $team->twitter_handle }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                @endif
                                @if($team->instagram_handle)
                                <a href="https://instagram.com/{{ $team->instagram_handle }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                @endif
                                @if($team->facebook_page)
                                <a href="https://facebook.com/{{ $team->facebook_page }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-facebook"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-sm btn-outline-secondary w-100">
                            <i class="fas fa-print me-1"></i> Print Team Profile
                        </a>
                    </div>
                </div>
            </div>
    
            <!-- Team Stats Overview -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Players</h5>
                        
                        @if(Auth::id() === $team->captain_id)
                            <div>
                                <a href="{{ route('invitations.team', $team->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fas fa-envelope me-1"></i> 
                                    Pending Invitations
                                    @php
                                        $pendingCount = $team->pendingInvitations()->count();
                                    @endphp
                                    @if($pendingCount > 0)
                                        <span class="badge bg-danger ms-1">{{ $pendingCount }}</span>
                                    @endif
                                </a>
                                <a href="{{ route('teams.players.browse', $team->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-user-plus me-1"></i> Invite Player
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        @if(isset($team->players) && count($team->players) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Player</th>
                                        <th>Location</th>
                                        <th>Preferred Sports</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($team->players as $player)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 14px;">
                                                    {{ substr($player->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $player->user->name }}</div>
                                                    <div class="small text-muted">{{ $player->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $player->user->address ?? 'Not specified' }}</td>
                                        <td>
                                            @if($player->sport)
                                                <span class="badge bg-light text-dark me-1">{{ $player->sport }}</span>
                                            @else
                                                <span class="text-muted">None specified</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('teams.players.show', [$team->id, $player->id]) }}" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if(Auth::id() === $team->captain_id && $player->id !== $team->captain_id)
                                                <form action="{{ route('teams.players.remove', [$team->id, $player->id]) }}" method="POST" class="d-inline delete-player-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-user-minus"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-users fa-4x text-muted"></i>
                            </div>
                            <h4>No Players Yet</h4>
                            <p class="text-muted">Start building your team by adding players</p>
                            <a href="{{ route('teams.players.browse', $team->id) }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i> Invite Players
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
    
               

<!-- Upcoming Games (Enhanced) -->
<div class="card">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Next Matches</h5>
        <a href="{{ route('teams.matches', $team->id) }}" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-calendar-alt me-1"></i> View All
        </a>
    </div>
    <div class="card-body">
        @php
            // Get next 3 upcoming matches for this team
            $upcomingMatches = DB::table('matches')
                ->join('tournaments', 'matches.tournament_id', '=', 'tournaments.id')
                ->join('teams as team_a', 'matches.team_a_id', '=', 'team_a.id')
                ->join('teams as team_b', 'matches.team_b_id', '=', 'team_b.id')
                ->join('sport_fields', 'tournaments.field_id', '=', 'sport_fields.id')
                ->where(function($query) use ($team) {
                    $query->where('matches.team_a_id', $team->id)
                          ->orWhere('matches.team_b_id', $team->id);
                })
                ->where('matches.date', '>=', now()->toDateString())
                ->whereNull('matches.winner_id')
                ->select(
                    'matches.*',
                    'tournaments.name as tournament_name',
                    'team_a.name as team_a_name',
                    'team_b.name as team_b_name',
                    'sport_fields.name as field_name',
                    'sport_fields.location as field_city'
                )
                ->orderBy('matches.date', 'asc')
                ->orderBy('matches.start_time', 'asc')
                ->limit(3)
                ->get();
        @endphp

        @if($upcomingMatches->count() > 0)
            <div class="list-group">
                @foreach($upcomingMatches as $match)
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-center">
                                    <small class="fw-bold">
                                        {{ $match->team_a_id == $team->id ? $match->team_b_name : $match->team_a_name }}
                                    </small>
                                    <div class="small text-muted">vs {{ $team->name }}</div>
                                </div>
                                <div class="text-center">
                                    <span class="badge bg-light text-dark">{{ $match->tournament_name }}</span>
                                    <div class="small text-muted">Round {{ $match->round }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="small text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($match->date)->format('M j, Y') }}
                            </div>
                            <div class="small text-muted">
                                <i class="fas fa-clock me-1"></i>
                                {{ \Carbon\Carbon::parse($match->start_time, 'H:i:s')->format('g:i A') }}
                            </div>
                            <div class="small text-muted">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $match->field_name }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('teams.matches', $team->id) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-calendar-alt me-1"></i> View All Matches
                </a>
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-calendar-times fa-4x text-muted"></i>
                </div>
                <h4>No Upcoming Matches</h4>
                <p class="text-muted">Your team doesn't have any scheduled matches at the moment.</p>
                <div>
                    <a href="{{ route('tournaments.browse') }}" class="btn btn-primary me-2">
                        <i class="fas fa-search me-2"></i>Browse Tournaments
                    </a>
                    <a href="{{ route('teams.matches', $team->id) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-history me-1"></i>View Match History
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
            </div>
        </div>
    
        <!-- Team Performance Metrics (empty state) -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Team Progress</h5>
                    </div>
                    <div class="card-body text-center py-5">
                        <i class="fas fa-chart-line fa-4x text-muted mb-3"></i>
                        <h4>No Data Available Yet</h4>
                        <p class="text-muted">Team statistics will appear here after you start recording game results.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Confirm delete
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to delete this team? This action cannot be undone.')) {
                    this.submit();
                }
            });
        });
        
        // Confirm remove player
        document.querySelectorAll('.delete-player-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to remove this player from the team?')) {
                    this.submit();
                }
            });
        });
        
        // Confirm leave team
        document.querySelectorAll('.leave-team-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to leave this team?')) {
                    this.submit();
                }
            });
        });
    </script>
    
</x-layout>