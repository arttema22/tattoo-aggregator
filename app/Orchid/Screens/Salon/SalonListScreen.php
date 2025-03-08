<?php

namespace App\Orchid\Screens\Salon;

use App\Models\Contact;
use App\Orchid\Layouts\Salon\SalonListLayout;
use App\Orchid\Selection\SalonSelection;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class SalonListScreen extends Screen
{
    /**
     * @return array
     */
    public function query(): iterable
    {
        return [
            'salons' => Contact::with( [ 'country', 'city', 'profile' ] )
                ->filters()
                ->filtersApplySelection( SalonSelection::class )
                ->defaultSort( 'created_at', 'desc' )
                ->withTrashed()
                ->paginate( 50 )
        ];
    }

    /**
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Список салонов и мастеров';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.salons',
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            SalonSelection::class,
            SalonListLayout::class,
        ];
    }

    /**
     * @param Request $request
     */
    public function remove( Request $request ): void
    {
        Contact::findOrFail( $request->get( 'id' ) )->delete();
        Toast::info( __( 'Салон удален' ) );
    }

    /**
     * @param Request $request
     */
    public function restore( Request $request ): void
    {
        Contact::withTrashed()->findOrFail( $request->get( 'id' ) )->restore();
        Toast::info( __( 'Салон восстановлен' ) );
    }
}
