@extends( 'layouts.app' )

@section( 'content' )

    <div class="search-wrapper main">
        @include( 'widget.search.bar' )
    </div>

    @include( 'widget.advantage' )

    @include( 'widget.feedback' )

    @include( 'widget.top-works.wrapper' )

    @include( 'widget.blog.wrapper' )

@endsection
