<?php
/** @var int $id */
/** @var array $file */
/** @var string $name */
/** @var string $description */
?>

<div class="col-md-4 grid-item-wrapp">
    <div class="grid-item">
        <a
            href="#"
            class="grid-item-img"
            data-fancybox="search"
            data-type="ajax"
            data-src="{{ route( 'work.full', [
                'salon'    => $file[ 'fileable' ][ 'contact' ][ 'alias' ],
                'album_id' => $file[ 'fileable' ][ 'id' ],
                'file_id'  => $file[ 'id' ]
            ] ) }}"
        >
            <img src="{{ Storage::url( $file[ 'thumbs' ][ 'm' ][ 'path' ] ?? '' ) }}" alt="{{ $file[ 'fileable' ][ 'name' ] ?? '' }}">
        </a>
    </div>
</div>
