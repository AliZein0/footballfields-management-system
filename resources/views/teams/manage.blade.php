{{-- teams/manage.blade.php (for team captains) --}}
<x-layout title="{{ $team->name }} - Management">
    <div class="container py-4">
        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
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
                        <p class="mb-0 fw-bold">
                            <i class="fas fa-crown me-1"></i> You are the Team Captain
                        </p>
                        @if($team->motto)
                            <p class="font-italic mb-0">"{{ $team->motto }}"</p>
                        @endif
                    </div>
                    <div class="col-md-3 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-light me-2">
                            <i class="fas fa-edit me-1"></i> Edit Team
                        </a>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-light dropdown-toggle" type="button" id="teamActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="teamActionsDropdown">
                                <li><a class="dropdown-item" href="{{ route('teams.players.browse', $team->id) }}"><i class="fas fa-user-plus me-2"></i> Add Player</a></li>
                                <li><a class="dropdown-item" href="{{ route('invitations.team', $team->id) }}"><i class="fas fa-envelope me-2"></i> Manage Invitations</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-calendar-plus me-2"></i> Schedule Game</a></li>
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
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Team Dashboard Content -->
        <div class="row g-4">
            <!-- Team Details -->
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Team Information</h5>
                        <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
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
                                <span>Current Roster</span>
                                <span class="text-primary">{{ $team->players->count() }} / {{ $team->size }}</span>
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
                </div>
            </div>
    
            <!-- Team Management Panel -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Team Management</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('teams.players.browse', $team->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                                <div>
                                    <h6 class="mb-0"><i class="fas fa-user-plus text-primary me-2"></i> Add Players</h6>
                                    <p class="text-muted small mb-0">Invite new players to join your team</p>
                                </div>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </a>
                            
                            <a href="{{ route('invitations.team', $team->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                                <div>
                                    <h6 class="mb-0">
                                        <i class="fas fa-envelope text-primary me-2"></i> Pending Invitations
                                        @php
                                            $pendingCount = $team->pendingInvitations()->count();
                                        @endphp
                                        @if($pendingCount > 0)
                                            <span class="badge bg-primary ms-2">{{ $pendingCount }}</span>
                                        @endif
                                    </h6>
                                    <p class="text-muted small mb-0">Manage sent invitations</p>
                                </div>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </a>
                            
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                                <div>
                                    <h6 class="mb-0"><i class="fas fa-calendar-alt text-primary me-2"></i> Schedule Games</h6>
                                    <p class="text-muted small mb-0">Book venues and schedule friendly matches</p>
                                </div>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </a>
                            
                            <a href="{{ route('tournaments.browse') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                                <div>
                                    <h6 class="mb-0"><i class="fas fa-trophy text-primary me-2"></i> Join Tournament</h6>
                                    <p class="text-muted small mb-0">Find and register for tournaments</p>
                                </div>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Team Players -->
                <div class="card">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Players</h5>
                        <a href="{{ route('teams.players.browse', $team->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-1"></i> Add Player
                        </a>
                    </div>
                    <div class="card-body">
                        @if($team->players->isNotEmpty())
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
                                                    <div class="fw-bold">
                                                        {{ $player->user->name }}
                                                        @if($player->id === $team->captain_id)
                                                            <span class="badge bg-warning text-dark ms-1">Captain</span>
                                                        @endif
                                                    </div>
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
                                            @if($player->id !== $team->captain_id)
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
                                <i class="fas fa-plus me-2"></i> Add Players
                            </a>
                        </div>
                        @endif
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
    </script>
</x-layout>