<!-- resources/views/components/admin/shared/breadcrumb.blade.php -->
@props(['items' => []])

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        
        @foreach($items as $label => $url)
            @if(!$loop->last)
                <li class="breadcrumb-item">
                    <a href="{{ $url }}">{{ $label }}</a>
                </li>
            @else
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $label }}
                </li>
            @endif
        @endforeach
    </ol>
</nav>