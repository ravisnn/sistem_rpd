@if ($paginator->hasPages())
    <ul class="pagination">

        {{-- First Page --}}
        @if ($paginator->onFirstPage())
            <li class="disabled">
                <span class="page-link" 
                      style="background:#f7f7f7; color:#888; cursor:pointer;">
                    First
                </span>
            </li>
        @else
            <li><a class="page-link" href="{{ $paginator->url(1) }}">First</a></li>
        @endif

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <li class="disabled">
                <span class="page-link"
                      style="background:#f7f7f7; color:#888; cursor:pointer;">
                    &laquo;
                </span>
            </li>
        @else
            <li><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Numbering --}}
        @php
            $start = max($paginator->currentPage() - 2, 1);
            $end = min($paginator->currentPage() + 2, $paginator->lastPage());
            if ($start === 1) $end = min(5, $paginator->lastPage());
            if ($end === $paginator->lastPage()) $start = max($end - 4, 1);
        @endphp

        @for ($page = $start; $page <= $end; $page++)
            @if ($page == $paginator->currentPage())
                <li class="active">
                    <span class="page-link">{{ $page }}</span>
                </li>
            @else
                <li><a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
            @endif
        @endfor

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled">
                <span class="page-link"
                      style="background:#f7f7f7; color:#888; cursor:pointer;">
                    &raquo;
                </span>
            </li>
        @endif

        {{-- Last Page --}}
        @if ($paginator->currentPage() == $paginator->lastPage())
            <li class="disabled">
                <span class="page-link"
                      style="background:#f7f7f7; color:#888; cursor:pointer;">
                    Last
                </span>
            </li>
        @else
            <li><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">Last</a></li>
        @endif

    </ul>
@endif
