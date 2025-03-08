<?php
/** @var array $banner */
/** @var string $title */
/** @var string $description */
/** @var string $alias */
?>

<div class="col-lg-3" style="height: 500px;">
    <div class="grid-item">
        <div class="grid-item-img">
            <img src="{{ Storage::url( $banner[ 'thumbs' ][ 's' ][ 'path' ] ?? config( 'image.default.small.article' ) ) }}" alt="{{ $title }}" />
        </div>
        <div class="grid-item-content" style="position: relative;">
            <h3>{{ $title }}</h3>
            <a class="button" href="/{{ $alias }}" style="position: absolute; bottom: 10px;">Читать!</a>
        </div>
    </div>
</div>
