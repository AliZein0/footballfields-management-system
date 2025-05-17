<!-- resources/views/components/admin/bookings/table.blade.php -->
@props(['bookings'])

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Player</th>
                <th>Field</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>
                        @if($booking->player && $booking->player->user)
                            {{ $booking->player->user->name }}
                        @else
                            <span class="text-muted">Unknown</span>
                        @endif
                    </td>
                    <td>
                        @if($booking->sportField)
                            {{ $booking->sportField->name }}
                        @else
                            <span class="text-muted">Unknown</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('Y-m-d') }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - 
                        {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                    </td>
                    <td>
                        <x-admin.bookings.status-badge :status="$booking->status" />
                    </td>
                    <td>
                        @if($booking->payment)
                            <x-admin.payments.status-badge :status="$booking->payment->status" />
                        @else
                            <span class="badge bg-secondary">Not Paid</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        @if($booking->status == 'upcoming')
                            <x-admin.bookings.status-dropdown :id="$booking->id" />
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No bookings found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>