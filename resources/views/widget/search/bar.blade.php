<div class="container">
    <div class="search-header">
        <h1>{{ $search_title ?? 'Все тату салоны России' }}</h1>
        <div class="search-block-wrapper">
            <form class="search-form">
                <div class="row g-0 search-block-row default">
                    @if ( !isset( $type ) )
                    <div class="col-md-3 custom-select">
                        <select class="select-filter" id="search-type">
                            <option value="{{ \App\Enums\SpecializationTypeNames::TATTOO }}">Поиск по тату</option>
                            <option value="{{ \App\Enums\SpecializationTypeNames::PIERCING }}">Поиск по пирсингу</option>
                            <option value="{{ \App\Enums\SpecializationTypeNames::TATUAJE }}">Поиск по татуажу</option>
                        </select>
                    </div>
                    <div class="col-md-9 search-field">
                        <input list="datalistOptions" id="datalist" placeholder="Поисковое слово" autocomplete="off" name="">
                        <datalist id="datalistOptions"></datalist>
                        <button id="search-btn" class="search-btn" type="button"><img alt="поиск" src="/images/icons/search.svg"/></button>
                    </div>
                    @else
                    <div class="col-md-12 search-field">
                        <input list="datalistOptions" id="datalist" placeholder="Поисковое слово" autocomplete="off" style="border-left: 1px solid #F2F2F2">
                        <datalist id="datalistOptions"></datalist>
                        <button id="search-btn" class="search-btn" type="button"><img alt="поиск" src="/images/icons/search.svg"/></button>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>


@push( 'footer_scripts' )
<script type="application/javascript">
    (() => {
        const datalist        = document.getElementById( 'datalist' );
        const datalistOptions = document.getElementById( 'datalistOptions' );
        const searchBtn       = document.getElementById( 'search-btn' );

        let tattoo_dictionary   = {!! $dictionaries['tattoo']['tattoo_style']['data'] ?? '{}' !!};
        let piercing_dictionary = {!! $dictionaries['piercing']['piercing_place']['data'] ?? '{}' !!};
        let tatuaje_dictionary  = {!! $dictionaries['tatuaje']['tatuaje_place']['data'] ?? '{}' !!};

        let search_type = "{{ $type ?? \App\Enums\SpecializationTypeNames::TATTOO }}";

        // заполняем datalist по умолчанию в зависимости от типа поиска
        setDataListFromType( search_type );

        function setDatalist( data ) {
            datalist.value = '';
            while (datalistOptions.firstChild) {
                datalistOptions.removeChild(datalistOptions.firstChild);
            }

            for ( let i in data ) {
                if ( data.hasOwnProperty( i ) ) {
                    let option = document.createElement( 'option' );
                    option.value = data[i];
                    option.dataset['id'] = i;

                    datalistOptions.appendChild( option );
                }
            }
        }

        function setDataListFromType( type ) {
            switch ( type ) {
                case "{{ \App\Enums\SpecializationTypeNames::TATTOO }}":
                    setDatalist( tattoo_dictionary );
                    datalist.name = 'tattooStyle';
                    break;

                case "{{ \App\Enums\SpecializationTypeNames::PIERCING }}":
                    setDatalist( piercing_dictionary );
                    datalist.name = 'piercingPlace';
                    break;

                case "{{ \App\Enums\SpecializationTypeNames::TATUAJE }}":
                    setDatalist( tatuaje_dictionary );
                    datalist.name = 'tatuajePlace';
                    break;
            }
        }

        @if ( !isset( $type ) )
        document.getElementById( 'search-type' ).addEventListener( 'change', ( { target: { value } } ) => {
            search_type = value;
            setDataListFromType( search_type );
        }, false );
        @endif

        function search() {
            let output = '/' + search_type;
            const search_value = datalistOptions.querySelector( 'option[value="' + datalist.value + '"]' );

            if ( search_value ) {
                output += '?' + datalist.name + '[]=' + search_value.dataset['id'];
            } else {
                output += '?searchText=' + datalist.value;
            }

            window.location.href = output;
        }

        datalist.addEventListener( "keyup", function( { key } ) {
            if ( key === "Enter" ) {
                search();
            }
        }, false );

        searchBtn.addEventListener( 'click', () => {
            search();
        }, false );
    })();
</script>
@endpush
