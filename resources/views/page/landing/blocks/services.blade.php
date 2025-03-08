<div class="cta-wrapper ptb bg-white">
    <div class="container">
        <h2>Оказываемые услуги</h2>

        @foreach( $prices as $price )

            <div class="salon-options-item">
                <div>{{ $price->name }}</div>
                <div>
                    @if ( $price->price !== '0.00' )

                        {{ $price->is_start_price ? 'от ' : '' }}
                        <strong>{{ number_format( $price->price, 0, '.', ' ' ) }}</strong>,
                        {{ $price->currency }}

                    @else

                        <i>уточняется</i>

                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>


