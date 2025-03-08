<?php

namespace App\Orchid\Layouts\Salon;

use App\Models\Video;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class VideoTableLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'salon.videos';

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make( 'preview', 'Превью' )
                ->render( function ( Video $model ) {
                    $src = $model->preview ?? '/images/video/default.png';
                    return sprintf( '<div style="height: 55px; overflow: hidden;"><img src="%s" alt="preview" style="object-fit: cover; width: 100%%; height: 100%%;"></div>', $src );
                } )
                ->width( '120px' ),

            TD::make( 'name', 'Название' )
                ->width( '250px' ),

            TD::make( 'url', 'Ссылка на видео' ),

            TD::make( 'text', 'Текст' )
                ->render( function ( Video $model ) {
                    return $model->text !== ''
                        ? '<i class="fas fa-check text-success" title="Заполнено"></i>'
                        : '<i class="fas fa-times text-danger" title="Не заполнено"></i>';
                } )
                ->align( TD::ALIGN_CENTER )
                ->width( '80px' ),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '140px' )
                ->render( function ( Video $model ) {
                    return Group::make( [
                        Button::make( '' )
                            ->icon( 'reload' )
                            ->confirm( 'Запустить парсиг данных' )
                            ->method( 'parseVideo', [
                                'id' => $model->id,
                            ] )
                            ->style( 'margin: 0px;padding: 0 5px;display: inline-block;width: auto;' ),

                        ModalToggle::make( '' )
                            ->icon( 'pencil' )
                            ->modal( 'asyncEditVideoModal' )
                            ->modalTitle( 'Редактирование видео' )
                            ->method( 'updateVideo' )
                            ->asyncParameters( [
                                'id' => $model->id,
                            ] )
                            ->style( 'margin: 0px;padding: 0 5px;display: inline-block;width: auto;' ),

                        Button::make( '' )
                            ->icon( 'trash' )
                            ->confirm( 'Уверены что хотите удалить видео?' )
                            ->method( 'removeVideo', [
                                'id' => $model->id,
                            ] )
                            ->style( 'margin: 0px;padding: 0 5px;display: inline-block;width: auto;' )
                    ] );
                } )
        ];
    }
}
