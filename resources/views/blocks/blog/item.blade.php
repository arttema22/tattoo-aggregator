<?php
/** @var array $banner */
/** @var string $title */
/** @var string $description */
/** @var string $alias */
?>

<div class="col-lg-4 mb-3" style="height: 460px;">
    <div class="grid-item">
        <div class="grid-item-img">
            <img src="{{ Storage::url( $banner[ 'thumbs' ][ 's' ][ 'path' ] ?? config( 'image.default.small.article' ) ) }}" alt="{{ $title }}">
        </div>
        <div class="grid-item-content" style="position: relative;">
            <h4>{{ $title }}</h4>
            <a class="button" href="/{{ $alias }}" style="position: absolute; bottom: 10px;">Читать!</a>
        </div>
    </div>
</div>
