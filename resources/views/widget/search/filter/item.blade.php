<?php
/** @var string $name */
/** @var string $title */
/** @var string $type */
/** @var array $data */
/** @var array $selected */
/** @var string $specialization_type */
/** @var int $route_param_number */
?>

<div class="card {{ $name }}">
    <div class="card-header">
        {{ $title }}
    </div>
    <div class="card-body">
        @if ( $type === 'Checkbox' )
            @foreach( $data as $id => $item )
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        value="{{ $item->slug }}"
                        id="filters_{{ $id }}"
                        {{ in_array( $item->slug, $selected, false ) ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="filters_{{ $id }}">
                        <a data-filter="{{ $item->slug }}" href="{{ route( 'search.' . $specialization_type, [ 'filter' => $item->slug ] ) }}">{{ $item->name }}</a>
                    </label>
                </div>
            @endforeach
        @elseif ( $type === 'Range' )
            <div class="row">
                @foreach( $data as $i => $item )
                    <div class="col-sm-6">
                        <input type="text" class="form-control mb-0" name="{{ $name . '[' . $i . ']' }}" placeholder="{{ $item }}" value="{{ $selected[$i] ?? '' }}">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@push( 'footer_scripts' )
    <script type="application/javascript">
        (() => {
            [ ...document.querySelectorAll( '.{{ $name }} input' ) ].forEach( item => {
                item.addEventListener( 'change', ({ target }) => {
                    @if ( $type === 'Checkbox' )
                        let pathNameParts = window.location.pathname.split('/');
                        let lastPathNamePart = pathNameParts[pathNameParts.length - 1];

                        if ( target.checked && lastPathNamePart === '{{ $specialization_type }}' && window.location.search === '' ) {
                            // выбрали первый фильтр, подставляем его в качестве основного фильтра
                            window.location.href =
                                window.location.origin +
                                window.location.pathname + '/' + item.value +
                                UrlQuery.build( [ 'page' ] );
                        } else {
                            let filters = lastPathNamePart.split('_');
                            if ( !target.checked && filters.find( filter => filter === item.value ) !== undefined ) {
                                // сняли выбор с основного фильтра

                                if ( filters.length === 1 ) {
                                    // если основной фильтр один, то просто редиректимся на страницу без основного фильтра
                                    window.location.href =
                                        window.location.origin +
                                        '/{{ $specialization_type }}' +
                                        UrlQuery.build( [ 'page' ] );
                                } else {
                                    filters = filters.filter( filter => filter !== item.value );

                                    // если фильтров было несколько, то переходим на страницу с оставшимися основными фильтрами
                                    window.location.href =
                                        window.location.origin +
                                        '/{{ $specialization_type }}/' + filters.join('_') +
                                        UrlQuery.build( [ 'page' ] );
                                }
                            } else {
                                UrlQuery.clear( '{{ $name }}' );

                                let checked = [ ...document.querySelectorAll( '.{{ $name }} input:checked' ) ].map( e => e.value );
                                checked.forEach( v => UrlQuery.addList( '{{ $name }}', v ) );

                                // необходимо удалить основной фильтр из списка параметров, если он там есть
                                filters.forEach( filter => UrlQuery.removeByValue( filter ) );

                                let searchParams = UrlQuery.build( [ 'page' ] );
                                window.location.href =
                                    searchParams !== ''
                                        ? searchParams
                                        : window.location.origin + window.location.pathname;
                            }
                        }
                    @elseif ( $type === 'Range' )
                        UrlQuery.clear( '{{ $name }}' );

                        let values = [ ...document.querySelectorAll( '.{{ $name }} input' )].map( e => e.value );
                        if ( values.filter( v => v.trim() !== '' ).length > 0 ) {
                            values.forEach( v => UrlQuery.addList( '{{ $name }}', v ) );
                        }

                        window.location.href = UrlQuery.build( [ 'page' ] );
                    @endif
                }, false );
            } )
        })();
    </script>
@endpush


