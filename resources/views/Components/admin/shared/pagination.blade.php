<!-- resources/views/components/admin/shared/pagination.blade.php -->
@props(['paginator'])
<style>
    .pagination {
        margin: 20px 0;
    }
    .pagination .page-item {
        margin: 0 2px;
    }
    .pagination .page-link {
        border-radius: 5px;
        padding: 10px 15px;
        background-color: #f8f9fa;
        color: #007bff;
    }
    .pagination .page-link:hover {
        background-color: #e2e6ea;
        color: #0056b3;
    }
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
    }
    
</style>
@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
                </li>
            @endif
            
            {{-- Pagination Elements --}}
            @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach
            
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif