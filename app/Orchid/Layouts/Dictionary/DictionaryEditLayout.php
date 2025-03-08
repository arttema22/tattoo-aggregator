<?php

namespace App\Orchid\Layouts\Dictionary;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class DictionaryEditLayout extends Rows
{
    /**
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make( 'dictionary.slug' )
                ->type( 'text' )
                ->max( 255 )
                ->required()
                ->title( __( 'Ключ' ) ),

            Input::make( 'dictionary.name' )
                ->type( 'text' )
                ->required()
                ->title( __( 'Название' ) ),
        ];
    }
}
