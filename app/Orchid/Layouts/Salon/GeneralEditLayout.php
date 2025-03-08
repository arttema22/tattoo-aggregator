<?php

namespace App\Orchid\Layouts\Salon;

use App\Orchid\Fields\PictureExtra;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class GeneralEditLayout extends Rows
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
            Input::make( 'salon.alias' )
                ->type( 'text' )
                ->max( 255 )
                ->title( 'Адрес салона' )
                ->required()
                ->style( 'max-width: inherit' ),

            Input::make( 'salon.additional_filled_percent' )
                ->help( 'Дополнительный параметр от модератора, чтобы вывести выше/ниже в листинге салонов, этот салон. Значение как положительное, так и отрицательное.' )
                ->type( 'number' )
                ->title( 'Расположение в листинге' )
                ->style( 'max-width: inherit' ),

            Input::make( 'salon.name' )
                ->type( 'text' )
                ->max( 255 )
                ->title( 'Имя салона' )
                ->required()
                ->style( 'max-width: inherit' ),

            TextArea::make( 'salon.description' )
                ->rows( 10 )
                ->title( 'Описание' )
                ->style( 'max-width: inherit' ),

            PictureExtra::make( 'salon.cover.url' )
                ->title( 'Обложка' )
                ->vertical()
        ];
    }
}
