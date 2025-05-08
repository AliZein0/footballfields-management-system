<x-layout title="Player Details - {{ $player->user->name }}">
    <div class="container py-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('teams.show', $team->id) }}">{{ $team->name }}</a></li>
                <li class="breadcrumb-item active">{{ $player->user->name }}</li>
            </ol>
        </nav>

        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Player Header -->
        <div class="card mb-4 border-0 bg-primary bg-gradient text-white">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="avatar bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 32px;">
                            {{ substr($player->user->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="col">
                        <h1 class="mb-0">{{ $player->user->name }}</h1>
                        <p class="mb-0 lead">
                            Team Member
                        </p>
                        <p class="mb-0 small">
                            <i class="fas fa-clock me-2"></i> Member since {{ $player->member_since_formatted }}
                        </p>
                    </div>
                    <div class="col-md-auto text-md-end mt-3 mt-md-0">
                        <a href="{{ route('teams.show', $team->id) }}" class="btn btn-light me-2">
                            <i class="fas fa-arrow-left me-1"></i> Back to Team
                        </a>
                        <form action="{{ route('teams.players.remove', [$team->id, $player->id]) }}" method="POST" class="d-inline delete-player-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-light">
                                <i class="fas fa-user-minus me-1"></i> Remove from Team
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Player Details -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Player Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6 class="fw-bold">Name</h6>
                                <p>{{ $player->user->name }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="fw-bold">Email</h6>
                                <p>{{ $player->user->email }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="fw-bold">Phone Number</h6>
                                <p>{{ $player->phone_number ?? ($player->user->phone_number ?? 'Not specified') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="fw-bold">Location</h6>
                                <p>{{ $player->location ?? ($player->user->address ?? 'Not specified') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="fw-bold">Member Since</h6>
                                <p>{{ $player->member_since_formatted }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="fw-bold">Team</h6>
                                <p>{{ $team->name }}</p>
                            </div>
                            <div class="col-12 mb-3">
                                <h6 class="fw-bold">Preferred Sports</h6>
                                <div>
                                    @if($player->preferred_sports && is_array($player->preferred_sports))
                                        @foreach($player->preferred_sports as $sport)
                                            <span class="badge bg-primary me-1">{{ $sport }}</span>
                                        @endforeach
                                    @elseif($player->sport)
                                        <span class="badge bg-primary me-1">{{ $player->sport }}</span>
                                    @else
                                        <p>No preferred sports specified</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Player Stats/Activity -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Player Statistics</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Bookings</span>
                                <span class="badge bg-primary rounded-pill">{{ isset($player->upcomingBookings) ? count($player->upcomingBookings) : 0 }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Favorite Venues</span>
                                <span class="badge bg-primary rounded-pill">{{ isset($player->favoriteVenues) ? count($player->favoriteVenues) : 0 }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Team Membership</span>
                                <span class="text-success">Active</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Team Information</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">This player is currently a member of <strong>{{ $team->name }}</strong>, a {{ ucfirst($team->sport_type) }} team.</p>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('teams.show', $team->id) }}" class="btn btn-outline-primary">
                                <i class="fas fa-users me-2"></i>View Team
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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