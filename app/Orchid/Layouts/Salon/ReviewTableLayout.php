<?php

namespace App\Orchid\Layouts\Salon;

use App\Enums\ReviewApprove;
use App\Enums\ReviewType;
use App\Models\Review;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ReviewTableLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'salon.reviews';

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make( 'name', 'Имя' ),

            TD::make( 'content', 'Текст' )
                ->width( '450px' ),

            TD::make( 'published_at', 'Опубликован' )
                ->render( function ( Review $model ) {
                    return $model->published_at->format( 'Y-m-d' );
                } )
                ->alignCenter(),

            TD::make( 'type', 'Авто' )
                ->render( function ( Review $model ) {
                    if ( $model->type === ReviewType::AUTO ) {
                        return '<i class="fas fa-robot text-muted"></i>';
                    }

                    return '';
                } )
                ->popover( 'Отзыв отмечен как автоматически созданный' )
                ->alignCenter(),

            TD::make( 'is_approved', 'Проверен' )
                ->render( function ( Review $model ) {
                    if ( $model->is_approved === ReviewApprove::YES ) {
                        return '<i class="fas fa-check text-success"></i>';
                    }

                    return '<i class="fas fa-times text-danger"></i>';
                } )
                ->alignCenter(),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '100px' )
                ->render( function ( Review $model ) {
                    return DropDown::make()
                        ->icon( 'options-vertical' )
                        ->list( [
                            Link::make( __( 'Edit' ) )
                                ->route( 'platform.review.edit', $model->id )
                                ->icon( 'pencil' ),

                            Button::make( __( 'Delete' ) )
                                ->method( 'removeReview', [
                                    'id' => $model->id,
                                ] )
                                ->icon( 'trash' ),
                        ] );
                } )
        ];
    }
}
