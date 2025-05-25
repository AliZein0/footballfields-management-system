<x-layout title="Team Invitations - {{ $team->name }}">
    <x-player_header />
        <section>
    <div class="container py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Pending Invitations for {{ $team->name }}</h1>
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

        <!-- Invitations List -->
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Pending Invitations</h5>
                <a href="{{ route('teams.players.browse', $team->id) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-user-plus me-1"></i> Invite More Players
                </a>
            </div>
            <div class="card-body">
                @if($pendingInvitations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Player</th>
                                    <th>Invited On</th>
                                    <th>Invited By</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingInvitations as $invitation)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 14px;">
                                                {{ substr($invitation->player->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $invitation->player->user->name }}</div>
                                                <div class="small text-muted">{{ $invitation->player->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $invitation->created_at->format('M d, Y \a\t h:i A') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-2 bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 12px;">
                                                {{ substr($invitation->inviter->name, 0, 1) }}
                                            </div>
                                            {{ $invitation->inviter->name }}
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <form action="{{ route('invitations.cancel', $invitation->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-times me-1"></i> Cancel Invitation
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-paper-plane fa-4x text-muted"></i>
                        </div>
                        <h4>No Pending Invitations</h4>
                        <p class="text-muted">Your team doesn't have any pending invitations at the moment.</p>
                        <a href="{{ route('teams.players.browse', $team->id) }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i> Invite Players
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </section>
</x-layout>