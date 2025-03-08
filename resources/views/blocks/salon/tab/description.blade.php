<?php
/** @var \App\Models\Contact $salon */
/** @var \App\Models\AdditionalService $additional_service */
/** @var \Illuminate\Support\Collection $salons_nearby */
?>

<div class="tab-pane fade show active" id="description">

    @if ( !$salon->profile->approved )
    <div class="alert alert-success" role="alert" style="width: 90%;">
        Если вы являетесь владельцем данного салона, свяжитесь с нами по почте: <a class="alert-link" href="mailto:{{ config( 'contact.email' ) }}">{{ config( 'contact.email' ) }}</a>
    </div>
    @endif

    <h2>Описание компании</h2>
    <p>{!! nl2br( $salon->description ) !!}</p>

    <h2>Дополнительно</h2>
    <div class="salon-options-wrapper" style="width: 90%;">
        @foreach( $additional_service as $item )
            <div class="salon-options-item">
                <div>{{ $item->additionalServiceName->name }}</div>
                <div>
                    <img src="{{ asset( '/images/icons/check.svg' ) }}" alt="check">
                </div>
            </div>
        @endforeach
    </div>

    @if ( $salons_nearby->isNotEmpty() )
    <h2>Салоны рядом</h2>
    <div class="row search-results-wrapper">
        <div class="row">
            @foreach( $salons_nearby->sort( fn ( $a, $b ) => $a->distance <=> $b->distance ) as $salon_nearby )
                @include( 'blocks.catalog.item', [ 'salon' => $salon_nearby->salonNearby, 'distance' => $salon_nearby->distance ] )
            @endforeach
        </div>
    </div>
    @endif
</div>
