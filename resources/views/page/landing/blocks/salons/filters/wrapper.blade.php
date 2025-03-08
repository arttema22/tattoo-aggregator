<div class="filter-block">
    <form class="filter-form">
        {{-- Города --}}
        @include( 'page.landing.blocks.salons.filters.cities' )

        {{-- Виды тату --}}
        @include( 'page.landing.blocks.salons.filters.works', [
            'filters' => $salons_filters[ 'tattoo' ][ 'dictionary' ],
            'filter_id' => 'filter-tattoo-place',
            'filter_type' => \App\Enums\SpecializationTypeNames::TATTOO,
            'default_value' => 'Тату',
            'selected_value' => $salons_filters[ 'tattoo' ][ 'selected' ],
        ] )

        {{-- Виды пирсинга --}}
        @include( 'page.landing.blocks.salons.filters.works', [
            'filters' => $salons_filters[ 'piercing' ][ 'dictionary' ],
            'filter_id' => 'filter-piercing-place',
            'filter_type' => \App\Enums\SpecializationTypeNames::PIERCING,
            'default_value' => 'Пирсинг',
            'selected_value' => $salons_filters[ 'piercing' ][ 'selected' ],
        ] )

        {{-- Виды татуажа --}}
        @include( 'page.landing.blocks.salons.filters.works', [
            'filters' => $salons_filters[ 'tatuaje' ][ 'dictionary' ],
            'filter_id' => 'filter-tatuaje-place',
            'filter_type' => \App\Enums\SpecializationTypeNames::TATUAJE,
            'default_value' => 'Татуаж',
            'selected_value' => $salons_filters[ 'tatuaje' ][ 'selected' ],
        ] )
    </form>
</div>
