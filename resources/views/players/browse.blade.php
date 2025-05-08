<x-layout title="Browse Players - {{ $team->name }}">
    <div class="container py-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('teams.show', $team->id) }}">{{ $team->name }}</a></li>
                <li class="breadcrumb-item active">Browse Players</li>
            </ol>
        </nav>

        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Page Header -->
        <div class="card mb-4 border-0 bg-light">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0">Browse Available Players</h2>
                        <p class="text-muted mb-0">Add existing players to {{ $team->name }}</p>
                    </div>
                    <a href="{{ route('teams.show', $team->id) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Team
                    </a>
                </div>
            </div>
        </div>

        <!-- Players List -->
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Available Players</h5>
            </div>
            <div class="card-body p-0">
                @if(count($availablePlayers) > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Player</th>
                                <th>Location</th>
                                <th>Member Since</th>
                                <th>Sports</th>
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
                                <td>{{ $player->location ?? 'Not specified' }}</td>
                                <td>{{ $player->member_since ? $player->member_since->format('M d, Y') : 'N/A' }}</td>
                                <td>
                                    @if($player->preferred_sports && is_array($player->preferred_sports))
                                        @foreach($player->preferred_sports as $sport)
                                            <span class="badge bg-light text-dark me-1">{{ $sport }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">None specified</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <form action="{{ route('teams.players.store', $team->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="player_id" value="{{ $player->id }}">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus me-1"></i> Add to Team
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center p-3">
                    {{ $availablePlayers->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-users fa-4x text-muted"></i>
                    </div>
                    <h4>No Available Players Found</h4>
                    <p class="text-muted">There are no players available to add to your team at this time.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>