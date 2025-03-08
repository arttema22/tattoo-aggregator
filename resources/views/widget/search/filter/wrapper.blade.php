@push( 'footer_scripts' )
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

                return output.length === 0 ? '' : '?' + output.join( '&' );
            };

            const clear = ( name ) => {
                for ( let i in _query ) {
                    if ( _query[ i ][ 0 ].indexOf( name ) === 0 ) {
                        delete _query[ i ];
                    }
                }

                return this;
            };

            const removeByValue = ( value ) => {
                for ( let i in _query ) {
                    if ( _query[ i ][ 1 ] === value ) {
                        delete _query[ i ];
                    }
                }

                return this;
            }

            const removeByIndex = ( index ) => {
                if ( getByIndex( index ) !== undefined ) {
                    delete _query[ index ];
                }

                return this;
            }

            const getByIndex = ( index ) => {
                return _query[ index ] ?? undefined;
            }

            return {
                addList,
                addOnly,
                clear,
                build,
                removeByValue,
                removeByIndex,
                getByIndex
            }
        } )();
    </script>
@endpush

<div class="col-md-3">
    <div class="filter-block">
        <form class="filter-form">
            @if( isset( $filters ) )
                @foreach( $filters as $number => $item )
                    @include( 'widget.search.filter.item', array_merge($item, ['specialization_type' => $type, 'route_param_number' => $number]) )
                @endforeach
            @endif
        </form>
    </div>
</div>

@push( 'footer_scripts' )
    <script type="application/javascript">
        (()=>{
            [ ...document.querySelectorAll( 'a[data-filter]' ) ].forEach( item => {
                item.addEventListener( 'click', (e) => {
                    if (e.target.tagName === 'A') {
                        e.preventDefault();
                        e.target.parentNode.click();
                    }
                } );
            } );
        })();
    </script>
@endpush
