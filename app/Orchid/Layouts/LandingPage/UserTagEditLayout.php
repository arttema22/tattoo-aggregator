<?php

namespace App\Orchid\Layouts\LandingPage;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class UserTagEditLayout extends Rows
{
    /**
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make( 'user-tag.name' )
                ->max( 255 )
                ->type( 'text' )
                ->title( 'Тег' )
                ->required(),

            TextArea::make( 'user-tag.link' )
                ->max( 1024 )
                ->rows( 5 )
                ->title( 'Ссылка' )
                ->required()
        ];
    }
}
