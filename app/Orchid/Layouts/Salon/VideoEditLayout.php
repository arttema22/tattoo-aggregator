<?php

namespace App\Orchid\Layouts\Salon;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Code;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class VideoEditLayout extends Rows
{
    /**
     * @return Field[]
     */
    protected function fields() : iterable
    {
        return [
            Input::make( 'video.url' )
                ->type( 'url' )
                ->max( 255 )
                ->required()
                ->title( 'Ссылка на видео' )
                ->help( 'Принимаются только ссылки с видео-хостингов: YouTube, Rutube' )
                ->style( 'max-width: inherit;' ),

            Input::make( 'video.preview' )
                ->type( 'url' )
                ->title( 'Ссылка на обложку видео' )
                ->style( 'max-width: inherit;' ),

            TextArea::make( 'video.name' )
                ->title( 'Название видео' )
                ->style( 'max-width: inherit;' )
                ->rows( 3 ),

            TextArea::make( 'video.html' )
                ->title( 'Код для вставки' )
                ->style( 'max-width: inherit;' )
                ->rows( 5 ),

            TextArea::make( 'video.text' )
                ->title( 'Текст' )
                ->style( 'max-width: inherit;' )
                ->rows( 10 ),
        ];
    }
}
