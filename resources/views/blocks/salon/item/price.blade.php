<?php
/** @var string $caption */
/** @var int $type */
/** @var \App\Models\Service[] $prices */
?>

<div class="accordion-item">
    <h3 class="accordion-header" id="heading-service-{{ $type }}">
        <div class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-service-{{ $type }}" aria-expanded="true" aria-controls="collapse-service-{{ $type }}">
            {{ $caption  }}
        </div>
    </h3>
    <div id="collapse-service-{{ $type }}" class="accordion-collapse collapse show" aria-labelledby="heading-service-{{ $type }}" data-bs-parent="#accordionServices">
        <div class="accordion-body">
            @foreach( $prices as $price )
                @if ( $price->type === $type )
                    <div class="salon-options-item">
                        <div>{{ $price->name }}</div>
                        <div>
                            @if ( $price->price !== '0.00' )

                                {{ $price->is_start_price === 1 ? 'от ' : '' }}
                                <strong>{{ number_format( $price->price, 0, '.', ' ' ) }}</strong>,
                                {{ $price->currency }}

                            @else

                                <i>уточняется</i>

                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
