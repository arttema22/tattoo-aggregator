<?php

namespace App\Orchid\Layouts\Category;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class CategoryEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make( 'category.alias' )
                ->type( 'text' )
                ->max( 128 )
                ->title( 'Уникальное имя на англ.' )
                ->required()
                ->style( 'max-width: inherit' ),

            Input::make( 'category.name' )
                ->type( 'text' )
                ->max( 255 )
                ->title( 'Название' )
                ->required()
                ->style( 'max-width: inherit' ),
        ];
    }
}
