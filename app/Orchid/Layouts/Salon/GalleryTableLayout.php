<?php

namespace App\Orchid\Layouts\Salon;

use App\Enums\WorkApproved;
use App\Models\Album;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class GalleryTableLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'salon.albums';

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make( 'name', 'Название' ),

            TD::make( 'count', 'На модерации' )
                ->render( function ( Album $model ) {
                    return '<span class="text-info">' . $model->files->where( 'fileInfo.is_approved', WorkApproved::WAIT )->count() . '</span>';
                } )
                ->width( '130px' )
                ->alignCenter(),

            TD::make( 'count', 'Одобренные' )
                ->render( function ( Album $model ) {
                    return '<span class="text-success">' . $model->files->where( 'fileInfo.is_approved', WorkApproved::APPROVE )->count() . '</span>';
                } )
                ->width( '100px' )
                ->alignCenter(),

            TD::make( 'count', 'Отклоненные' )
                ->render( function ( Album $model ) {
                    return '<span class="text-danger">' . $model->files->where( 'fileInfo.is_approved', WorkApproved::REJECT )->count() . '</span>';
                } )
                ->width( '100px' )
                ->alignCenter(),


            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '100px' )
                ->render( function ( Album $model ) {
                    return Link::make( '' )
                        ->icon( 'pencil' )
                        ->route( 'platform.salon.album.edit', [
                            'salon' => $this->query[ 'salon' ]?->id ?? 0,
                            'album' => $model->id
                        ] );
                } )
        ];
    }
}
