<div class="container mb-4">
    <div id="breadcrumb" class="breadcrumb">
        @foreach( $breadcrumbs as $breadcrumb )
            <div class="d-inline-block">
                @if ( $breadcrumbs->last() !== $breadcrumb )
                    <a href="{{ $breadcrumb->link }}">{{ $breadcrumb->title }}</a>
                    <span class="separator">/</span>
                @else
                    <span>{{ $breadcrumb->title }}</span>
                @endif
            </div>
        @endforeach
    </div>
</div>