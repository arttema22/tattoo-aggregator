<div class="col-md-3">
    <div class="filter-block">
        <form class="filter-form" id="works-filters">
            @if( isset( $filters ) )
                @foreach( $filters as $number => $item )
                    @include( 'page.landing.blocks.works.filters.item', array_merge($item, ['specialization_type' => $type, 'route_param_number' => $number]) )
                @endforeach
            @endif
        </form>
    </div>
</div>

<template id="item-image">
    <div class="col-md-4 grid-item-wrapp">
        <div class="grid-item">
            <a href="#" class="grid-item-img" data-fancybox="search" data-src="" data-type="ajax">
                <img src="" alt="">
            </a>
        </div>
    </div>
</template>

@push( 'footer_scripts' )
    <script type="application/javascript">
        (() => {
            const path = '{{ Storage::url( config( 'image.thumbs.medium.path' ) ) }}';
            const template = document.getElementById( 'item-image' );
            const body = document.getElementById( 'works-results' );
            const getWorksUrl = "{{ route( 'search.city.' . $type, [ 'city' => $city->alias ] ) }}";

            [ ...document.querySelectorAll( 'a[data-filter]' ) ].forEach( item => {
                item.addEventListener( 'click', (e) => {
                    if (e.target.tagName === 'A') {
                        e.preventDefault();
                        e.target.parentNode.click();
                    }
                } );
            } );

            [ ...document.querySelectorAll( '#works-filters input[type=checkbox]' ) ].forEach( item => {
                item.addEventListener( 'click', async () => {
                    let requestData = getSelectedFilters();
                    requestData._token = "{{ csrf_token() }}";

                    replaceWorks( await sendRequest(getWorksUrl, "POST", requestData ) );
                } );
            } );

            const replaceWorks = ( data ) => {
                let wrap = document.createDocumentFragment();
                Object.keys( data ).forEach( i => {
                    let item = template.content.cloneNode( true );
                    item.querySelector( 'a' ).dataset.src = data[ i ].url;
                    item.querySelector( 'img' ).src = path + data[ i ].file;
                    item.querySelector( 'img' ).alt = data[ i ].name ? data[ i ].name : '{{ $type }}';

                    wrap.appendChild( item );
                } );

                body.replaceChildren( wrap );
            };

            function createRequest( method, data = {} ) {
                let request = {
                    method: method,
                    mode: 'cors',
                    cache: 'no-cache',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                }

                if ( data !== '' && Object.keys( data ).length !== 0 ) {
                    request['body'] = JSON.stringify( data );
                }

                return request;
            }

            async function sendRequest( url, method, data = {} ) {
                const response = await fetch( url, createRequest( method, data ) );
                return await response.json();
            }

            // 30 minutest
            function getSelectedFilters() {
                let selectedFilters = {};
                [ ...document.querySelectorAll( '.works-filter' ) ].forEach( ( filter ) => {
                    let checkedFilters = [ ...filter.querySelectorAll( 'input[type=checkbox]:checked' ) ].map( e => e.value );
                    if (checkedFilters.length) {
                        selectedFilters[filter.dataset.filterType] = checkedFilters;
                    }

                } );

                return selectedFilters;
            }
        })();
    </script>
@endpush
