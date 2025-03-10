<?php
/** @var Illuminate\Contracts\Pagination\Paginator $paginator */
/** @var Illuminate\Contracts\Pagination\Paginator[] $elements */
?>

@if ($paginator->hasPages())
    <nav aria-label="page-navigation">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if (!$paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            @if($paginator->currentPage() > 3)
                <li class="page-item"><a class="page-link" href="{{ $paginator->url( 1 ) }}">1</a></li>
            @endif
            @if($paginator->currentPage() > 4)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach( range( 1, $paginator->lastPage() ) as $i )
                @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                    @if ($i == $paginator->currentPage())
                        <li class="page-item" aria-current="page"><span class="page-link active">{{ $i }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endif
            @endforeach

            @if($paginator->currentPage() < $paginator->lastPage() - 3)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif
            @if($paginator->currentPage() < $paginator->lastPage() - 2)
                <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @endif
        </ul>
    </nav>
@endif
