<?php
/** @var \App\Models\Contact $salon */
/** @var int $contact_id */
/** @var int $country */
/** @var \Illuminate\Support\Collection $cities */
/** @var \Illuminate\Support\Collection $metro */
?>

@extends('layouts.app')

@section( 'active-contact-class', 'active' )

@section( 'content' )

    <div class="container">
        <div class="simple-page-wrapper pt-5 mb-5">
            <div class="row">
                <div class="col-md-9">
                    <h1>Редактирование контактов</h1>

                    <form
                        id="contacts"
                        name="contacts"
                        method="POST"
                        action="{{ route( 'account.profile.contact.update', [ 'contact_id' => $contact_id ] ) }}"
                        enctype="multipart/form-data"
                    >
                        @csrf

                        <input type="hidden" name="country_id" value="{{ $country }}">

                        <div class="address-items mt-5">
                            <div class="title24 mb-4">
                                Адрес
                            </div>
                            <p>Введите адрес и откорректируйте отметку на карте</p>

                            <div class="address-item">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input
                                            class="form-control"
                                            name="city"
                                            id="salon-city"
                                            placeholder="Город"
                                            type="text"
                                            list="cities"
                                            value="{{ $salon->city?->name[ 'ru' ] ?? '' }}"
                                        >
                                        <datalist id="cities">
                                            @foreach( $cities as $item )
                                                <option value="{{ $item[ 'name' ] }}">
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" name="address" placeholder="Адрес: улица, дом, офис / этаж" type="text" value="{{ $salon->address }}">
                                    </div>
                                </div>
                                <div id="tinkoMap"></div>
                            </div>
                        </div>

                        <div class="contacts mt-5">
                            <div class="title24 mb-4 mb-3">
                                Контактные данные
                            </div>
                            <p>Добавьте контактые данные в соответсвующих полях. Без них с вами не смогут связаться.</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <input class="form-control" name="email" placeholder="e-mail" type="email" value="{{ $salon->email }}">
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control" name="phone" placeholder="Телефоны" rows="3">{{ $salon->phone }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <input class="form-control" name="site" placeholder="Сайт" type="text" value="{{ $salon->site }}">
                                </div>
                                <div class="col-md-12 filter-form mb-3 {{ (!$salon->city?->has_metro ?? false) ? 'visually-hidden' : '' }}" id="metro-field">
                                    <select name="metro_id" style="border: 1px solid #000; background: #f8fafc; color: #212529; font-size: 0.9rem; outline: none;">
                                        <option {{ $salon->metro_id === 0 ? 'selected' : '' }} value="0">Метро</option>
                                        @foreach( $salon->city->metro ?? [] as $item )
                                            <option value="{{ $item->id }}" {{ $salon->metro_id === $item->id ? 'selected' : '' }}>{{ $item->name[ 'ru' ] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <input class="form-control" name="district" placeholder="Район" type="text" value="{{ $salon->district }}">
                                </div>

                                <input id="salon-lat" name="lat" type="hidden" value="{{ $salon->lat }}">
                                <input id="salon-lon" name="lon" type="hidden" value="{{ $salon->lon }}">
                            </div>
                        </div>

                        <div class="contacts mt-5">
                            <button class="button button-red mt-2" type="submit">Сохранить</button>
                        </div>
                    </form>
                </div>

                @include( 'account.menu-2' )
            </div>
        </div>
    </div>

    <script src="https://api-maps.yandex.ru/2.0-stable/?load=package.standard&amp;lang=ru_RU" type="application/javascript"></script>
    <script type="application/javascript">
        (()=>{
            const metro  = {!! $metro->toJson() !!};
            const citiesMetro = {!! $cities->where( 'has_metro', '=', 1 )->values()->toJson() !!};
            const cities = {!! $cities->toJson() !!};
            const field  = document.querySelector( '#metro-field' );
            const select = field.querySelector( 'select' );
            const city   = document.querySelector( '#salon-city' );
            const lat    = document.querySelector( '#salon-lat' );
            const lon    = document.querySelector( '#salon-lon' );

            let map      = null;
            let place    = null;

            // изменения в поле город
            city.addEventListener( 'change', function () {
                let cityHasMetro = citiesMetro.find( ( a ) => this.value === a.name );
                if ( !cityHasMetro ) {
                    field.classList.add( 'visually-hidden' );
                    return;
                }

                let wrap = document.createDocumentFragment();
                let default_option = document.createElement( 'option' );
                default_option.innerText = 'Метро';
                default_option.value = '0';
                wrap.append( default_option );

                metro.forEach( a => {
                    if ( a.city_id === cityHasMetro.id ) {
                        let option = document.createElement( 'option' );
                        option.value = a.id;
                        option.innerText = a.name;
                        wrap.append( option );
                    }
                } );

                select.innerHTML = '';
                select.append( wrap );
                field.classList.remove( 'visually-hidden' );
            }, false );

            city.addEventListener( 'change', function () {
                let cityCurrent = cities.find( ( a ) => this.value === a.name );
                if ( !cityCurrent ) {
                    return;
                }

                if ( !{{ ($salon->lat && $salon->lon) ? 'false' : 'true' }} ) {
                    setMapCenter( map, cityCurrent.lat, cityCurrent.lon );
                    setMapZoom( map, 10 );
                    setPlaceMark( place, cityCurrent.lat, cityCurrent.lon );
                }
            }, false );

            // изменение координат
            const setCoords = function ( coords ) {
                [ lat.value, lon.value ] = coords;
            };

            ymaps.ready( initMap );

            // Создание метки
            function createPlaceMark ( lat, lon, data ) {
                let property = {};
                if ( 'name' in data ) {
                    property[ 'iconContent' ] = data.name;
                    property[ 'name' ] = data.name;
                }

                if ( 'address' in data ) {
                    property[ 'address' ] = data.address;
                }

                let result = new ymaps.Placemark( [ lat, lon ], property, {
                    preset: 'twirl#redStretchyIcon',
                    draggable: true,
                });

                result.events.add( 'dragend', function( e ) {
                    let placeMark = e.get( 'target' );
                    let coords = placeMark.geometry.getCoordinates();
                    setCoords( coords );
                });

                return result;
            }

            function createMap ( lat, lon, zoom ) {
                let _map = new ymaps.Map(
                    'tinkoMap',
                    {
                        center: [ lat, lon ],
                        zoom: zoom
                    },
                    {
                        searchControlProvider: 'yandex#search'
                    }
                );
                // Масштабирование с помощью колесика мышки
                _map.behaviors.enable( 'scrollZoom' );

                // Добавляем стандартные элементы управления
                _map.controls.add( 'zoomControl' );

                return _map;
            }

            function setPlaceToMap ( _map, _place ) {
                _map.geoObjects.add( _place );
            }

            function setMapCenter ( _map, lat, lon ) {
                _map.setCenter( [lat, lon] );
            }

            function setMapZoom ( _map, zoom ) {
                _map.setZoom( zoom );
            }

            function setPlaceMark ( _place, lat, lon ) {
                _place.geometry.setCoordinates( [ lat, lon ] );
            }

            function setMapEvent ( _map, _place ) {
                _map.events.add( 'click', function ( e ) {
                    let coords = e.get( 'coords' );
                    _place.geometry.setCoordinates( coords );
                    setCoords( coords );
                } );
            }

            // инициализация карты
            function initMap () {
                let center_lat = parseFloat( lat.value ) || {{ $salon->city?->lat ?? 55.753638 }};
                let center_lon = parseFloat( lon.value ) || {{ $salon->city?->lon ?? 37.617008 }};
                let zoom = ( parseFloat( lat.value ) && parseFloat( lon.value) ) ? 16 : 4;

                // точка на карте
                place = createPlaceMark( center_lat, center_lon, { name: "{{ $salon->name }}" } );

                // экземпляр карты
                map = createMap( center_lat, center_lon, zoom );

                setPlaceToMap( map, place );

                setMapEvent( map, place );
            }
        })();
    </script>
@endsection
