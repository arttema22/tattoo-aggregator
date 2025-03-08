<?php
/** @var Illuminate\Pagination\LengthAwarePaginator $salons */
/** @var string $filter_by */
/** @var \Illuminate\Support\Collection $city_group */
?>

@extends( 'layouts.app' )

@section( 'content' )

    <div class="container">
        <div class="simple-page-wrapper">
            <h1>Каталог салонов<span class="catalog-city">{{ isset( $filter_by ) ? ': ' . $filter_by : '' }}</span></h1>

            <div class="d-none d-md-block">
                <div id="map" style="width: 100%; height: 400px;"></div>
            </div>

            <div class="row">
                <div class="col-md-9">
                    <div class="row search-results-wrapper">
                        @foreach( $salons as $salon )
                            @include( 'blocks.catalog.item', $salon )
                        @endforeach
                    </div>

                    {{-- Пагинация --}}
                    {{ $salons->appends( $_GET )->links() }}
                </div>
                <div class="col-md-3">
                    @include( 'blocks.catalog.filter' )
                </div>
            </div>
        </div>
    </div>

    {{--@include( 'widget.find-specialist' )--}}

    @includeWhen(
        empty( $articles ),
        'widget.blog.wrapper',
        [
            'articles' => $articles
        ]
    )

    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey={{ config( 'vendor.yandex.map.token' ) }}" type="text/javascript"></script>

    @if ( $city_group->isNotEmpty() )
        <script type="application/javascript">
            (()=>{
                const data = {!! json_encode( $city_group->map( function ( $item ) { return [ 'url' => route( 'catalog.city', [ 'city' => $item[ 'alias' ] ] ), 'name' => $item[ 'name' ][ 'ru' ], 'count' => $item[ 'cnt' ], 'lat' => $item[ 'lat' ], 'lon' => $item[ 'lon' ] ]; } )->toArray() ) !!};

                const init = function() {
                    let map = new ymaps.Map( 'map', {
                        center: [ 55.76, 90.64 ],
                        zoom: 3,
                        controls: []
                    } );

                    data.forEach( function( item ) {
                        let point = new ymaps.Placemark( [ item.lat, item.lon ], {
                            hintContent: item.name
                        }, {
                            preset: 'islands#circleIcon',
                            iconColor: '#A1252F',
                            iconContentOffset: [0, 0],
                            iconContentSize: [30, 30],
                            iconContentLayout: ymaps.templateLayoutFactory.createClass('<div style="display: flex; align-items: center; justify-content: center; border-radius: 50%; width: 15px; height: 15px; color: black; font-weight: bold; font-size: 14px;">' + item.count + '</div>')
                        } );

                        point.events.add( 'click', function() {
                            window.location.href = item.url;
                        } );

                        map.geoObjects.add( point );
                    } );
                };

                ymaps.ready( init );
            })();
        </script>
    @else
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
    @endif

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
@endpush
