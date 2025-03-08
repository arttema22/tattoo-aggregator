<?php

namespace App\Orchid\Screens\Geo\City;

use App\Models\City;
use App\Orchid\Layouts\Geo\City\CityListLayout;
use App\Orchid\Selection\CitySelection;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class CityListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'cities' => City::with( [ 'country', 'contacts' ] )
                ->filters()
                ->filtersApplySelection( CitySelection::class )
                ->defaultSort( 'country_id', 'asc' )
                ->paginate( 50 ),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Города';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.geo.cities',
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
                ->route( 'platform.geo.city.create' ),
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
            CitySelection::class,
            CityListLayout::class
        ];
    }

    /**
     * @param Request $request
     * @return void
     */
    public function remove( Request $request ): void
    {
        City::findOrFail( $request->get( 'id' ) )->delete();
        Toast::info( __( 'Город удален' ) );
    }
}
