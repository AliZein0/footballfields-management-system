<x-layout title="Add Players to {{ $team->name }}">
    <x-player_header />
        <section>
    <div class="container py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Add Players to {{ $team->name }}</h1>
            <a href="{{ route('teams.show', $team->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Team
            </a>
        </div>

        <!-- Alert Messages -->
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

        @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle me-2"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Search Form -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('teams.players.browse', $team->id) }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" name="search" placeholder="Search by name" value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="sport">
                            <option value="">All Sports</option>
                            <option value="football" {{ request('sport') == 'football' ? 'selected' : '' }}>Football</option>
                            <option value="basketball" {{ request('sport') == 'basketball' ? 'selected' : '' }}>Basketball</option>
                            <option value="tennis" {{ request('sport') == 'tennis' ? 'selected' : '' }}>Tennis</option>
                            <option value="volleyball" {{ request('sport') == 'volleyball' ? 'selected' : '' }}>Volleyball</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('teams.players.browse', $team->id) }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-redo me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Players List -->
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Available Players</h5>
                <span class="badge bg-primary">{{ $availablePlayers->total() }} players found</span>
            </div>
            <div class="card-body">
                @if($availablePlayers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Player</th>
                                    <th>Location</th>
                                    <th>Preferred Sports</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($availablePlayers as $player)
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
                                    <td>
                                        @php
                                            $hasPendingInvitation = $player->pendingTeamInvitations->where('team_id', $team->id)->count() > 0;
                                        @endphp
                                        
                                        @if($hasPendingInvitation)
                                            <span class="badge bg-warning text-dark">Invited</span>
                                        @else
                                            <span class="badge bg-success">Available</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if($hasPendingInvitation)
                                            @php
                                                $invitation = $player->pendingTeamInvitations->where('team_id', $team->id)->first();
                                            @endphp
                                            <form action="{{ route('invitations.cancel', $invitation->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-ban me-1"></i> Cancel Invitation
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('invitations.invite', $team->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="player_id" value="{{ $player->id }}">
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-paper-plane me-1"></i> Send Invitation
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $availablePlayers->withQueryString()->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-users fa-4x text-muted"></i>
                        </div>
                        <h4>No Available Players Found</h4>
                        <p class="text-muted">Try adjusting your search criteria or check back later.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </section>
</x-layout>