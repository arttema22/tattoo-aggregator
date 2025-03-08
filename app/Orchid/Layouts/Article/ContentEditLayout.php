<?php

namespace App\Orchid\Layouts\Article;

use App\Models\Category;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class ContentEditLayout extends Rows
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
            Input::make( 'article.alias' )
                ->type( 'text' )
                ->max( 255 )
                ->title( 'Адрес статьи' )
                ->required()
                ->style( 'max-width: inherit' ),

            Input::make( 'article.title' )
                ->type( 'text' )
                ->max( 255 )
                ->title( 'Заголовок' )
                ->required()
                ->style( 'max-width: inherit' ),

            TextArea::make( 'article.description' )
                ->max( 255 )
                ->title( 'Краткое описание' )
                ->rows( 5 )
                ->required()
                ->style( 'max-width: inherit' ),

            Quill::make( 'article.content' )
                ->title( 'Текст статьи' )
                ->toolbar( [ 'text', 'color', 'header', 'list', 'format', 'media' ] )
                ->height( '400px' )
                ->required(),

            Select::make( 'article.categories' )
                ->title( 'Категории' )
                ->fromModel( Category::class, 'name', 'id' )
                ->vertical()
                ->multiple()
        ];
    }
}
