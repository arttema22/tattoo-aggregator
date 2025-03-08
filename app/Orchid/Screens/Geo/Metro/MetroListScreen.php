<?php

namespace App\Orchid\Screens\Geo\Metro;

use App\Models\Metro;
use App\Orchid\Layouts\Geo\Metro\MetroListLayout;
use App\Orchid\Selection\StationSelection;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class MetroListScreen extends Screen
{
    /**
     * @return array
     */
    public function query(): iterable
    {
        return [
            'metro' => Metro::with( [ 'city', 'line' ] )
                ->filters()
                ->filtersApplySelection( StationSelection::class )
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
        return 'Станции метро';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.geo.stations',
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
                ->route( 'platform.geo.station.create' ),
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
            StationSelection::class,
            MetroListLayout::class,
        ];
    }

    /**
     * @param Request $request
     * @return void
     */
    public function remove( Request $request ): void
    {
        Metro::findOrFail( $request->get( 'id' ) )->delete();
        Toast::info( __( 'Станция метро удалена' ) );
    }
}
