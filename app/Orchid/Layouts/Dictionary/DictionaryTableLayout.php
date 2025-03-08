<?php

namespace App\Orchid\Layouts\Dictionary;

use App\Models\Contact;
use App\Models\Dictionaries\Dictionary;
use App\Models\Review;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DictionaryTableLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'dictionaries';

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make( 'name', 'Название' ),

            TD::make( 'count', 'Количество записей' )
                ->render( function ( $repo ) {
                    return Dictionary::where( 'type', '=', $repo[ 'type' ] )->count();
                } )
                ->width( '150px' ),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '100px' )
                ->render( function ( $repo ) {
                    return Link::make( '' )
                        ->route( 'platform.dictionary.edit', $repo[ 'type' ] )
                        ->icon( 'pencil' );
                } )
        ];
    }
}
