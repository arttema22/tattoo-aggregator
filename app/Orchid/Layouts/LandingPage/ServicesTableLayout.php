<?php

namespace App\Orchid\Layouts\LandingPage;

use App\Enums\SpecializationTypes;
use App\Models\LandingPageService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ServicesTableLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'page.services';

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('type', 'Тип')
                ->render(function (LandingPageService $model) {
                    return SpecializationTypes::toName($model->type);
                }),

            TD::make('name', 'Название услуги'),

            TD::make('price', 'Цена')
                ->render(function (LandingPageService $model) {
                    return ($model->is_start_price ? 'от ' : '') .
                        number_format( $model->price, 0, '.', ' ' ) . ' ' . $model->currency;
                }),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '90px' )
                ->render( function (LandingPageService $model) {
                    return Group::make([
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
                    ]);
                } )
        ];
    }
}
