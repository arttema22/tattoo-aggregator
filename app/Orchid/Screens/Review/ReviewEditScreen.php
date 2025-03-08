<?php

namespace App\Orchid\Screens\Review;

use App\Enums\ReviewApprove;
use App\Models\Review;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ReviewEditScreen extends Screen
{
    public ?Review $review;

    /**
     * @return array
     */
    public function query( Review $review ): iterable
    {
        return [
            'review' => $review
        ];
    }

    /**
     * @return string|null
     */
    public function name() : ?string
    {
        return 'Просмотр и редактирование отзыва';
    }

    /**
     * @return iterable|null
     */
    public function permission() : ?iterable
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
            Button::make( 'Одобрить' )
                ->icon( 'check' )
                ->method( 'approve' )
                ->canSee( !$this->review->is_approved ),

            Button::make( 'Сохранить' )
                ->icon( 'pencil' )
                ->method( 'update' ),

            Button::make( 'Удалить' )
                ->icon( 'trash' )
                ->method( 'remove' ),

            Link::make( 'Назад' )
                ->icon( 'action-undo' )
                ->route( 'platform.reviews' ),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows( [
                Input::make( 'review.name' )
                    ->type( 'text' )
                    ->title( 'Ник' )
                    ->required()
                    ->style( 'max-width: inherit' ),

                TextArea::make( 'review.content' )
                    ->rows( 10 )
                    ->title( 'Текст отзыва' )
                    ->required()
                    ->style( 'max-width: inherit' ),
            ] )
        ];
    }

    public function update( Review $review, Request $request ) : void
    {
        $input  = $request->collect( 'review' );
        $insert = $input->only( [
            'name',
            'content',
        ] )->toArray();

        $review->fill( $insert );
        $review->save();

        Toast::info(
            'Вы успешно обновили отзыв'
        )->autoHide()->delay( 2000 );
    }

    public function approve( Review $review, Request $request ) : void
    {
        $review->fill( [
            'is_approved' => ReviewApprove::YES
        ] );
        $review->save();

        Toast::info( 'Отзыв одобрен' )->autoHide()->delay( 2000 );
    }

    public function remove( Review $model )
    {
        $model->delete();
        Toast::info( __( 'Отзыв удален' ) );

        return redirect()->route('platform.reviews');
    }
}
