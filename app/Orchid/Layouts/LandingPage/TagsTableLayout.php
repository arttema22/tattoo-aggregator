<?php

namespace App\Orchid\Layouts\LandingPage;

use App\Models\LandingPageTag;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TagsTableLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'page.landingPageTags';

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make( 'name', 'Тег' )
                ->cantHide( false ),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '90px' )
                ->render( function ( LandingPageTag $model ) {
                    return Group::make( [
                        ModalToggle::make( '' )
                            ->icon( 'pencil' )
                            ->modal( 'asyncEditTagModal' )
                            ->modalTitle( 'Редактирование' )
                            ->method( 'updateTag' )
                            ->asyncParameters( [
                                'id' => $model->id,
                            ] )
                            ->style( 'margin: 0px;padding: 0 5px;display: inline-block;width: auto;' ),

                        Button::make( '' )
                            ->icon( 'trash' )
                            ->method( 'removeTag', [
                                'id' => $model->id,
                            ] )
                            ->style( 'margin: 0px;padding: 0 5px;display: inline-block;width: auto;' )
                    ] );
                } )
                ->cantHide( false ),
        ];
    }
}
