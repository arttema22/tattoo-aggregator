<?php
/** @var \Illuminate\Support\Collection $videos */
/** @var \App\Models\Video $video */
?>

@extends( 'layouts.app' )

@section( 'content' )

    <div class="container">
        <div class="simple-page-wrapper">
            <div class="row">
                <div class="col-12">
                    <h1 class="mb-2">{{ $video->name }}</h1>
                    <div class="mb-3 video-salon-name">
                        Видео из салона: <a href="{{ route( 'salon.index', [ 'alias' => $video->contact->alias ] ) }}">{{ $video->contact->name }}</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-10">
                    <div class="video-wrapper">
                        {!! str_replace( [ '{%width%}', '{%height%}' ], [ '100%', '315' ], $video->html ) !!}
                    </div>
                </div>

                <div class="col-2">
                    @foreach( $videos as $item )
                        <a class="video-mini-item" href="{{ route( 'video.show', [ 'id' => $item->id ] ) }}" title="{{ $item->name }}">
                            <div class="video-mini-item-preview">
                                <img src="{{ $item->preview ?? '/images/video/default.png' }}" alt="video">
                            </div>
                            <div class="video-mini-item-name">
                                {{ $item->name }}
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="row">
                <div class="col-10">
                    @if ( $video->text !== '' )
                        <div class="h3 mb-4 mt-3">Тестовая расшифровка</div>

                        <p class="mb-4">{!! nl2br( $video->text ) !!}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
