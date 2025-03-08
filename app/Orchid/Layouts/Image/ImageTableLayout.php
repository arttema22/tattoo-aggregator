<?php

namespace App\Orchid\Layouts\Image;

use App\Enums\SpecializationTypes;
use App\Enums\WorkApproved;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ImageTableLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'files';

    public function striped() : bool
    {
        return true;
    }

    public function textNotFound() : string
    {
        return 'Нет данных для отображения';
    }

    public function subNotFound() : string
    {
        return 'Пусто';
    }

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make( 'path', 'Работа' )
                ->render( function ( File $model ) {
                    $src = Storage::url( $model->thumbs[ 's' ][ 'path' ] ?? ( 'images/original/' . $model->original ) );
                    return sprintf( '<img src="%s" alt="preview" loading="lazy" style="max-width: 100px;">', $src );
                } )
                ->width( '120px' ),

            TD::make( 'album.contact', 'Салон' )
                ->render( function ( File $model ) {
                    $salon = $model?->album?->contact ?? null;
                    if ( $salon === null ) {
                        return 'n/a';
                    }

                    return sprintf(
                        '<strong><a href="' . route( 'platform.salon.edit', [ 'salon' => $salon->id ] ) . '">%s</a></strong><br><span class="text-muted" style="font-size: 0.8em;">%s, %s</span><br><span class="text-muted" style="font-size: 0.8em;">%s</span>',
                        $salon->name,
                        $salon->country->name[ 'ru' ] ?? '',
                        $salon->city->name[ 'ru' ] ?? '',
                        $salon->address
                    );
                } ),

            TD::make( 'album.type', 'Тип' )
                ->render( function ( File $model ) {
                    $type = $model?->album->type ?? 0;
                    if ( $type === 0 ) {
                        return 'n/a';
                    }

                    return SpecializationTypes::toName( $type );
                } )
                ->width( '100px' ),

            TD::make( 'fileInfo.name', 'Название' ),

            TD::make( 'fileInfo.description', 'Описание' )
                ->defaultHidden(),

            TD::make( 'attributes', 'Аттрибуты' )
                ->render( function ( File $model ) {
                    $output = [];
                    $attr   = $model?->fileInfo->attribute[ 'c' . $model->album?->type ?? 0 ] ?? [];

                    foreach ( $this->query[ 'dictionaries' ] as $item ) {
                        if ( ( $item[ 'data' ][ $attr[ 'd' . $item[ 'id' ] ][ 0 ] ?? 0 ] ?? null ) === null ) {
                            continue;
                        }

                        $res = $item[ 'data' ][ $attr[ 'd' . $item[ 'id' ] ][ 0 ] ?? 0 ] ?? null;
                        if ( $res === null ) {
                            continue;
                        }

                        $output[] = '<kbd>' . $res->name . '</kbd>';
                    }

                    return implode( '<br>', $output );
                } ),

            TD::make( 'fileInfo.is_adult', '+18' )
                ->render( function ( File $model ) {
                    if ( $model->fileInfo->is_adult === 1 ) {
                        return '<i class="fa-solid fa-triangle-exclamation text-warning"></i>';
                    }

                    return '';
                } )
                ->width( '50px' )
                ->alignCenter(),

            TD::make( 'fileInfo.is_approved', 'Одобрена' )
                ->render( function ( File $model ) {
                    return match ( $model->fileInfo->is_approved ) {
                        WorkApproved::WAIT    => '<i class="fas fa-clock text-info" title="Ожидает модерации"></i>',
                        WorkApproved::APPROVE => '<i class="fas fa-check text-success" title="Одобрена"></i>',
                        WorkApproved::REJECT  => '<i class="fas fa-times text-danger" title="Отклонена"></i>',
                    };
                } )
                ->width( '50px' )
                ->alignCenter(),

            TD::make( 'created_at', 'Добавлен' )
                ->render( function ( File $model  ) {
                    return nl2br( $model->created_at->format( "Y-m-d\nH:i" ) );
                } )
                ->defaultHidden()
                ->width( '100px' )
                ->alignCenter(),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '100px' )
                ->render( function ( File $model ) {
                    $buttons = [
                        ModalToggle::make( 'Редактировать' )
                            ->icon( 'pencil' )
                            ->modal( 'asyncEditImageModal' )
                            ->modalTitle( 'Редактирование работы' )
                            ->method( 'update' )
                            ->asyncParameters( [
                                'id' => $model->id,
                            ] ),
                    ];

                    if ( $model->fileInfo->is_approved === WorkApproved::WAIT ) {
                        $buttons[] = Button::make( 'Одобрить' )
                            ->icon( 'like' )
                            ->method( 'approved', [
                                'info_id' => $model->fileInfo->id,
                            ] );

                        $buttons[] = Button::make( 'Отклонить' )
                            ->icon( 'dislike' )
                            ->method( 'notApproved', [
                                'info_id' => $model->fileInfo->id,
                            ] );
                    }

                    if ( $model->fileInfo->is_approved === WorkApproved::APPROVE ) {
                        $buttons[] = Button::make( 'Снять с публикации' )
                            ->icon( 'dislike' )
                            ->method( 'notApproved', [
                                'info_id' => $model->fileInfo->id,
                            ] );
                    }

                    if ( $model->fileInfo->is_approved === WorkApproved::REJECT ) {
                        $buttons[] = Button::make( 'Опубликовать' )
                            ->icon( 'like' )
                            ->method( 'approved', [
                                'info_id' => $model->fileInfo->id,
                            ] );
                    }

                    if ( $model->fileInfo->is_adult === 0 ) {
                        $buttons[] = Button::make( 'Отметка 18+' )
                            ->icon( 'lock' )
                            ->method( 'setAdult', [
                                'info_id' => $model->fileInfo->id,
                            ] );
                    } else {
                        $buttons[] = Button::make( 'Снять 18+' )
                            ->icon( 'lock-open' )
                            ->method( 'setNoAdult', [
                                'info_id' => $model->fileInfo->id,
                            ] );
                    }

                    $buttons[] = Button::make( 'Удалить' )
                        ->icon( 'trash' )
                        ->method( 'remove', [
                            'id' => $model->id,
                        ] );

                    return DropDown::make()
                        ->icon( 'options-vertical' )
                        ->list( $buttons );
                } )
        ];
    }
}
