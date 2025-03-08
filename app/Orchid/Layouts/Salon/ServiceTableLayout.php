<?php

namespace App\Orchid\Layouts\Salon;

use App\Enums\SpecializationTypes;
use App\Models\Contact;
use App\Models\Service;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ServiceTableLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'salon.services';

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make( 'name', 'Название' ),

            TD::make( 'type', 'Тип' )
                ->render( function ( Service $model ) {
                    return SpecializationTypes::toName( $model->type );
                } ),

            TD::make( 'is_start_price', 'Старт цены' )
                ->render( function ( Service $model ) {
                    if ( $model->is_start_price !== 0 ) {
                        return '<i class="fas fa-check"></i>';
                    }

                    return '-';
                } ),

            TD::make( 'price', 'Цена' )
                ->render( function ( Service $model ) {
                    return number_format( $model->price, 2, '.', ' ' ) . ' ' . $model->currency;
                } ),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '90px' )
                ->render( function ( Service $model ) {
                    return Group::make( [
                        ModalToggle::make( '' )
                            ->icon( 'pencil' )
                            ->modal( 'asyncEditServiceModal' )
                            ->modalTitle( 'Редактирование услуги' )
                            ->method( 'updateService' )
                            ->asyncParameters( [
                                'id' => $model->id,
                            ] )
                            ->style( 'margin: 0px;padding: 0 5px;display: inline-block;width: auto;' ),

                        Button::make( '' )
                            ->icon( 'trash' )
                            ->method( 'removeService', [
                                'id' => $model->id,
                            ] )
                            ->style( 'margin: 0px;padding: 0 5px;display: inline-block;width: auto;' )
                    ] );
                } )
        ];
    }
}
