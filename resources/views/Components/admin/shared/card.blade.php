<!-- resources/views/components/admin/shared/card.blade.php -->
@props(['title', 'tools' => null])

<div {{ $attributes->merge(['class' => 'card shadow-sm mb-4']) }}>
    @if(isset($title))
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{ $title }}</h5>
        @if($tools)
            <div class="card-tools">
                {{ $tools }}
            </div>
        @endif
    </div>
    @endif
    
    <div class="card-body">
        {{ $slot }}
    </div>
</div>