<?php

namespace App\Orchid\Layouts\Salon;

use App\Enums\SpecializationTypes;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class ServiceEditLayout extends Rows
{
    /**
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make( 'service.name' )
                ->type( 'text' )
                ->title( 'Название' )
                ->required(),

            Select::make( 'service.type' )
                ->options( [
                    SpecializationTypes::TATTOO   => 'Тату',
                    SpecializationTypes::TATUAJE  => 'Татуаж',
                    SpecializationTypes::PIERCING => 'Пирсинг',
                    SpecializationTypes::OTHER    => 'Другое',
                ] )
                ->empty( '' )
                ->title( 'Тип' )
                ->required(),

            CheckBox::make( 'service.is_start_price' )
                ->sendTrueOrFalse()
                ->title( 'Цена стартует' ),

            Input::make( 'service.price' )
                ->type( 'text' )
                ->title( 'Цена' )
                ->required()
        ];
    }
}
