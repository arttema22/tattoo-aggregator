<div class="search-wrapper {{ $type ?? '' }}" style="min-height: calc(100vh - 220px);">
    @include( 'widget.search.bar', [ 'dictionaries' => $filters ] )

    @include( 'widget.search.result.wrapper' )
</div>
