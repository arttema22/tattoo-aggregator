<?php
/** @var array $top_works */
?>

@foreach( $top_works as $item )
    @include( 'widget.top-works.carousel.wrapper', $item )
@endforeach
