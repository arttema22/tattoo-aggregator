<div class="landing-salons-wrapper {{ $type ?? '' }}" style="min-height: calc(100vh - 220px);">

    @include( 'blocks.breadcrumbs' )

    <div class="container">
        <h1>{{ $caption ?? $title }}</h1>

        <div class="d-none d-md-block">
            <div id="map" style="width: 100%; height: 400px;"></div>
        </div>

        <div class="row">
            <div class="col-md-9">
                <div class="row search-results-wrapper">
                    @foreach( $salons ?? [] as $salon )
                        @include( 'blocks.catalog.item', $salon )
                    @endforeach
                </div>

                {{-- Пагинация --}}
                {{ $salons->appends( $_GET )->links() }}
            </div>
            <div class="col-md-3">
                @include( 'page.landing.blocks.salons.filters.wrapper' )
            </div>
        </div>
    </div>
</div>

<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey={{ config( 'vendor.yandex.map.token' ) }}" type="text/javascript"></script>

<script type="application/javascript">
    (()=>{
        const data = {!! json_encode( $all_salons->map( function ( $item ) { return [ 'name' => $item[ 'name' ], 'lat' => $item[ 'lat' ], 'lon' => $item[ 'lon' ], 'address' => $item[ 'address' ], 'url' => route( 'salon.index', [ 'alias' => $item[ 'alias' ] ] ) ]; } )->toArray() ) !!};

        const init = function() {
            let map = new ymaps.Map( 'map', {
                center: [ {{ $city->lat }}, {{ $city->lon }} ],
                zoom: 11,
                controls: []
            } );

            data.forEach( function( item ) {
                let point = new ymaps.Placemark( [ item.lat, item.lon ], {
                    hintContent: item.name,
                    balloonContentBody: [
                        '<address>',
                        '<strong>' + item.name + '</strong>',
                        '<br/>',
                        'Адрес: ' + item.address,
                        '<br/>',
                        '<a class="btn btn-outline-danger btn-sm mt-2" href="' + item.url + '">Перейти</a>',
                        '</address>',
                    ].join('')
                }, {
                    preset: 'islands#circleDotIcon',
                    iconColor: '#A1252F',
                    iconContentOffset: [0, 0],
                    iconContentSize: [30, 30],
                } );

                map.geoObjects.add( point );
            } );
        };

        ymaps.ready( init );
    })();
</script>
