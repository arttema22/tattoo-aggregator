<?php
/** @var \App\Models\AdditionalServiceName[] $filter[ "additional_service_name" ] */
?>

<script type="application/javascript">
    const UrlQuery = ( () => {
        let _query = [];

        const init = () => {
            if ( !location.search ) {
                return;
            }

            let parts = location.search.split( '&' );
            parts.forEach( str => {
                let [ k, v ] = str.split( '=' );
                if ( v === undefined ) {
                    return;
                }

                if ( k[ 0 ] === '?' ) {
                    k = k.substr( 1 )
                }

                k = decodeURIComponent( k );
                _query.push( [ k, v ] );
            } );
        };

        init();

        const addList = ( name, value ) => {
            _query.push( [ name + '[]', value ] );
            return this;
        };

        const addOnly = ( name, value ) => {
            let result = _query.findIndex( item => item[ 0 ] === name );
            if ( result !== -1 ) {
                _query[ result ][ 1 ] = value;
            } else {
                _query.push( [ name, value ] );
            }

            return this;
        };

        const build = ( exclude = [] ) => {
            exclude = exclude || [];

            let output = [];
            for ( let item of _query.filter( Boolean ) ) {
                if ( exclude.includes( item[ 0 ] ) ) {
                    continue;
                }

                output.push( item.join( '=' ) );
            }

            return '?' + output.join( '&' );
        };

        const clear = ( name ) => {
            for ( let i in _query ) {
                if ( _query[ i ][ 0 ].indexOf( name ) === 0 ) {
                    delete _query[ i ];
                }
            }

            return this;
        };

        return {
            addList,
            addOnly,
            clear,
            build
        }
    } )();
</script>

<div class="filter-block">
    <form class="filter-form">
        {{-- Country --}}
        @isset( $filter[ 'city' ] )
        <select class="select-filter" id="filter-city">
            <option value="-">Город</option>
            @foreach( $filter[ 'city' ] as $city )
                <option
                    value="{{ $city[ 'alias' ] }}"
                    {{ $selected[ 'city' ] === $city[ 'alias' ] ? 'selected' : '' }}
                >
                    {{ $city[ 'name' ] }}
                </option>
            @endforeach
        </select>
        <script type="application/javascript">
            (()=>{
                document.querySelector( '#filter-city' ).addEventListener( 'change', ( e ) => {
                    let alias = e.target.value;
                    if ( alias === '-' ) {
                        window.location.href = '{{ route( 'catalog.index' ) }}/';
                        return;
                    }

                    window.location.href = '{{ route( 'catalog.index' ) }}/' + alias;
                }, false );
            })();
        </script>
        @endisset

        {{-- Metro --}}
        @if( isset( $filter[ 'metro' ] ) && !empty( $filter[ 'metro' ] ) )
        <select class="select-filter" id="filter-metro">
            <option value="-">Метро</option>
            @foreach( $filter[ 'metro' ] as $metro )
                <option
                    value="{{ $metro[ 'id' ] }}"
                    {{ $selected[ 'metro' ] == $metro[ 'id' ] ? 'selected' : '' }}
                >
                    {{ $metro[ 'name' ] }}
                </option>
            @endforeach
        </select>
        <script type="application/javascript">
            (()=>{
                document.querySelector( '#filter-metro' ).addEventListener( 'change', ( e ) => {
                    let alias = e.target.value;
                    if ( alias === '-' ) {
                        UrlQuery.clear( 'metro' );
                        window.location.href = UrlQuery.build( [ 'page' ] );
                        return;
                    }

                    UrlQuery.addOnly( 'metro', alias );
                    window.location.href = UrlQuery.build( [ 'page' ] );
                }, false );
            })();
        </script>
        @endif

        {{-- Виды пирсинга --}}
        @if( isset( $filter[ 'piercing' ][ 'place' ] ) && !empty( $filter[ 'piercing' ][ 'place' ] ) )
        <select class="select-filter" id="filter-piercing-place">
            <option value="-">Пирсинг</option>
            @foreach( $filter[ 'piercing' ][ 'place' ] as $id => $name )
                <option
                    value="{{ $id }}"
                    {{ $selected[ 'piercing' ][ 'place' ] == $id ? 'selected' : '' }}
                >{{ $name }}</option>
            @endforeach
        </select>
        <script type="application/javascript">
            (()=>{
                document.querySelector( '#filter-piercing-place' ).addEventListener( 'change', ( e ) => {
                    let value = e.target.value;
                    if ( value === '-' ) {
                        UrlQuery.clear( 'piercingPlace' );
                        window.location.href = UrlQuery.build( [ 'page' ] );
                        return;
                    }

                    UrlQuery.addOnly( 'piercingPlace', value );
                    window.location.href = UrlQuery.build( [ 'page' ] );
                }, false );
            })();
        </script>
        @endif

        {{-- Виды татуажа --}}
        @if( isset( $filter[ 'tatuaje' ][ 'place' ] ) && !empty( $filter[ 'tatuaje' ][ 'place' ] ) )
        <select class="select-filter" id="filter-tatuaje-place">
            <option value="-">Татуаж</option>
            @foreach( $filter[ 'tatuaje' ][ 'place' ] as $id => $name )
                <option
                    value="{{ $id }}"
                    {{ $selected[ 'tatuaje' ][ 'place' ] == $id ? 'selected' : '' }}
                >{{ $name }}</option>
            @endforeach
        </select>
        <script type="application/javascript">
            (()=>{
                document.querySelector( '#filter-tatuaje-place' ).addEventListener( 'change', ( e ) => {
                    let value = e.target.value;
                    if ( value === '-' ) {
                        UrlQuery.clear( 'tatuajePlace' )
                        window.location.href = UrlQuery.build( [ 'page' ] );
                        return;
                    }

                    UrlQuery.addOnly( 'tatuajePlace', value );
                    window.location.href = UrlQuery.build( [ 'page' ] );
                }, false );
            })();
        </script>
        @endif

        <!--<div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="filters_1">
            <label class="form-check-label" for="filters_1">
                Показать лучшие студии
            </label><img class="info" src="/images/icons/info.svg" data-bs-placement="bottom" data-bs-toggle="popover" data-bs-content="Ранжирование по рейтингудоверия" />
        </div>-->

        {{-- Дополнительные услуги --}}
        @if( isset( $filter[ 'additional_service_name' ] ) && !empty( $filter[ 'additional_service_name' ] ) )
        <span class="additional-filters-names">
        @foreach( $filter[ 'additional_service_name' ] as $item )
            <div class="form-check">
                <input class="form-check-input" type="checkbox"
                       value="{{ $item->id }}" id="filters_{{ $item->id }}"
                       name="additionalService"
                       {{ in_array( $item->id, $selected[ 'additional_service_name' ], false ) ? 'checked' : '' }}
                >
                <label class="form-check-label" for="filters_{{ $item->id }}" style="padding-top: 3px;">
                    {{ $item->name }}
                </label>
            </div>
        @endforeach
        </span>
        <script type="application/javascript">
            (()=>{
                [ ...document.querySelectorAll( '.additional-filters-names input' ) ].forEach( item => {
                    item.addEventListener( 'change', () => {
                        UrlQuery.clear( 'additionalService' );

                        let values = [ ...document.querySelectorAll( '.additional-filters-names input:checked' ) ].map( e => e.value );
                        values.forEach( v => UrlQuery.addList( 'additionalService', v ) );

                        window.location.href = UrlQuery.build( [ 'page' ] );
                    }, false );
                } )
            })();
        </script>
        @endif
    </form>
</div>
