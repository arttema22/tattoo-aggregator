<?php

namespace App\Orchid\Layouts\LandingPage;

use App\Models\City;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class LandingPageEditLayout extends Rows
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

            Input::make( 'page.slug' )
                ->type( 'text' )
                ->max( 255 )
                ->title( 'ЧПУ' )
                ->required()
                ->style( 'max-width: inherit' ),

            Select::make( 'page.city_id' )
                ->options(
                    City::get()
                        ->map( function( $item ) {
                            return [ 'id' => $item->id, 'name' => $item->name[ 'ru' ] ];
                        } )
                        ->pluck( 'name', 'id' )
                        ->toArray()
                )
                ->empty( '' )
                ->title( 'Город' )
                ->required(),

            Input::make( 'page.caption' )
                ->type( 'text' )
                ->max( 255 )
                ->title( 'Заголовок на странице' )
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

            Quill::make( 'page.seo_text' )
                ->title( 'SEO текст' )
                ->required()
                ->toolbar( ['text', 'color', 'quote', 'header', 'list', 'format'] )
                ->style( 'max-width: inherit' ),
        ];
    }
}
