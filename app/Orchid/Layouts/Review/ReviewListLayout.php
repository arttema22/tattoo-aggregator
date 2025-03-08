<?php

namespace App\Orchid\Layouts\Review;

use App\Enums\ReviewApprove;
use App\Enums\ReviewType;
use App\Models\Review;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ReviewListLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'reviews';

    public function striped() : bool
    {
        return true;
    }

    public function textNotFound() : string
    {
        return 'Нет данных для отображения';
    }

    public function subNotFound() : string
    {
        return 'Пусто';
    }

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make( 'contact.name', 'Салон' )
                ->render( function ( Review $model ) {
                    return Link::make( $model->contact->name )
                        ->route( 'platform.salon.edit', [ 'salon' => $model->contact_id ] );
                } ),

            TD::make( 'name', 'Имя' ),

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
                                ->icon( 'trash' )
                                ->confirm( __( 'Действительно хотите удалить отзыв?' ) )
                                ->method( 'remove', [
                                    'id' => $model->id,
                                ] ),
                        ] );
                } )
        ];
    }
}
