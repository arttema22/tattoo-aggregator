@isset( $salons_filters[ 'city' ][ 'dictionary' ] )
    <select class="select-filter" id="filter-city">
        <option value="-">Город</option>
        @foreach( $salons_filters[ 'city' ][ 'dictionary' ] as $city )
            <option
                    value="{{ $city[ 'alias' ] }}"
                    {{ $salons_filters[ 'city' ][ 'selected' ] === $city[ 'alias' ] ? 'selected' : '' }}
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