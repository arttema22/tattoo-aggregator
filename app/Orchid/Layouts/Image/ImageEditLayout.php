<?php

namespace App\Orchid\Layouts\Image;

use App\Helpers\SpecialisationDictionaryHelper;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Block;
use Orchid\Screen\Layouts\Columns;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Facades\Layout;

class ImageEditLayout extends Rows
{
    /**
     * @return Field[]
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function fields(): iterable
    {
        $dictionaries = current( SpecialisationDictionaryHelper::get( $this->query[ 'type' ] ?? 0 ) );
        if ( !$dictionaries ) {
            $dictionaries = [];
        }
        $attrs = $this->query[ 'info' ]?->attribute[ 'c' . $this->query[ 'type' ] ] ?? [];

        $output = [
            Input::make( 'type' )
                ->type( 'hidden' ),

            Input::make( 'info.name' )
                ->type( 'text' )
                ->max( 255 )
                ->title( 'Название' ),

            TextArea::make( 'info.description' )
                ->rows( 5 )
                ->title( 'Описание' )
                ->hr()
        ];

        foreach ( $dictionaries as $item ) {
            $output[] = Select::make( 'attr[d' . $item[ 'id' ] . ']' )
                    ->options( $item[ 'data' ]->pluck( 'name', 'id' )->toArray() )
                    ->title( $item[ 'title' ] )
                    ->value( $attrs[ 'd' . $item[ 'id' ] ] ?? 0 )
                    ->empty( 'Не выбрано', 0 );
        }

        return $output;
    }
}
