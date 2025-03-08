<?php

namespace App\Orchid\Layouts\SearchPage;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class DictionaryLayout extends Rows
{

    /**
     * @var string|null
     */
    protected $title = 'Фильтры';

    /**
     * @return Field[]
     */
    protected function fields(): iterable
    {
        $output = [];

        foreach ( $this->query->get( 'dictionaries' ) as $item ) {
            $output[] = Select::make( 'dictionary' )
                ->empty( '' )
                ->title( $item[ 'title' ] )
                ->options( $item[ 'data' ]->pluck( 'name', 'id' ) )
                ->multiple();
        }

        return $output;
    }
}
