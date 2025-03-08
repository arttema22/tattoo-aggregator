<?php

namespace App\Orchid\Layouts\LandingPage;

use App\Enums\CurrencyTypes;
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

            Input::make( 'service.name' )
                ->type( 'text' )
                ->title( 'Название' )
                ->required(),

            Input::make( 'service.price' )
                ->type( 'text' )
                ->title( 'Цена' )
                ->required(),

            Input::make( 'service.currency' )
                ->type( 'text' )
                ->title( 'Валюта' )
                ->value(CurrencyTypes::RUB)
                ->required(),

            CheckBox::make( 'service.is_start_price' )
                ->sendTrueOrFalse()
                ->title( 'Цена стартует' ),
        ];
    }
}
