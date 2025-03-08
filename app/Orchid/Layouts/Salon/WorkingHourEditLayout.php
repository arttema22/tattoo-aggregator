<?php

namespace App\Orchid\Layouts\Salon;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class WorkingHourEditLayout extends Rows
{
    /**
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Group::make( [
                Input::make( 'wh.start' )
                    ->type( 'number' )
                    ->max( 23 )
                    ->min( 0 )
                    ->title( 'Открытие' ),

                Input::make( 'wh.end' )
                    ->type( 'number' )
                    ->max( 23 )
                    ->min( 0 )
                    ->title( 'Закрытие' )
            ] ),

            CheckBox::make( 'wh.is_weekend' )
                ->sendTrueOrFalse()
                ->title( 'Выходной' ),

            CheckBox::make( 'wh.is_nonstop' )
                ->sendTrueOrFalse()
                ->title( 'Круглосуточно' ),
        ];
    }
}
