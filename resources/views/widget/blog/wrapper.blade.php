<?php
/** @var array $articles */
?>

<div class="grid-wrapper blog ptb bg-white">
    <div class="container">
        <h2>Блог</h2>
        <div class="row">
            @foreach( $articles as $item )
                @include( 'widget.blog.item', $item )
            @endforeach
        </div>
    </div>
</div>
