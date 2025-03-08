<?php

namespace App\Orchid\Layouts\Salon;

use App\Models\Contact;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SiblingTableLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'salon.siblings';

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make( 'name', 'Название' )
                ->render( function ( Contact $model ) {
                    if ( $model->name ) {
                        return $model->name;
                    }

                    return '<span class="text-muted">нет названия</span>';
                } ),

            TD::make( 'geo', 'Расположение' )
                ->render( function ( Contact $model ) {
                    return sprintf(
                        '%s, %s<br><span class="text-muted">%s</span>',
                        $model->country?->name[ 'ru' ] ?? 'n/a',
                        $model->city?->name[ 'ru' ] ?? 'n/a',
                        $model->address
                    );
                } ),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '100px' )
                ->render( function ( Contact $model ) {
                    return Link::make( '' )
                        ->route( 'platform.salon.edit', $model->id )
                        ->icon( 'login' );
                } )
        ];
    }
}
