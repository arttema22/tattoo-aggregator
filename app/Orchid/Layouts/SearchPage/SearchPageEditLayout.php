<?php

namespace App\Orchid\Layouts\SearchPage;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class SearchPageEditLayout extends Rows
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
            Input::make( 'page.type' )
                ->value( $this->query[ 'type' ] )
                ->type( 'hidden' ),

            Input::make( 'page.title' )
                ->type( 'text' )
                ->max( 255 )
                ->title( 'Заголовок' )
                ->required()
                ->style( 'max-width: inherit' ),

            TextArea::make( 'page.description' )
                ->rows( 3 )
                ->max( 255 )
                ->title( 'Описание' )
                ->required()
                ->style( 'max-width: inherit' ),

            TextArea::make( 'page.keywords' )
                ->rows( 3 )
                ->max( 255 )
                ->title( 'Ключевые слова' )
                ->required()
                ->style( 'max-width: inherit' ),
        ];
    }
}
