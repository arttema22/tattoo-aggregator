<?php
/** @var \App\Models\Contact $salon */
/** @var int $distance */
?>

<div class="col-md-4 grid-item-wrapp">
    <div class="grid-item" style="position: relative;">
        @if( isset( $distance ) )
            <div class="salon-distance">
                @php
                    $result_distance = '';

                    if ( $distance < 10 ) {
                        $result_distance = 'несколько шагов';
                    } elseif ( $distance < 1000 ) {
                        $result_distance = $distance . ' м';
                    } else {
                        $result_distance = sprintf( '%.1f км', $distance / 1000 );
                    }
                @endphp
                {{ $result_distance }}
            </div>
        @endif

        <div class="grid-item-img salon-img">
            <a href="{{ route( 'salon.index', [ 'alias' => $salon->alias ] ) }}">
                <img src="{{ Storage::url( $salon->cover[ 'thumbs' ][ 's' ][ 'path' ] ?? config( 'image.default.small.profile' ) ) }}" alt="{{ $salon->name }}">
                <div class="salon-info">
                    <span class="salon-name">
                        {{ $salon->name }}
                    </span>
                    <span class="salon-city">
                        <i class="fa-solid fa-location-dot"></i>
                        {{ $salon->city?->name[ 'ru' ] ?? '-' }}
                    </span>
                </div>
            </a>
        </div>
        <div class="grid-item-content salon-address-full">
            <span class="salon-address">{{ $salon->address }}</span>
        </div>
    </div>
</div>
