<?php
/** @var \Illuminate\Support\Collection $videos */
?>

<div class="tab-pane fade" id="video-gallery">
    <h2>Видео</h2>

    <div class="video-wrappers row">
        @foreach( $videos as $item )
            <div class="col-md-4 video-salon-item">
                <div class="video-item-preview">
                    <a data-fancybox="video-gallery" href="{{ $item->url }}">
                        <img src="{{ $item->preview ?? '/images/video/default.png' }}" alt="video">
                        <span class="play-video">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M188.3 147.1C195.8 142.8 205.1 142.1 212.5 147.5L356.5 235.5C363.6 239.9 368 247.6 368 256C368 264.4 363.6 272.1 356.5 276.5L212.5 364.5C205.1 369 195.8 369.2 188.3 364.9C180.7 360.7 176 352.7 176 344V167.1C176 159.3 180.7 151.3 188.3 147.1V147.1zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z" fill="white"/></svg>
                        </span>
                    </a>
                </div>
                <div class="video-item-name">
                    <div class="video-item-name-inner">
                        <a target="_blank" title="{{ $item->name }}" href="{{ route( 'video.show', [ 'id' => $item->id ] ) }}">{{ $item->name }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<template id="item-video">
    <div class="video-items col-md-4">
        <a data-fancybox="video-gallery" href="">
            <img src="" alt="">
        </a>
    </div>
</template>

<script type="application/javascript">
    (()=>{
        document.addEventListener( 'load', () => {
            Fancybox.bind('#video-gallery a', {});
        } )
    })();
</script>
