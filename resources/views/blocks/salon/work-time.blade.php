<div class="sidebar-work-time">
    <h2>Время работы:</h2>

    @foreach( $working_hours as $item )
        @if ( $item->is_nonstop )
            <div class="salon-options-item"><div>{{ \App\Helpers\WeekdayHelper::convertToString( $item->day ) }}</div><div>КРУГЛОСУТОЧНО</div></div>
        @elseif ( $item->is_weekend )
            <div class="salon-options-item"><div>{{ \App\Helpers\WeekdayHelper::convertToString( $item->day ) }}</div><div>ВЫХОДНОЙ</div></div>
        @elseif ( $item->start === null || $item->end === null )
            <div class="salon-options-item"><div>{{ \App\Helpers\WeekdayHelper::convertToString( $item->day ) }}</div><div>УТОЧНЯЕТСЯ</div></div>
        @else
            <div class="salon-options-item"><div>{{ \App\Helpers\WeekdayHelper::convertToString( $item->day ) }}</div><div>{{ sprintf( '%02s', $item->start ) }}:00 — {{ sprintf( '%02s', $item->end ) }}:00</div></div>
        @endif
    @endforeach
</div>
