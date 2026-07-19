@if ($paginator->hasPages())
<div class="announcement-pagination">
    <div class="page-number">
        @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
            @if ($page == $paginator->currentPage())
                <button type="button" class="number active" disabled>{{ $page }}</button>
            @else
                <a href="{{ $url }}" class="number">{{ $page }}</a>
            @endif
        @endforeach
    </div>

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="page-btn">Next <i class="fa-solid fa-arrow-right"></i></a>
    @endif
</div>
@endif
