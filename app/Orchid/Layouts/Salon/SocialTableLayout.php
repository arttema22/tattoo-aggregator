<?php

namespace App\Orchid\Layouts\Salon;

use App\Models\SocialNetwork;
use App\Models\Video;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SocialTableLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'salon.socialNetworks';

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make( 'socialNetworkName.name', 'Соц. сеть' ),

            TD::make( 'value', 'Значение' )
                ->render( function ( SocialNetwork $model ) {
                    return sprintf(
                        '<span class="text-muted">%s</span><span class="fw-bold">%s</span>',
                        $model->socialNetworkName->url,
                        $model->value
                    );
                } ),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '90px' )
                ->render( function ( SocialNetwork $model ) {
                    return Group::make( [
                        ModalToggle::make( '' )
                            ->icon( 'pencil' )
                            ->modal( 'asyncEditSocialModal' )
                            ->modalTitle( 'Редактирование видео' )
                            ->method( 'updateSocial' )
                            ->asyncParameters( [
                                'id' => $model->id,
                            ] )
                            ->style( 'margin: 0px;padding: 0 5px;display: inline-block;width: auto;' ),

                        Button::make( '' )
                            ->icon( 'trash' )
                            ->method( 'removeSocial', [
                                'id' => $model->id,
                            ] )
                            ->style( 'margin: 0px;padding: 0 5px;display: inline-block;width: auto;' )
                    ] );
                } )
        ];
    }
}
