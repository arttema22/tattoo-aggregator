<?php

namespace App\Orchid\Layouts\Geo\City;

use App\Models\City;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CityListLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'cities';

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make( 'name.ru', 'Название' ),

            TD::make( 'country.name.ru', 'Страна' ),

            TD::make( 'salons', 'Кол-во салонов' )
                ->render( function ( City $model ) {
                    return $model->contacts->count();
                } )
                ->width( '150px' ),

            TD::make( 'has_metro', 'Есть метро' )
                ->render( function ( City $city ) {
                    return match ( $city->has_metro ) {
                        1 => '<span class="text-success">Есть</span>',
                        0 => '<span class="text-danger">Нет</span>',
                    };
                } )
                ->sort()
                ->width( '150px' ),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '100px' )
                ->render( function ( City $model ) {
                    return DropDown::make()
                        ->icon( 'options-vertical' )
                        ->list( [
                            Link::make( __( 'Edit' ) )
                                ->route( 'platform.geo.city.edit', $model->id )
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
