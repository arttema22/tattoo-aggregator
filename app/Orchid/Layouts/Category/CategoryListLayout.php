<?php

namespace App\Orchid\Layouts\Category;

use App\Models\Category;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CategoryListLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'categories';

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make( 'name', 'Название' )
                ->cantHide(),

            TD::make( 'articles', 'Количество статей' )
                ->render( function ( Category $model ) {
                    return $model->articles->count();
                } ),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '100px' )
                ->render( function ( Category $model ) {
                    return DropDown::make()
                        ->icon( 'options-vertical' )
                        ->list( [
                            Link::make( __( 'Edit' ) )
                                ->route( 'platform.category.edit', $model->id )
                                ->icon( 'pencil' ),

                            Button::make( __( 'Delete' ) )
                                ->icon( 'trash' )
                                ->confirm( __( 'Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.' ) )
                                ->method( 'remove', [
                                    'id' => $model->id,
                                ] ),
                        ] );
                } )
        ];
    }
}
