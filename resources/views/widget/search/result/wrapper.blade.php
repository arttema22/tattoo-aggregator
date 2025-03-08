<?php
/** @var Illuminate\Pagination\LengthAwarePaginator $search_result */
?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="row search-results-wrapper">
                @if( isset( $search_result ) )
                    @foreach( $search_result as $item )
                        @include( 'widget.search.result.item', $item )
                    @endforeach
                @endif

                @if( !isset( $search_result ) || $search_result->isEmpty() )
                    <div class="text-center" style="margin-top: 20px">По данному запросу ничего не найдено</div>
                @endif
            </div>
        </div>

        @include( 'widget.search.filter.wrapper' )
    </div>

    @if( isset( $search_result ) && !$search_result->isEmpty() )
        {{-- Пагинация --}}
        {{ $search_result->appends( $_GET )->links() }}
    @endif

    <div class="filter-tags flex-wrap">
        @foreach ( $related_filter_pages as $filter_page )
            <a
                href="{{ \App\Helpers\SearchRoutesHelper::getRouteForSlug( $type, $filter_page->slug ) }}"
                title="{{ $filter_page->title }}"
            >
                #{{ \App\Helpers\DictionaryHelper::getFilterNameBySlug( $dictionaries, $filter_page->slug ) }}
            </a>
        @endforeach
    </div>
</div>
