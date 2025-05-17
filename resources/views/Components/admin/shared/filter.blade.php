<!-- resources/views/components/admin/shared/filter.blade.php -->
@props(['action'])

<form action="{{ $action }}" method="GET">
    <div class="row g-3 mb-4">
        {{ $slot }}
        
        <div class="col-md-auto">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter me-1"></i> Filter
            </button>
            <a href="{{ $action }}" class="btn btn-secondary">
                <i class="fas fa-sync-alt me-1"></i> Reset
            </a>
        </div>
    </div>
</form>