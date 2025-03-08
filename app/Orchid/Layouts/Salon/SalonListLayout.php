<?php

namespace App\Orchid\Layouts\Salon;

use App\Enums\ProfileTypes;
use App\Models\Contact;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SalonListLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'salons';

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make( 'name', 'Название' )
                ->render( function ( Contact $model ) {
                    if ( $model->trashed() ) {
                        return '<span class="text-danger">' . e( $model->name ) . '</span>';
                    }

                    if ( $model->name ) {
                        return e( $model->name );
                    }

                    return '<span class="text-muted">нет названия</span>';
                } ),

            TD::make( 'profile.type', 'Тип' )
                ->render( function ( Contact $model ) {
                    return match ( $model->profile->type ) {
                        ProfileTypes::MASTER => 'мастер',
                        ProfileTypes::SALON  => 'салон',
                        default              => 'n/a'
                    };
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

            TD::make( 'filled', 'Сортировка' )
                ->render( function ( Contact $model ) {
                    return sprintf(
                        '<span title="Процент заполнености: %d%%, От админа: %d">%d</span>',
                        $model->filled_percent,
                        $model->additional_filled_percent,
                        $model->filled
                    );
                } ),

            TD::make( 'created_at', 'Создан' )
                ->render( function ( Contact $model ) {
                    return $model->created_at->locale( 'ru' )->isoFormat( 'D MMM YYYY' );
                } )
                ->sort(),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '100px' )
                ->render( function ( Contact $model ) {
                    $buttons = [];

                    if ( !$model->trashed() ) {
                        $buttons[] = Link::make( __( 'Edit' ) )
                            ->route( 'platform.salon.edit', $model->id )
                            ->icon( 'pencil' );

                        $buttons[] = Button::make( __( 'Delete' ) )
                            ->icon('trash')
                            ->confirm( __( 'После удаления записи она будет скрыта с публичной части сайта.' ) )
                            ->method( 'remove', [
                                'id' => $model->id,
                            ] );
                    } else {
                        $buttons[] = Button::make( __( 'Восстановить' ) )
                            ->icon( 'reload' )
                            ->confirm( __( 'После восстановления записи она будет вновь показана в публичной части сайта.' ) )
                            ->method( 'restore', [
                                'id' => $model->id,
                            ] );
                    }

                    return DropDown::make()
                        ->icon( 'options-vertical' )
                        ->list( $buttons );
                } )
        ];
    }
}
