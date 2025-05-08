<x-layout title="Browse Tournaments">

    <div class="container py-4">
        <!-- Success/Error Messages -->
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
    
        <!-- Page Header -->
        <div class="card mb-4 border-0 bg-primary bg-gradient text-white">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="bg-white rounded-circle p-3">
                            <i class="fas fa-trophy fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="col">
                        <h1 class="mb-0">Browse Tournaments</h1>
                        <p class="lead mb-0">Find and join tournaments for your team</p>
                    </div>
                    <div class="col-md-3 text-md-end">
                        <a href="" class="btn btn-light">
                            <i class="fas fa-list me-1"></i> My Tournaments
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
<!-- Filters -->
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0">Filter Tournaments</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('tournaments.browse') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="sport_type" class="form-label">Sport Type</label>
                <select class="form-select" id="sport_type" name="sport_type">
                    
                    <option value="" {{ !$sportType ? 'selected' : '' }}>All Sports</option>
                    @foreach($sportTypes as $type)
                        <option value="{{ $type }}" {{ $sportType == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="" selected>All</option>
                    <option value="upcoming" {{ $status == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="ongoing" {{ $status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="past" {{ $status == 'past' ? 'selected' : '' }}>Past</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('tournaments.browse') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-redo me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>
        
        <!-- Tournaments List -->
        <div class="row g-4">
            @forelse($tournaments as $tournament)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-truncate" title="{{ $tournament->name }}">{{ $tournament->name }}</h5>
                            <span class="badge bg-{{ Carbon\Carbon::now()->gt($tournament->end_date) ? 'secondary' : (Carbon\Carbon::now()->lt($tournament->start_date) ? 'success' : 'primary') }}">
                                {{ Carbon\Carbon::now()->gt($tournament->end_date) ? 'Completed' : (Carbon\Carbon::now()->lt($tournament->start_date) ? 'Upcoming' : 'Ongoing') }}
                            </span>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span><i class="fas fa-calendar-alt me-2"></i> Start Date</span>
                                    <span class="text-primary">{{ \Carbon\Carbon::parse($tournament->start_date)->format('M j, Y') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span><i class="fas fa-calendar-check me-2"></i> End Date</span>
                                    <span class="text-primary">{{ \Carbon\Carbon::parse($tournament->end_date)->format('M j, Y') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span><i class="fas fa-layer-group me-2"></i> Rounds</span>
                                    <span class="text-primary">{{ $tournament->rounds }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span><i class="fas fa-users me-2"></i> Teams</span>
                                    @php
                                        // Get team count directly from the database for better performance
                                        $teamCount = DB::table('team_tournament')
                                                  ->where('tournament_id', $tournament->id)
                                                  ->count();
                                    @endphp
                                    <span class="text-primary">{{ $teamCount }} / {{ $tournament->team_count }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span><i class="fas fa-basketball-ball me-2"></i> Sport Type</span>
                                    <span class="text-primary">{{ ucfirst($tournament->sportField->type) }}</span>
                                </li>
                            </ul>
                            
                            @if($tournament->description)
                                <p class="text-muted small mb-0">{{ Str::limit($tournament->description, 100) }}</p>
                            @endif
                        </div>
                        <div class="card-footer">
                            <div class="d-grid gap-2">
                                <a href="{{ route('tournaments.show', $tournament->id) }}" class="btn btn-primary">
                                    <i class="fas fa-info-circle me-1"></i> View Details
                                </a>
                                
                                @php
                                     $isFull = ($tournament->team_count > 0) && ($teamCount >= $tournament->team_count);
                                    $isOpen = Carbon\Carbon::now()->lt($tournament->start_date);
                                    $teamAlreadyJoined = false;
                                    $userHasTeamInTournament = false;
                                    
                                    // Check if the user has a team and it has already joined
                                    if (auth()->check() && auth()->user()->hasTeam() && auth()->user()->team) {
                                        $userTeam = auth()->user()->team;
                                        $teamAlreadyJoined = DB::table('team_tournament')
                                                       ->where('team_id', $userTeam->id)
                                                       ->where('tournament_id', $tournament->id)
                                                       ->exists();
                                            
                                        // Check if user is the captain of their team
                                        $isCaptain = auth()->user()->isCaptainOfCurrentTeam();
                                        
                                        // Check if team's sport type matches tournament's sport field type
                                        $teamSportTypeMatches = $userTeam->sport_type === $tournament->sportField->type;
                                    } else {
                                        $isCaptain = false;
                                        $teamSportTypeMatches = false;
                                    }
                                @endphp
                                
                                @if($isOpen && !$isFull && !$teamAlreadyJoined && $isCaptain && $teamSportTypeMatches)
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#joinModal{{ $tournament->id }}">
                                        <i class="fas fa-plus me-1"></i> Join Tournament
                                    </button>
                                @elseif($isOpen && $teamAlreadyJoined)
                                    <button class="btn btn-outline-secondary" disabled>
                                        <i class="fas fa-check-circle me-1"></i> Already Joined
                                    </button>
                                @elseif($isOpen && !$teamSportTypeMatches && $isCaptain)
                                    <button class="btn btn-outline-secondary" disabled>
                                        <i class="fas fa-exclamation-triangle me-1"></i> Incompatible Sport Type
                                    </button>
                                @elseif($isOpen && !$isCaptain && auth()->check() && auth()->user()->hasTeam())
                                    <button class="btn btn-outline-secondary" disabled>
                                        <i class="fas fa-user-shield me-1"></i> Captains Only
                                    </button>
                                @elseif($isOpen && $isFull)
                                    <button class="btn btn-outline-secondary" disabled>
                                        <i class="fas fa-users-slash me-1"></i> Tournament Full
                                    </button>
                                @elseif($isOpen && (!auth()->check() || !auth()->user()->hasTeam()))
                                    <a href="{{ route('teams.create') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-plus-circle me-1"></i> Create Team to Join
                                    </a>
                                @else
                                    <button class="btn btn-outline-secondary" disabled>
                                        <i class="fas fa-lock me-1"></i> Registration Closed
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Join Tournament Modal -->
                @if($isOpen && !$isFull && !$teamAlreadyJoined && $isCaptain && $teamSportTypeMatches)
                <div class="modal fade" id="joinModal{{ $tournament->id }}" tabindex="-1" aria-labelledby="joinModalLabel{{ $tournament->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="joinModalLabel{{ $tournament->id }}">Join {{ $tournament->name }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                            <form action="{{ route('tournaments.join', $tournament->id) }}" method="POST" class="join-tournament-form">
                                @csrf
                                <input type="hidden" name="team_id" value="{{ $userTeam->id }}">
                                
                                <div class="modal-body">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i> You are about to register <strong>{{ $userTeam->name }}</strong> for this tournament.
                                    </div>
                                    
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i> <strong>Note:</strong> You can only register one team per tournament.
                                    </div>
                                    
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i> By joining this tournament, you agree to participate in all scheduled matches during the tournament period.
                                    </div>
                                    
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i> This tournament is for <strong>{{ $tournament->sportField->type }}</strong> teams only.
                                    </div>
                                    
                                    @if($tournament->birthdate_from && $tournament->birthdate_to)
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle me-2"></i> <strong>Age Requirement:</strong> Players must be born between 
                                            {{ \Carbon\Carbon::parse($tournament->birthdate_from)->format('M j, Y') }} 
                                            and {{ \Carbon\Carbon::parse($tournament->birthdate_to)->format('M j, Y') }}.
                                        </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Join Tournament</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-trophy fa-4x text-muted mb-3"></i>
                            <h4>No Tournaments Found</h4>
                            <p class="text-muted">No tournaments match your current filter criteria.</p>
                            <a href="{{ route('tournaments.browse') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-redo me-2"></i> Reset Filters
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-4">
            {{ $tournaments->withQueryString()->links() }}
        </div>
    </div>
    
    <!-- JavaScript for Tournament Interactions -->
    <script>
        // Confirm joining a tournament
        document.addEventListener('DOMContentLoaded', function() {
            const joinForms = document.querySelectorAll('.join-tournament-form');
            joinForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Are you sure you want to join this tournament? Your team will be committed to all scheduled matches.')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
    
</x-layout>