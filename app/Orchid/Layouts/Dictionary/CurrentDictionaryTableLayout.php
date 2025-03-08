<?php

namespace App\Orchid\Layouts\Dictionary;

use App\Models\Dictionaries\Dictionary;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CurrentDictionaryTableLayout extends Table
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
            TD::make( 'slug', 'Ключ' ),

            TD::make( 'name', 'Название' ),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '90px' )
                ->render( function ( Dictionary $model ) {
                    return Group::make( [
                        ModalToggle::make( '' )
                            ->icon( 'pencil' )
                            ->modal( 'asyncEditDictionaryModal' )
                            ->modalTitle( 'Редактирование записи' )
                            ->method( 'update' )
                            ->asyncParameters( [
                                'id' => $model->id,
                            ] )
                            ->style( 'margin: 0px;padding: 0 5px;display: inline-block;width: auto;' ),

                        Button::make( '' )
                            ->icon( 'trash' )
                            ->confirm( __( 'После удаления записи все ее ресурсы и данные будут безвозвратно удалены.' ) )
                            ->method( 'remove', [
                                'id' => $model->id,
                            ] )
                            ->style( 'margin: 0px;padding: 0 5px;display: inline-block;width: auto;' )
                    ] )->alignCenter();
                } ),
        ];
    }
}
