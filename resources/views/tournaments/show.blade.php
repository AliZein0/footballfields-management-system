<x-layout title="{{ $tournament->name }} - Tournament Details">
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
    
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('tournaments.browse') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Tournaments
            </a>
        </div>
        
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
                        <h1 class="mb-0">{{ $tournament->name }}</h1>
                        @php
                            $status = Carbon\Carbon::now()->gt($tournament->end_date) ? 'Completed' : 
                                    (Carbon\Carbon::now()->lt($tournament->start_date) ? 'Upcoming' : 'Ongoing');
                        @endphp
                        <p class="lead mb-0">
                            <span class="badge bg-{{ $status == 'Completed' ? 'secondary' : ($status == 'Upcoming' ? 'success' : 'primary') }} me-2">
                                {{ $status }}
                            </span>
                            <span class="me-3">
                                <i class="fas fa-basketball-ball me-1"></i> {{ ucfirst($tournament->sportField->type) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Tournament Details -->
            <div class="col-lg-8">
                <!-- Basic Info Card -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Tournament Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="mb-1 text-muted"><i class="fas fa-calendar-alt me-2"></i> Dates</h6>
                                    <div class="d-flex justify-content-between">
                                        <span>Start:</span>
                                        <strong>{{ Carbon\Carbon::parse($tournament->start_date)->format('M j, Y') }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>End:</span>
                                        <strong>{{ Carbon\Carbon::parse($tournament->end_date)->format('M j, Y') }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Duration:</span>
                                        <strong>
                                            @php
    $startDate = Carbon\Carbon::parse($tournament->start_date);
    $endDate = Carbon\Carbon::parse($tournament->end_date);
    
    // Calculate the inclusive duration (including both start and end dates)
    $duration = $startDate->diffInDays($endDate) + 1;
@endphp
{{ $duration }} {{ Str::plural('day', $duration) }}
                                        </strong>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <h6 class="mb-1 text-muted"><i class="fas fa-users me-2"></i> Teams</h6>
                                    <div class="d-flex justify-content-between">
                                        <span>Registered:</span>
                                        <strong>{{ $tournament->teams->count() }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Capacity:</span>
                                        <strong>{{ $tournament->team_count }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Available Spots:</span>
                                        <strong class="{{ ($tournament->team_count - $tournament->teams->count()) > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ max(0, $tournament->team_count - $tournament->teams->count()) }}
                                        </strong>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="mb-1 text-muted"><i class="fas fa-layer-group me-2"></i> Structure</h6>
                                    <div class="d-flex justify-content-between">
                                        <span>Rounds:</span>
                                        <strong>{{ $tournament->rounds }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Sport:</span>
                                        <strong>{{ ucfirst($tournament->sportField->type) }}</strong>
                                    </div>
                                </div>
                                
                                @if($tournament->birthdate_from && $tournament->birthdate_to)
                                <div class="mb-3">
                                    <h6 class="mb-1 text-muted"><i class="fas fa-id-card me-2"></i> Age Requirements</h6>
                                    <div class="d-flex justify-content-between">
                                        <span>Born Between:</span>
                                        <strong>
                                            {{ Carbon\Carbon::parse($tournament->birthdate_from)->format('M j, Y') }}
                                            and
                                            {{ Carbon\Carbon::parse($tournament->birthdate_to)->format('M j, Y') }}
                                        </strong>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        @if($tournament->description)
                        <div class="mt-3">
                            <h6 class="mb-1 text-muted"><i class="fas fa-align-left me-2"></i> Description</h6>
                            <p>{{ $tournament->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Participating Teams Card -->
                <div class="card mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-users me-2"></i> Participating Teams</h5>
                        <span class="badge bg-primary">{{ $tournament->teams->count() }}/{{ $tournament->team_count }}</span>
                    </div>
                    <div class="card-body">
                        @if($tournament->teams->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Team</th>
                                            <th scope="col">Captain</th>
                                            <th scope="col">Players</th>
                                            <th scope="col">Joined On</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tournament->teams as $index => $team)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($team->logo)
                                                            <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="rounded-circle me-2" width="40" height="40">
                                                        @else
                                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                                                <i class="fas fa-users text-primary"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <strong>{{ $team->name }}</strong>
                                                            <div class="small text-muted">{{ ucfirst($team->sport_type) }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($team->captain)
                                                        {{ $team->captain->name }}
                                                    @else
                                                        <span class="text-muted">Not assigned</span>
                                                    @endif
                                                </td>
                                                <td>{{ $team->players->count() }}</td>
                                                <td>{{ Carbon\Carbon::parse($team->pivot->registered_at)->format('M j, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5>No Teams Yet</h5>
                                <p class="text-muted">No teams have joined this tournament yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Tournament Brackets (if ongoing or completed) -->
                @if(Carbon\Carbon::now()->gte($tournament->start_date))
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-sitemap me-2"></i> Tournament Brackets</h5>
                    </div>
                    <div class="card-body">
                        <!-- If brackets are available, show them here -->
                        <!-- This would need to be implemented based on your brackets data structure -->
                        <div class="text-center py-4">
                            <i class="fas fa-sitemap fa-3x text-muted mb-3"></i>
                            <h5>Brackets Coming Soon</h5>
                            <p class="text-muted">Tournament brackets will be displayed once the tournament begins.</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Join Tournament Card (if eligible) -->
                @php
                    $isFull = $tournament->teams->count() >= $tournament->team_count;
                    $isOpen = Carbon\Carbon::now()->lt($tournament->start_date);
                @endphp
                
                @if($isOpen && !$isFull && auth()->check() && $userEligibleTeams->count() > 0)
                <div class="card mb-4 border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Join Tournament</h5>
                    </div>
                    <div class="card-body">
                        <p>You have eligible teams that can join this tournament!</p>
                        
                        <form action="{{ route('tournaments.join', $tournament->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="team_id" class="form-label">Select Team</label>
                                <select class="form-select" id="team_id" name="team_id" required>
                                    <option value="">-- Select a team --</option>
                                    @foreach($userEligibleTeams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-plus me-1"></i> Join Tournament
                                </button>
                            </div>
                            
                            <div class="alert alert-info mt-3 mb-0">
                                <i class="fas fa-info-circle me-2"></i> By joining this tournament, you agree to participate in all scheduled matches during the tournament period.
                            </div>
                        </form>
                    </div>
                </div>
                @endif
                
                <!-- Tournament Status Card -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Tournament Status</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Status</span>
                                <span class="badge bg-{{ $status == 'Completed' ? 'secondary' : ($status == 'Upcoming' ? 'success' : 'primary') }}">
                                    {{ $status }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Registration</span>
                                <span class="badge bg-{{ $isOpen ? 'success' : 'secondary' }}">
                                    {{ $isOpen ? 'Open' : 'Closed' }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Capacity</span>
                                <span class="badge bg-{{ $isFull ? 'danger' : 'success' }}">
                                    {{ $isFull ? 'Full' : 'Available' }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Organizer Info Card -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i> Tournament Organizer</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-user fa-lg text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Tournament Administrator</h6>
                                <p class="text-muted mb-0">System Administrator</p>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fas fa-envelope me-1"></i> Contact Organizer
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Resources Card -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-link me-2"></i> Resources</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="fas fa-file-pdf text-danger me-3"></i>
                                <span>Tournament Rules</span>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="fas fa-map-marker-alt text-primary me-3"></i>
                                <span>Venue Information</span>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="fas fa-calendar-alt text-success me-3"></i>
                                <span>Schedule</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>