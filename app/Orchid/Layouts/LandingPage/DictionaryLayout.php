<?php

namespace App\Orchid\Layouts\LandingPage;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class DictionaryLayout extends Rows
{
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
