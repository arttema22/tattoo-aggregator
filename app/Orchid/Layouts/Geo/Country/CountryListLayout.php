<?php

namespace App\Orchid\Layouts\Geo\Country;

use App\Models\Country;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CountryListLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'countries';

    /**
     * @return TD[]
     */
    protected function columns() : iterable
    {
        return [
            TD::make( 'name.ru', 'Название' ),

            TD::make( 'cities', 'Кол-во городов' )
                ->render( function ( Country $model ) {
                    return $model->cities->count();
                } )
                ->width( '150px' ),

            TD::make( 'salons', 'Кол-во салонов' )
                ->render( function ( Country $model ) {
                    return $model->contacts->count();
                } )
                ->width( '150px' ),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '100px' )
                ->render( function ( Country $model ) {
                    return DropDown::make()
                        ->icon( 'options-vertical' )
                        ->list( [
                            Link::make( __( 'Edit' ) )
                                ->route( 'platform.geo.country.edit', $model->id )
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
