<?php

namespace App\Orchid\Screens\Geo\MetroLine;

use App\Models\LineMetro;
use App\Orchid\Layouts\Geo\LineMetro\LineMetroListLayout;
use App\Orchid\Selection\MetroSelection;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class MetroLineListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'metro-line' => LineMetro::with( [ 'metro.city' ] )
                ->filtersApplySelection( MetroSelection::class )
                ->filters()
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
        return 'Метро';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.geo.metro',
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
                ->route( 'platform.geo.metro.create' ),
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
            MetroSelection::class,
            LineMetroListLayout::class
        ];
    }

    /**
     * @param Request $request
     * @return void
     */
    public function remove( Request $request ): void
    {
        LineMetro::findOrFail( $request->get( 'id' ) )->delete();
        Toast::info( __( 'Метро удален' ) );
    }
}
