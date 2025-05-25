{{-- teams/partials/match-card.blade.php --}}
<div class="card mb-3 {{ $match->status == 'upcoming'? 'border-success' : ($match->status == 'cancelled' ? 'border-danger' : ($match->date < now()->toDateString() && $match->status != 'completed' ? 'border-warning' : 'border-primary')) }}">
    <div class="card-body">
        <div class="row align-items-center">
            <!-- Match Info -->
            <div class="col-md-8">
                <div class="row align-items-center">
                    <!-- Team A -->
                    <div class="col-5 text-end">
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="me-3">
                                <h6 class="mb-0 {{ $match->team_a_id == $team->id ? 'fw-bold text-primary' : '' }}">
                                    {{ $match->team_a_name }}
                                </h6>
                                @if($match->team_a_id == $team->id)
                                    <small class="text-muted">(Your Team)</small>
                                @endif
                            </div>
                            <div class="team-logo bg-light rounded-circle p-2" style="width: 50px; height: 50px;">
                                @if($match->team_a_logo)
                                    <img src="{{ asset('storage/' . $match->team_a_logo) }}" alt="{{ $match->team_a_name }}" class="img-fluid rounded-circle">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 text-primary fw-bold">
                                        {{ substr($match->team_a_name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- VS / Score -->
                    <div class="col-2 text-center">
                        @if($match->status == 'completed' && $match->winner_id)
                            <!-- Match completed -->
                            <div class="badge bg-success fs-6 py-2 px-3">
                                FINAL
                            </div>
                            @if($match->winner_id == $team->id)
                                <div class="small text-success mt-1 fw-bold">WON</div>
                            @elseif($match->winner_id)
                                <div class="small text-danger mt-1">LOST</div>
                            @endif
                        @elseif($match->status == 'cancelled')
                            <!-- Match cancelled -->
                            <div class="badge bg-danger fs-6 py-2 px-3">
                                CANCELLED
                            </div>
                        @elseif($match->status == 'upcoming' && $match->date == now()->toDateString())
                            <!-- Match in progress -->
                            <div class="badge bg-info fs-6 py-2 px-3">
                                LIVE
                            </div>
                        @elseif($match->date < now()->toDateString() && $match->status == 'scheduled')
                            <!-- Match date passed but still scheduled -->
                            <div class="badge bg-warning text-dark fs-6 py-2 px-3">
                                PENDING
                            </div>
                        @else
                            <!-- Upcoming match -->
                            <div class="text-muted fs-5 fw-bold">
                                VS
                            </div>
                            <div class="small text-primary">
                                {{ \Carbon\Carbon::parse($match->date . ' ' . $match->start_time)->format('M j') }}
                            </div>
                        @endif
                    </div>

                    <!-- Team B -->
                    <div class="col-5">
                        <div class="d-flex align-items-center">
                            <div class="team-logo bg-light rounded-circle p-2 me-3" style="width: 50px; height: 50px;">
                                @if($match->team_b_logo)
                                    <img src="{{ asset('storage/' . $match->team_b_logo) }}" alt="{{ $match->team_b_name }}" class="img-fluid rounded-circle">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 text-primary fw-bold">
                                        {{ substr($match->team_b_name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h6 class="mb-0 {{ $match->team_b_id == $team->id ? 'fw-bold text-primary' : '' }}">
                                    {{ $match->team_b_name }}
                                </h6>
                                @if($match->team_b_id == $team->id)
                                    <small class="text-muted">(Your Team)</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Match Details -->
            <div class="col-md-4">
                <div class="text-md-end">
                    <!-- Tournament Name -->
                    <div class="mb-2">
                        <span class="badge bg-primary mb-1">{{ $match->tournament_name }}</span>
                        <div class="small text-muted">Round {{ $match->round }}</div>
                    </div>

                    <!-- Date and Time -->
                    <div class="mb-2">
                        <div class="small text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            {{ \Carbon\Carbon::parse($match->date)->format('l, F j, Y') }}
                        </div>
                        <div class="small text-muted">
                            <i class="fas fa-clock me-1"></i>
                            {{ \Carbon\Carbon::parse($match->start_time)->format('g:i A') }} - 
                            {{ \Carbon\Carbon::parse($match->end_time)->format('g:i A') }}
                        </div>
                    </div>

                    <!-- Venue -->
                    <div class="mb-2">
                        <div class="small text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $match->field_name }}, {{ $match->field_city }}
                        </div>
                    </div>

                    <!-- Status Badge -->
                    @if($match->status == 'completed' && $match->winner_id)
                        @if($match->winner_id == $team->id)
                            <span class="badge bg-success">
                                <i class="fas fa-trophy me-1"></i>Victory
                            </span>
                        @else
                            <span class="badge bg-danger">
                                <i class="fas fa-times me-1"></i>Defeat
                            </span>
                        @endif
                    @elseif($match->status == 'cancelled')
                        <span class="badge bg-danger">
                            <i class="fas fa-ban me-1"></i>Cancelled
                        </span>
                    @elseif($match->status == 'in_progress')
                        <span class="badge bg-info">
                            <i class="fas fa-play-circle me-1"></i>Live Now
                        </span>
                    @elseif($match->date < now()->toDateString() && $match->status == 'scheduled')
                        <span class="badge bg-warning text-dark">
                            <i class="fas fa-clock me-1"></i>Result Pending
                        </span>
                    @elseif($match->date == now()->toDateString())
                        <span class="badge bg-info">
                            <i class="fas fa-play me-1"></i>Today
                        </span>
                    @else
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-calendar me-1"></i>Scheduled
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Match Winner Highlight -->
        @if($match->status == 'completed' && $match->winner_id)
            <div class="row mt-3">
                <div class="col-12">
                    <div class="alert alert-success border-0 py-2 mb-0">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-trophy me-2"></i>
                            <strong>Winner: {{ $match->winner_name }}</strong>
                            @if($match->winner_id == $team->id)
                                <span class="ms-2 badge bg-warning text-dark">Your Victory!</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

     
    </div>
</div>
    <div class="card-body">
        <div class="row align-items-center">
            <!-- Match Info -->
            <div class="col-md-8">
                <div class="row align-items-center">
                    <!-- Team A -->
                    <div class="col-5 text-end">
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="me-3">
                                <h6 class="mb-0 {{ $match->team_a_id == $team->id ? 'fw-bold text-primary' : '' }}">
                                    {{ $match->team_a_name }}
                                </h6>
                                @if($match->team_a_id == $team->id)
                                    <small class="text-muted">(Your Team)</small>
                                @endif
                            </div>
                            <div class="team-logo bg-light rounded-circle p-2" style="width: 50px; height: 50px;">
                                @if($match->team_a_logo)
                                    <img src="{{ asset('storage/' . $match->team_a_logo) }}" alt="{{ $match->team_a_name }}" class="img-fluid rounded-circle">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 text-primary fw-bold">
                                        {{ substr($match->team_a_name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- VS / Score -->
                    <div class="col-2 text-center">
                        @if($match->winner_id)
                            <!-- Match completed -->
                            <div class="badge bg-success fs-6 py-2 px-3">
                                FINAL
                            </div>
                            @if($match->winner_id == $team->id)
                                <div class="small text-success mt-1 fw-bold">WON</div>
                            @elseif($match->winner_id)
                                <div class="small text-danger mt-1">LOST</div>
                            @endif
                        @elseif($match->date < now()->toDateString())
                            <!-- Match date passed but no winner -->
                            <div class="badge bg-warning text-dark fs-6 py-2 px-3">
                                PENDING
                            </div>
                        @else
                            <!-- Upcoming match -->
                            <div class="text-muted fs-5 fw-bold">
                                VS
                            </div>
                            <div class="small text-primary">
                                {{ \Carbon\Carbon::parse($match->date . ' ' . $match->start_time)->format('M j') }}
                            </div>
                        @endif
                    </div>

                    <!-- Team B -->
                    <div class="col-5">
                        <div class="d-flex align-items-center">
                            <div class="team-logo bg-light rounded-circle p-2 me-3" style="width: 50px; height: 50px;">
                                @if($match->team_b_logo)
                                    <img src="{{ asset('storage/' . $match->team_b_logo) }}" alt="{{ $match->team_b_name }}" class="img-fluid rounded-circle">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 text-primary fw-bold">
                                        {{ substr($match->team_b_name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h6 class="mb-0 {{ $match->team_b_id == $team->id ? 'fw-bold text-primary' : '' }}">
                                    {{ $match->team_b_name }}
                                </h6>
                                @if($match->team_b_id == $team->id)
                                    <small class="text-muted">(Your Team)</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Match Details -->
            <div class="col-md-4">
                <div class="text-md-end">
                    <!-- Tournament Name -->
                    <div class="mb-2">
                        <span class="badge bg-primary mb-1">{{ $match->tournament_name }}</span>
                        <div class="small text-muted">Round {{ $match->round }}</div>
                    </div>

                    <!-- Date and Time -->
                    <div class="mb-2">
                        <div class="small text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            {{ \Carbon\Carbon::parse($match->date)->format('l, F j, Y') }}
                        </div>
                        <div class="small text-muted">
                            <i class="fas fa-clock me-1"></i>
                            {{ \Carbon\Carbon::parse($match->start_time )->format('g:i A') }} - 
                            {{ \Carbon\Carbon::parse($match->end_time)->format('g:i A') }}
                        </div>
                    </div>

                    <!-- Venue -->
                    <div class="mb-2">
                        <div class="small text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $match->field_name }}, {{ $match->field_city }}
                        </div>
                    </div>

                    <!-- Status Badge -->
                    @if($match->winner_id)
                        @if($match->winner_id == $team->id)
                            <span class="badge bg-success">
                                <i class="fas fa-trophy me-1"></i>Victory
                            </span>
                        @else
                            <span class="badge bg-danger">
                                <i class="fas fa-times me-1"></i>Defeat
                            </span>
                        @endif
                    @elseif($match->date < now()->toDateString())
                        <span class="badge bg-warning text-dark">
                            <i class="fas fa-clock me-1"></i>Result Pending
                        </span>
                    @elseif($match->date == now()->toDateString())
                        <span class="badge bg-info">
                            <i class="fas fa-play me-1"></i>Today
                        </span>
                    @else
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-calendar me-1"></i>Scheduled
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Match Winner Highlight -->
        @if($match->winner_id)
            <div class="row mt-3">
                <div class="col-12">
                    <div class="alert alert-success border-0 py-2 mb-0">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-trophy me-2"></i>
                            <strong>Winner: {{ $match->winner_name }}</strong>
                            @if($match->winner_id == $team->id)
                                <span class="ms-2 badge bg-warning text-dark">Your Victory!</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>