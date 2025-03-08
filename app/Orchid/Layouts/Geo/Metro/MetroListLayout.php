<?php

namespace App\Orchid\Layouts\Geo\Metro;

use App\Models\Metro;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class MetroListLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'metro';

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make( 'name.ru', 'Название станции' ),

            TD::make( 'line.name.ru', 'Метро' )
                ->render( function ( Metro $model ) {
                    return '<span style="display: inline-block; width: 10px; height: 10px; background: #' . $model->line->color . '"></span>&nbsp;&nbsp;' . $model->line->name[ 'ru' ];
                } ),

            TD::make( 'city.name.ru', 'Город' ),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '100px' )
                ->render( function ( Metro $model ) {
                    return DropDown::make()
                        ->icon( 'options-vertical' )
                        ->list( [
                            Link::make( __( 'Edit' ) )
                                ->route( 'platform.geo.station.edit', $model->id )
                                ->icon( 'pencil' ),

                            Button::make( __( 'Delete' ) )
                                ->icon( 'trash' )
                                ->confirm( __( 'После удаления записи все ее ресурсы и данные будут безвозвратно удалены.' ) )
                                ->method( 'remove', [
                                    'id' => $model->id,
                                ] ),
                        ] );
                } )
        ];
    }
}
