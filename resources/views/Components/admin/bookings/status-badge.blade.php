<!-- resources/views/components/admin/bookings/status-badge.blade.php -->
@props(['status'])

@php
    $badgeClass = match($status) {
        'upcoming' => 'bg-primary',
        'completed' => 'bg-success',
        'cancelled' => 'bg-danger',
        default => 'bg-secondary'
    };
@endphp

<span class="badge {{ $badgeClass }}">
    {{ ucfirst($status) }}
</span>