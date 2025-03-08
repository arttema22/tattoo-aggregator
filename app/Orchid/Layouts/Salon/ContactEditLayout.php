<?php

namespace App\Orchid\Layouts\Salon;

use App\Models\City;
use App\Models\Country;
use App\Models\Metro;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Map;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class ContactEditLayout extends Rows
{
    /**
     * @var string|null
     */
    protected $title;

    /**
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Group::make( [
                Select::make( 'salon.country_id' )
                    ->options(
                        Country::get()
                            ->map( function( $item ) {
                                return [ 'id' => $item->id, 'name' => $item->name[ 'ru' ] ];
                            } )
                            ->pluck( 'name', 'id' )
                            ->toArray()
                    )
                    ->empty( '' )
                    ->title( 'Страна' )
                    ->required(),

                Select::make( 'salon.city_id' )
                    ->options(
                        City::get()
                            ->map( function( $item ) {
                                return [ 'id' => $item->id, 'name' => $item->name[ 'ru' ] ];
                            } )
                            ->pluck( 'name', 'id' )
                            ->toArray()
                    )
                    ->empty( '' )
                    ->title( 'Город' )
                    ->required(),

                Select::make( 'salon.metro_id' )
                    ->options(
                        Metro::get()
                            ->map( function( $item ) {
                                return [ 'id' => $item->id, 'name' => $item->name[ 'ru' ] ];
                            } )
                            ->pluck( 'name', 'id' )
                            ->toArray()
                    )
                    ->empty( '' )
                    ->title( 'Метро' )
            ] ),

            Input::make( 'salon.address' )
                ->type( 'text' )
                ->title( 'Адрес' )
                ->required()
                ->style( 'max-width: inherit' ),

            Input::make( 'salon.district' )
                ->type( 'text' )
                ->title( 'Район' )
                ->style( 'max-width: inherit' ),

            Input::make( 'salon.site' )
                ->type( 'text' )
                ->title( 'Сайт' )
                ->style( 'max-width: inherit' ),

            Input::make( 'salon.email' )
                ->type( 'email' )
                ->title( 'Email' )
                ->style( 'max-width: inherit' ),

            TextArea::make( 'salon.phone' )
                ->rows( 5 )
                ->title( 'Телефоны' )
                ->style( 'max-width: inherit' )
                ->hr(),

            Map::make( 'place' )
                ->title( 'Расположение' ),
        ];
    }
}
