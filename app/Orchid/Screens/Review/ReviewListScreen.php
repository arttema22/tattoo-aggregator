<?php

namespace App\Orchid\Screens\Review;

use App\Enums\ReviewApprove;
use App\Models\Review;
use App\Orchid\Layouts\Review\ReviewListLayout;
use App\Orchid\Selection\ReviewSelection;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ReviewListScreen extends Screen
{
    /**
     * @return array
     */
    public function query(): iterable
    {
        return [
            'reviews' => Review::with( [ 'contact' ] )
                ->filters()
                ->filtersApplySelection( ReviewSelection::class )
                ->defaultSort( 'published_at', 'desc' )
                ->paginate( 50 )
        ];
    }

    /**
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Список отзывов';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.reviews',
        ];
    }

    /**
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make( __( 'Не проверенные' ) )
                ->icon( 'close' )
                ->route( 'platform.reviews', [ 'approved' => ReviewApprove::NO ] ),

            Link::make( __( 'Проверенные' ) )
                ->icon( 'check' )
                ->route( 'platform.reviews', [ 'approved' => ReviewApprove::YES ] ),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ReviewSelection::class,
            ReviewListLayout::class,
        ];
    }

    /**
     * @param Request $request
     */
    public function remove( Request $request ): void
    {
        Review::findOrFail( $request->get( 'id' ) )->delete();
        Toast::info( __( 'Отзыв удален' ) );
    }
}
