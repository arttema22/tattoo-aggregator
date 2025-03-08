<?php

namespace App\Orchid\Layouts\Geo\LineMetro;

use App\Models\LineMetro;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class LineMetroListLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'metro-line';

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make( 'name.ru', 'Название' ),

            TD::make( 'color', 'Цвет' )
                ->render( function ( LineMetro $model ) {
                    return '<span style="display: inline-block; width: 10px; height: 10px; background: #' . $model->color . '"></span>';
                } )
                ->alignCenter(),

            TD::make( 'city', 'Город' )
                ->render( function ( LineMetro $model ) {
                    return $model->metro?->first()->city->name[ 'ru' ] ?? '-';
                } ),

            TD::make( 'stations', 'Кол-во станций' )
                ->render( function ( LineMetro $model ) {
                    return $model->metro->count();
                } ),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '100px' )
                ->render( function ( LineMetro $model ) {
                    return DropDown::make()
                        ->icon( 'options-vertical' )
                        ->list( [
                            Link::make( __( 'Edit' ) )
                                ->route( 'platform.geo.metro.edit', $model->id )
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
