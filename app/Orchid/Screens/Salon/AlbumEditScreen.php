<?php

namespace App\Orchid\Screens\Salon;

use App\Enums\WorkApproved;
use App\Helpers\SpecialisationDictionaryHelper;
use App\Helpers\SpecialisationTypeHelper;
use App\Models\Album;
use App\Models\File;
use App\Models\FileInfo;
use App\Orchid\Layouts\Salon\AlbumFileEditLayout;
use App\Orchid\Layouts\Salon\AlbumFileTableLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class AlbumEditScreen extends Screen
{
    public int $salon_id;

    public ?Album $album;

    /**
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function query( int $contact_id, int $album_id ): iterable
    {
        $this->salon_id = $contact_id;
        $this->album = Album::with( [ 'files.fileInfo' ] )
            ->where( 'id', '=', $album_id )
            ->where( 'contact_id', '=', $contact_id )
            ->first();

        return [
            'album'        => $this->album,
            'salon_id'     => $contact_id,
            'dictionaries' => current( SpecialisationDictionaryHelper::get( $this->album?->type ?? 0 ) ),
        ];
    }

    /**
     * @return string|null
     */
    public function name() : ?string
    {
        return 'Редактирование альбома "' . ( $this->album?->name ?? '' ) . '"';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.salons',
        ];
    }

    /**
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make( 'Назад' )
                ->icon( 'action-undo' )
                ->route( 'platform.salon.edit', [
                    'salon' => $this->salon_id
                ] ),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            AlbumFileTableLayout::class,

            Layout::modal( 'asyncEditFileModal', AlbumFileEditLayout::class )
                ->async( 'asyncGetFile' ),
        ];
    }

    // ==========================================================================

    /**
     * @param \App\Models\File $model
     * @return iterable
     */
    public function asyncGetFile( File $model ) : iterable
    {
        $model->load( [ 'fileInfo', 'album' ] );

        return [
            'info' => $model->fileInfo,
            'type' => $model->album->type,
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function update( Request $request ) : void
    {
        /** @var \App\Models\File $file */
        $file = File::with( [ 'fileInfo' ] )->findOrFail( $request->get( 'id' ) );

        $file->fileInfo->name        = $request->collect( 'info.name' )->first();
        $file->fileInfo->description = $request->collect( 'info.description' )->first();

        $attr = [];
        foreach ( $request->get( 'attr' ) as $k => $v ) {
            $v = (int) $v;
            if ( $v === 0 ) {
                continue;
            }

            $attr[ $k ] = [ $v ];
        }
        $file->fileInfo->attribute   = [ 'c' . $request->get( 'type' ) => $attr ];
        $file->fileInfo->save();

        Toast::info( __( 'Работа обновлена' ) );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function approved( Request $request ) : void
    {
        $info = FileInfo::findOrFail( $request->get( 'info_id' ) );
        $info->is_approved = WorkApproved::APPROVE;
        $info->save();

        Toast::info( __( 'Работа одобрена' ) );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function notApproved( Request $request ) : void
    {
        $info = FileInfo::findOrFail( $request->get( 'info_id' ) );
        $info->is_approved = WorkApproved::REJECT;
        $info->save();

        Toast::info( __( 'Работа отклонена' ) );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function setAdult( Request $request ) : void
    {
        $info = FileInfo::findOrFail( $request->get( 'info_id' ) );
        $info->is_adult = 1;
        $info->save();

        Toast::info( __( 'Работа отмечена 18+' ) );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function setNoAdult( Request $request ) : void
    {
        $info = FileInfo::findOrFail( $request->get( 'info_id' ) );
        $info->is_adult = 0;
        $info->save();

        Toast::info( __( 'С работы снято ограничение 18+' ) );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function remove( Request $request ) : void
    {
        $file = File::findOrFail( $request->get( 'id' ) );
        $file->fileInfo()->delete();
        $file->delete();

        Toast::info( __( 'Работа удалена' ) );
    }
}
