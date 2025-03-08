<?php
/** @var \App\Models\Contact $salon */
/** @var string $tab_id */
/** @var \App\Models\Album $album */
?>

<div class="tab-pane fade" id="{{ $tab_id }}">
    <h2>{{ $album->name  }}</h2>

    <div class="row galery-wrapper">

    </div>

    <div class="row justify-content-md-center">
        <button class="btn btn-dark w-25">Ещё</button>
    </div>
</div>

<template id="item-image">
    <div class="col-md-3">
        <div class="galery-item">
            <a href="#" data-fancybox="" data-src="" data-type="ajax">
                <img src="" alt="">
            </a>
        </div>
    </div>
</template>

<script type="application/javascript">
    (()=>{
        const count = {{ config( 'image.count' ) }};
        const path = '{{ Storage::url( config( 'image.thumbs.medium.path' ) ) }}';
        const gallery = {!! $album->files->map( function( $item ) use ( $salon, $album ) { return [ 'file' => $item->original, 'name' => $item->fileInfo?->name ?? '', 'description' => $item->fileInfo?->description ?? '', 'url' => route( 'work.short', [ 'salon' => $salon->alias, 'album_id' => $album->id, 'file_id' => $item->id ] ) ]; } )->toJson() !!};
        const template = document.querySelector( '#item-image' );
        const body = document.querySelector( '#{{ $tab_id }} .galery-wrapper' );

        let page = 0;

        const insert = ( data, template, body, start, end ) => {
            let wrap = document.createDocumentFragment()

            let i = start;
            for(  ; i < end; i++ ) {
                if ( !data[ i ] ) {
                    break;
                }

                let item = template.content.cloneNode( true );
                //item.querySelector( 'a' ).href = path + data[ i ].file;
                item.querySelector( 'a' ).dataset.src = data[ i ].url;
                item.querySelector( 'a' ).dataset.fancybox = '{{ $tab_id }}';
                item.querySelector( 'img' ).src = path + data[ i ].file;
                item.querySelector( 'img' ).alt = data[ i ].name ? data[ i ].name : '{{ str_replace( '-gallery', '', $tab_id ) }}';

                wrap.appendChild( item );
            }

            body.appendChild( wrap );
            return i;
        };

        const btnMore = function() {
            let last = page;
            page = insert( gallery, template, body, page, page + count );
            if ( page < ( last + count ) || gallery.length === page ) {
                this.parentNode.classList.add( 'd-none' );
            }
        };

        const btn = document.querySelector( '#{{ $tab_id }} button' );
        btn.addEventListener( 'click', btnMore, false );
        btn.click();

        document.addEventListener( 'load', () => {
            Fancybox.bind('#{{ $tab_id }} a', {
                ajax: { cache: true }
            });
        } )
    })();
</script>
