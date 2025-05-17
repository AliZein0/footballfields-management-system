<!-- resources/views/components/admin/users/role-badge.blade.php -->
@props(['role'])

@php
    $badgeClass = match($role) {
        'admin' => 'bg-danger',
        'player' => 'bg-success',
        'field_manager' => 'bg-info',
        'vendor' => 'bg-warning',
        default => 'bg-secondary'
    };
@endphp

<span class="badge {{ $badgeClass }}">
    {{ ucfirst($role) }}
</span>