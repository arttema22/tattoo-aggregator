<?php
/** @var \App\Models\Contact $salon */
/** @var \App\Models\SocialNetwork[] $social_network */
?>

<div class="tab-pane fade" id="contact">
    <h2>Контакты</h2>
    @if ( $salon->site !== '' )
        <p>Сайт <a href="{{ $salon->site }}" target="_blank" rel="nofollow">{{ parse_url( $salon->site, PHP_URL_HOST ) }}</a></p>
    @endif

    @if ( $salon->phone !== '' )
        <div class="row">
            <div class="col-1">
                <p>Телефоны</p>
            </div>
            <div class="col-11">
                @foreach( explode( "\n", $salon->phone ) as $item )
                    <p>&nbsp;&nbsp;<a href="tel:{{ str_replace( [ ' ', '-', '+', '(', ')' ], '', $item ) }}" rel="nofollow">{{ $item }}</a></p>
                @endforeach
            </div>
        </div>
    @endif

   {{-- <p>По контактам не отвечают? Или салон закрылся? <a data-toggle="modal" data-target="#complaint">Пожалуйтесь здесь!</a></p>--}}
    <h2>Локация</h2>
    <p>{{ $salon->city?->name[ 'ru' ] ?? '-' }}</p>
    <p>{{ $salon->address }}</p>

    <div class="salon-map-wrapper">
        <div id="map" style="width: 100%; height: 400px;"></div>
        <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey={{ config( 'vendor.yandex.map.token' ) }}" type="text/javascript"></script>
        <script type="application/javascript">
            (()=>{
                const init = function() {
                    let map = new ymaps.Map( 'map', {
                        center: [ {{ $salon->lat }}, {{ $salon->lon }} ],
                        zoom: 15
                    } ) ;

                    let place =  new ymaps.Placemark( [ {{ $salon->lat }}, {{ $salon->lon  }} ], {
                        balloonContent: '{{ $salon->name }}'
                    }, {
                        preset: 'islands#circleDotIcon',
                        iconColor: '#A1252F',
                    } );

                    map.geoObjects.add( place );
                };

                ymaps.ready( init );
            })();
        </script>
    </div>

    @if( $social_network->isNotEmpty() )
    <h2>Социальные сети</h2>
    <div class="network-wrapper">
        @foreach( $social_network as $item )
            <a href="{{ $item->socialNetworkName->url . $item->value }}" target="_blank" rel="nofollow"><div class="network-item"><img src="/images/icons/{{ $item->socialNetworkName->alias }}.svg" alt="{{ $item->socialNetworkName->name }}" /></div></a>
        @endforeach
    </div>
    @endif
</div>
