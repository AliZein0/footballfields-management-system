<x-layout title="{{ $team->name }} - Matches">
    <x-player_header />
    <section>
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

            <!-- Page Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('teams.show', $team->id) }}">{{ $team->name }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Matches</li>
                        </ol>
                    </nav>
                    <h1 class="h2 mb-0">
                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                        {{ $team->name }} Matches
                    </h1>
                    <p class="text-muted">View all matches from tournaments you're participating in</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('teams.show', $team->id) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Team
                    </a>
                </div>
            </div>

            <!-- Tournament Participation Summary -->
            @if($tournaments->count() > 0)
            <div class="row mb-4">
                <!-- Quick Stats -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-chart-bar me-2"></i>
                                Match Statistics
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 col-md-3">
                                    <div class="border-end">
                                        <h3 class="text-primary mb-0">{{ $stats['total_matches'] }}</h3>
                                        <small class="text-muted">Total Matches</small>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="border-end">
                                        <h3 class="text-success mb-0">{{ $stats['wins'] }}</h3>
                                        <small class="text-muted">Wins</small>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="border-end">
                                        <h3 class="text-danger mb-0">{{ $stats['losses'] }}</h3>
                                        <small class="text-muted">Losses</small>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <h3 class="text-info mb-0">{{ $stats['upcoming'] }}</h3>
                                    <small class="text-muted">Upcoming</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tournaments Summary -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-trophy me-2"></i>
                                Tournaments ({{ $stats['tournaments_count'] }})
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($tournaments->count() > 0)
                                @foreach($tournaments->take(3) as $tournament)
                                <div class="mb-2">
                                    <h6 class="mb-1 small">{{ $tournament->name }}</h6>
                                    <p class="text-muted mb-0 small">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($tournament->start_date)->format('M j') }} - 
                                        {{ \Carbon\Carbon::parse($tournament->end_date)->format('M j, Y') }}
                                    </p>
                                </div>
                                @if(!$loop->last)<hr class="my-2">@endif
                                @endforeach
                                
                                @if($tournaments->count() > 3)
                                <div class="text-center mt-2">
                                    <small class="text-muted">And {{ $tournaments->count() - 3 }} more...</small>
                                </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Matches Tabs -->
            <div class="card">
                <div class="card-header bg-light">
                    <ul class="nav nav-tabs card-header-tabs" id="matchesTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" type="button" role="tab" aria-controls="upcoming" aria-selected="true">
                                <i class="fas fa-clock me-1"></i>
                                Upcoming Matches
                                @if($upcomingMatches->count() > 0)
                                    <span class="badge bg-primary ms-1">{{ $upcomingMatches->count() }}</span>
                                @endif
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab" aria-controls="completed" aria-selected="false">
                                <i class="fas fa-check-circle me-1"></i>
                                Completed Matches
                                @if($completedMatches->count() > 0)
                                    <span class="badge bg-success ms-1">{{ $completedMatches->count() }}</span>
                                @endif
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="false">
                                <i class="fas fa-list me-1"></i>
                                All Matches
                                @if($matches->count() > 0)
                                    <span class="badge bg-secondary ms-1">{{ $matches->count() }}</span>
                                @endif
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="matchesTabContent">
                        <!-- Upcoming Matches -->
                        <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
                            @if($upcomingMatches->count() > 0)
                             
                                @foreach($upcomingMatches as $match)
                               
                                   <x-teams.partials.match-card :match="$match[0]" :team="$team" />
                                @endforeach
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                                    <h4>No Upcoming Matches</h4>
                                    <p class="text-muted">You don't have any scheduled matches at the moment.</p>
                                    <a href="{{ route('tournaments.browse') }}" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>Find Tournaments
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Completed Matches -->
                        <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                            @if($completedMatches->count() > 0)
                                @foreach($completedMatches as $match)
                                    <x-teams.partials.match-card :match="$match" :team="$team" />
                                @endforeach
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-history fa-4x text-muted mb-3"></i>
                                    <h4>No Completed Matches</h4>
                                    <p class="text-muted">You haven't completed any matches yet.</p>
                                </div>
                            @endif
                        </div>

                        <!-- All Matches -->
                        <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab">
                            @if($matchesByTournament->count() > 0)
                                @foreach($matchesByTournament as $tournamentName => $tournamentMatches)
                                    <div class="mb-4">
                                        <h5 class="border-bottom pb-2 mb-3">
                                            <i class="fas fa-trophy me-2 text-primary"></i>
                                            {{ $tournamentName }}
                                        </h5>
                                        @foreach($tournamentMatches as $match)
                                            <x-teams.partials.match-card :match="$match" :team="$team" />
                                        @endforeach
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-calendar-alt fa-4x text-muted mb-3"></i>
                                    <h4>No Matches Found</h4>
                                    <p class="text-muted">Your team hasn't participated in any tournaments with scheduled matches yet.</p>
                                    <a href="{{ route('tournaments.browse') }}" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>Browse Tournaments
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>