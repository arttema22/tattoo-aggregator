<?php

namespace App\Orchid\Screens\Geo\Country;

use App\Models\Country;
use App\Orchid\Layouts\Geo\Country\CountryListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class CountryListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'countries' => Country::with( [ 'cities', 'contacts' ] )
                ->paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Страны';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.geo.countries',
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make( __( 'Add' ) )
                ->icon( 'plus' )
                ->route( 'platform.geo.country.create' ),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            CountryListLayout::class
        ];
    }

    /**
     * @param Request $request
     * @return void
     */
    public function remove( Request $request ): void
    {
        Country::findOrFail( $request->get( 'id' ) )->delete();
        Toast::info( __( 'Страна удалена' ) );
    }
}
