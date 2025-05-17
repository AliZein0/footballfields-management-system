<!-- resources/views/admin/users/show.blade.php -->
@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <x-admin.shared.breadcrumb :items="[
        'Users' => route('admin.users.index'), 
        $user->name => '#'
    ]" />
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">User Details: {{ $user->name }}</h1>
        <div>
           
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <x-admin.shared.card title="User Information">
                <div class="mb-3">
                    <h6>Name</h6>
                    <p>{{ $user->name }}</p>
                </div>
                
                <div class="mb-3">
                    <h6>Email</h6>
                    <p>{{ $user->email }}</p>
                </div>
                
                <div class="mb-3">
                    <h6>Role</h6>
                    <p><x-admin.users.role-badge :role="$user->role->name" /></p>
                </div>
                
                <div class="mb-3">
                    <h6>Status</h6>
                    <p>
                        <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                </div>
                
                <div class="mb-3">
                    <h6>Created At</h6>
                    <p>{{ $user->created_at->format('Y-m-d H:i:s') }}</p>
                </div>
                
                <div class="mb-3">
                    <h6>Last Updated</h6>
                    <p>{{ $user->updated_at->format('Y-m-d H:i:s') }}</p>
                </div>
            </x-admin.shared.card>
        </div>
        
        <div class="col-md-6">
            @if($user->role->name == 'player')
                <x-admin.shared.card title="Player Information">
                    @if($user->player)
                        <div class="mb-3">
                            <h6>Preferred Sports</h6>
                            <p>
                                @if($user->player->preferred_sports)
                                    @foreach(json_decode($user->player->preferred_sports) as $sport)
                                        <span class="badge bg-info me-1">{{ ucfirst($sport) }}</span>
                                    @endforeach
                                @else
                                    No preferred sports
                                @endif
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <h6>Team</h6>
                            <p>
                                @if($user->player->team)
                                    <a href="{{ route('admin.teams.show', $user->player->team_id) }}">
                                        {{ $user->player->team->name }}
                                    </a>
                                @else
                                    No team
                                @endif
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <h6>Location</h6>
                            <p>{{ $user->player->location ?? 'Not specified' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6>Phone Number</h6>
                            <p>{{ $user->player->phone_number ?? 'Not specified' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6>Member Since</h6>
                            <p>{{ $user->player->member_since ? $user->player->member_since->format('Y-m-d') : 'Not specified' }}</p>
                        </div>
                    @else
                        <p class="text-center">No player profile available</p>
                    @endif
                </x-admin.shared.card>
            @elseif($user->role->name == 'field_manager')
                <x-admin.shared.card title="Manager Information">
                    <h6>Managed Fields</h6>
                    <ul class="list-group">
                        @forelse($user->managedFields as $field)
                            <li class="list-group-item">
                                <a href="{{ route('admin.fields.show', $field->id) }}">
                                    {{ $field->name }} ({{ ucfirst($field->type) }})
                                </a>
                            </li>
                        @empty
                            <li class="list-group-item">No fields managed</li>
                        @endforelse
                    </ul>
                </x-admin.shared.card>
            @elseif($user->role->name == 'vendor')
                <x-admin.shared.card title="Vendor Information">
                    @if($user->vendor)
                        <div class="mb-3">
                            <h6>Business Type</h6>
                            <p>{{ $user->vendor->business_type }}</p>
                        </div>
                        
                        <h6>Permits</h6>
                        <ul class="list-group">
                            @forelse($user->vendor->permits as $permit)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>
                                            {{ $permit->tournament->name }}
                                        </span>
                                        <span class="badge bg-{{ $permit->status == 'approved' ? 'success' : 
                                                             ($permit->status == 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($permit->status) }}
                                        </span>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item">No permits</li>
                            @endforelse
                        </ul>
                    @else
                        <p class="text-center">No vendor profile available</p>
                    @endif
                </x-admin.shared.card>
            @endif
        </div>
    </div>
    
    @if($user->role->name == 'player')
        <div class="row mt-4">
            <div class="col-12">
                <x-admin.shared.card title="Recent Bookings">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Field</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->player->bookings()->latest()->take(5)->get() as $booking)
                                    <tr>
                                        <td>{{ $booking->id }}</td>
                                        <td>{{ $booking->sport_field->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('Y-m-d') }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $booking->status == 'upcoming' ? 'primary' : 
                                                                   ($booking->status == 'completed' ? 'success' : 'danger') }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($booking->payment)
                                                <span class="badge bg-{{ $booking->payment->status == 'completed' ? 'success' : 
                                                                       ($booking->payment->status == 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($booking->payment->status) }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">No Payment</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No bookings found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </x-admin.shared.card>
            </div>
        </div>
    @endif
</div>
@endsection