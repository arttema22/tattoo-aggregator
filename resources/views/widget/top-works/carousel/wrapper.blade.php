<?php
/** @var string $title */
/** @var string $type */
/** @var array $works */
?>

<div class="carusel-wrapper bg-white">
    <div class="container">
        <h2>{{ $title }}</h2>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row search-results-wrapper">
                    @if( isset( $works ) )
                        @include( 'widget.top-works.carousel.item', [ $works, $type ] )
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>