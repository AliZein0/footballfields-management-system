<x-layout title="Team Invitations">
    <div class="container py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Team Invitations</h1>
            <a href="" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
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

        <!-- Invitations List -->
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">Pending Team Invitations</h5>
            </div>
            <div class="card-body">
                @if($pendingInvitations->count() > 0)
                    <div class="list-group">
                        @foreach($pendingInvitations as $invitation)
                            <div class="list-group-item list-group-item-action">
                                <div class="row align-items-center">
                                    <div class="col-md-7">
                                        <div class="d-flex align-items-center">
                                            <div class="team-logo rounded-circle bg-primary text-white p-2 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                @if($invitation->team->logo_path)
                                                    <img src="{{ asset('storage/' . $invitation->team->logo_path) }}" alt="{{ $invitation->team->name }}" class="img-fluid rounded-circle">
                                                @else
                                                    <span class="h5 mb-0">{{ substr($invitation->team->name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $invitation->team->name }}</h6>
                                                <p class="text-muted small mb-0">
                                                    <i class="fas fa-{{ $invitation->team->sport_type === 'basketball' ? 'basketball-ball' : ($invitation->team->sport_type === 'football' ? 'futbol' : ($invitation->team->sport_type === 'tennis' ? 'table-tennis' : 'volleyball-ball')) }} me-1"></i>
                                                    {{ ucfirst($invitation->team->sport_type) }} Team
                                                </p>
                                                <p class="text-muted small mb-0">
                                                    <i class="fas fa-user me-1"></i> Invited by: {{ $invitation->inviter->name }}
                                                </p>
                                                <p class="text-muted small mb-0">
                                                    <i class="fas fa-clock me-1"></i> {{ $invitation->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 text-md-end mt-3 mt-md-0">
                                        <form action="{{ route('invitations.accept', $invitation->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-check me-1"></i> Accept
                                            </button>
                                        </form>
                                        <form action="{{ route('invitations.decline', $invitation->id) }}" method="POST" class="d-inline ms-2">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="fas fa-times me-1"></i> Decline
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-envelope-open fa-4x text-muted"></i>
                        </div>
                        <h4>No Pending Invitations</h4>
                        <p class="text-muted">You don't have any pending team invitations at the moment.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>