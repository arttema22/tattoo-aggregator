<?php

namespace App\Orchid\Layouts\LandingPage;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class TagEditLayout extends Rows
{
    /**
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make( 'tag.name' )
                ->max( 255 )
                ->type( 'text' )
                ->title( 'Тег' )
                ->required()
        ];
    }
}
