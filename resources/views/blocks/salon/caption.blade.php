<?php
/** @var \App\Models\Contact $salon */
?>

<div
    class="personal-page-header"
    style="background-image: url('{{ Storage::url( $salon->cover[ 'thumbs' ][ 'b' ][ 'path' ] ?? config( 'image.default.big.profile' ) ) }}');"
>
    <div class="overlay-bg">
        <div class="container">
            <h1>{{ $salon->name }}</h1>

            @if ( $salon->phone )
            <div class="salon-phone">
                @foreach( explode( "\n", $salon->phone ) as $item )
                    <div class="mb-2">
                        <img src="{{ asset( '/images/icons/phone.svg' ) }}" alt="phone">
                        <a href="tel:{{ str_replace( [ ' ', '-', '+', '(', ')' ], '', $item ) }}" rel="nofollow">{{ $item }}</a>
                    </div>
                @endforeach
            </div>
            @endif

            <div class="salon-address">
                <img src="{{ asset( '/images/icons/local.svg' ) }}" alt="{{ $salon->city?->name[ 'ru' ] ?? '' }}">
                {{ $salon->city?->name[ 'ru' ] ?? '-' }}
            </div>
        </div>
    </div>
</div>
