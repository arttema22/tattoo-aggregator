<?php

namespace App\Orchid\Screens\Image;

use App\Enums\SpecializationTypes;
use App\Enums\WorkApproved;
use App\Helpers\SpecialisationDictionaryHelper;
use App\Models\File;
use App\Models\FileInfo;
use App\Orchid\Layouts\Image\ImageEditLayout;
use App\Orchid\Layouts\Image\ImageTableLayout;
use App\Orchid\Selection\ImageSelection;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ImageListScreen extends Screen
{
    /**
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function query(): iterable
    {
        return [
            'dictionaries' => current( SpecialisationDictionaryHelper::get( SpecializationTypes::ALL ) ),

            'files' => File::with( [ 'album.contact.country', 'album.contact.city', 'fileInfo' ] )
                ->filters()
                ->filtersApplySelection( ImageSelection::class )
                ->where( 'fileable_type', '=', 'App\\Models\\Album' )
                ->orderByDesc( 'created_at' )
                ->paginate( 50 )
        ];
    }

    /**
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Все работы';
    }

    /**
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Список всех работ, со всех салонов в одном месте';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.images',
        ];
    }

    /**
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            DropDown::make( 'По добавлению' )
                ->icon( 'sort-amount-asc' )
                ->list( [
                    Link::make( __( 'За последнию неделю' ) )
                        ->route( 'platform.images', [ 'dt[start]' => now()->subWeek()->format( 'Y-m-d' ), 'dt[end]' => now()->format( 'Y-m-d' ) ] ),
                    Link::make( __( 'За последний месяц' ) )
                        ->route( 'platform.images', [ 'dt[start]' => now()->subMonth()->format( 'Y-m-d' ), 'dt[end]' => now()->format( 'Y-m-d' ) ] ),
                ] ),

            Link::make( __( 'Ожидают модерацию' ) )
                ->icon( 'clock' )
                ->route( 'platform.images', [ 'approved' => WorkApproved::WAIT ] ),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ImageSelection::class,
            ImageTableLayout::class,

            Layout::modal( 'asyncEditImageModal', Layout::columns( [
                Layout::view( 'platform.layouts.view-image' ),
                ImageEditLayout::class
            ] ) )
                ->size( 'modal-xl')
                ->async( 'asyncGetImage' ),
        ];
    }

    // ==========================================================================

    /**
     * @param \App\Models\File $model
     * @return iterable
     */
    public function asyncGetImage( File $model ) : iterable
    {
        $model->load( [ 'fileInfo', 'album' ] );

        return [
            'original' => $model->original,
            'info'     => $model->fileInfo,
            'type'     => $model->album->type,
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

        Toast::info( __( 'Работа снята с публикации' ) );
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
