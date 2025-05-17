<!-- resources/views/components/admin/bookings/status-badge.blade.php -->
@props(['status'])

@php
    $badgeClass = match($status) {
        'pending' => 'bg-warning',
        'completed' => 'bg-success',
        'rejected' => 'bg-danger',
        default => 'bg-secondary'
    };
@endphp

<span class="badge {{ $badgeClass }}">
    {{ ucfirst($status) }}
</span>