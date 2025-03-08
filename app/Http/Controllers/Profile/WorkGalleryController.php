<?php

namespace App\Http\Controllers\Profile;

use App\DTO\File\FileDTO;
use App\DTO\FileInfo\FileInfoDTO;
use App\Enums\WorkApproved;
use App\Filters\AlbumFilter;
use App\Helpers\SpecialisationDictionaryHelper;
use App\Helpers\SpecialisationTypeHelper;
use App\Http\Requests\Profile\CreateWorkFileRequest;
use App\Http\Requests\Profile\UpdateWorkFileRequest;
use App\Models\Album;
use App\Models\File;
use App\Providers\RouteServiceProvider;
use App\Services\AlbumService;
use App\Services\ContactService;
use App\Services\FileInfoService;
use App\Services\FileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class WorkGalleryController extends BaseProfileController
{
    /**
     * WorkGalleryController constructor.
     * @param ContactService $contact_service
     * @param AlbumService $album_service
     * @param FileService $file_service
     * @param FileInfoService $file_info_service
     */
    public function __construct(
        private ContactService $contact_service,
        private AlbumService $album_service,
        private FileService $file_service,
        private FileInfoService $file_info_service )
    {
        parent::__construct();
    }

    public function index( int $contact_id, string $type )
    {
        $salon = $this->contact_service->find( $contact_id );
        if ( $salon === null ) {
            return redirect( RouteServiceProvider::ACCOUNT_INDEX )
                ->withErrors( [ 'message' => 'Ошибка получения данных салона' ] );
        }

        $album_filter = app()->make( AlbumFilter::class );
        $album_filter->setCustomFields( [
            'contact' => $contact_id,
            'type'=> SpecialisationTypeHelper::getTypeFromName( $type )
        ] );

        return view( 'account.profile.work-gallery.index', [
            'user'       => $this->auth_user,
            'contact_id' => $contact_id,
            'type'       => $type,
            'salon'      => $salon,
            'album'      => $this->album_service->searchWithFiles( $album_filter )?->first() ?? [],
            'title'      => SpecialisationTypeHelper::titleFromName( $type ) . ' | ' . $salon->name . ' | Личный кабинет'
        ] );
    }

    public function create( int $contact_id, string $type )
    {
        $salon = $this->contact_service->find( $contact_id );
        if ( $salon === null ) {
            return redirect( RouteServiceProvider::ACCOUNT_INDEX )
                ->withErrors( [ 'message' => 'Ошибка получения данных салона' ] );
        }

        return view( 'account.profile.work-gallery.create', [
            'user'         => $this->auth_user,
            'contact_id'   => $contact_id,
            'type'         => $type,
            'salon'        => $salon,
            'dictionaries' => SpecialisationDictionaryHelper::get( SpecialisationTypeHelper::getTypeFromName( $type ) ),
            'title'        => 'Добавить новую работу в "' . SpecialisationTypeHelper::titleFromName( $type ) . '" | ' . $salon->name . ' | Личный кабинет'
        ] );
    }

    public function edit( int $contact_id, string $type, int $id )
    {
        $salon = $this->contact_service->findWithAlbums( $contact_id );
        if ( $salon === null ) {
            return redirect( RouteServiceProvider::ACCOUNT_INDEX )
                ->withErrors( [ 'message' => 'Ошибка получения данных салона' ] );
        }

        /** @var Album|null $album */
        $album = $salon->albums->firstWhere( 'type', SpecialisationTypeHelper::getTypeFromName( $type ) );
        if ( $album === null ) {
            return redirect( route( 'account.profile.work-gallery.index', [ 'contact_id' => $contact_id, 'type' => $type ] ) )
                ->withErrors( [ 'message' => 'Не удалось найти альбом с работами' ] );
        }

        /** @var File|null $file */
        $file = $album->files->firstWhere( 'id', $id );
        if ( $file === null ) {
            return redirect( route( 'account.profile.work-gallery.index', [ 'contact_id' => $contact_id, 'type' => $type ] ) )
                ->withErrors( [ 'message' => 'Не удалось найти файл работы' ] );
        }

        return view( 'account.profile.work-gallery.edit', [
            'user'         => $this->auth_user,
            'contact_id'   => $contact_id,
            'type'         => $type,
            'salon'        => $salon,
            'file'         => $file,
            'attributes'   => $file->fileInfo?->attribute[ 'c' . SpecialisationTypeHelper::getTypeFromName( $type ) ] ?? [],
            'dictionaries' => SpecialisationDictionaryHelper::get( SpecialisationTypeHelper::getTypeFromName( $type ) ),
            'title'        => 'Редактировать работу в "' . SpecialisationTypeHelper::titleFromName( $type ) . '" | ' . $salon->name . ' | Личный кабинет'
        ] );
    }

    /**
     * @param CreateWorkFileRequest $request
     * @param int $contact_id
     * @param string $type
     * @return RedirectResponse
     */
    public function store( CreateWorkFileRequest $request, int $contact_id, string $type ): RedirectResponse
    {
        $album_filter = app()->make( AlbumFilter::class );
        $album_filter->setCustomFields( [
            'contact' => $contact_id,
            'type'=> SpecialisationTypeHelper::getTypeFromName( $type )
        ] );

        $album = $this->album_service->search( $album_filter )?->first();
        if ( $album === null ) {
            return back()->withInput()->withErrors( [ 'message' => 'Не удалось найти альбом' ] );
        }

        $uploaded_file = $this->file_service->uploadFile( $request->file( 'work' ) );
        if ( $uploaded_file === null ) {
            return back()->withInput()->withErrors( [ 'message' => 'Не загрузить файл' ] );
        }

        $dto = FileDTO::fromFile( $uploaded_file );
        $file = $this->file_service->create( $dto, $album );
        if ( $file === null ) {
            return back()->withInput()->withErrors( [ 'message' => 'Не загрузить изображение' ] );
        }

        $dto = FileInfoDTO::fromRequest( $request );
        $dto->attribute =
            SpecialisationDictionaryHelper::prepareAttributesForFileInfo(
                SpecialisationTypeHelper::getTypeFromName( $type ),
                $dto->attribute );
        $dto->is_adult = 0;
        $dto->is_approved = WorkApproved::WAIT;

        if ( $this->file_info_service->create( $dto, $file ) === null ) {
            Log::warning( 'can\t add file info', [ 'request' => $request ] );
            return back()->withInput()->withErrors( [ 'message' => 'Не удалось добавить информацию об изображении' ] );
        }

        return redirect()->route( 'account.profile.work-gallery.edit', [
            'contact_id' => $contact_id,
            'type'       => $type,
            'id'         => $file->id
        ] )->with( 'success', 'Новая работа добавлена успешно!' );
    }

    /**
     * @param UpdateWorkFileRequest $request
     * @param int $contact_id
     * @param string $type
     * @param int $work_id
     * @return RedirectResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function update( UpdateWorkFileRequest $request, int $contact_id, string $type, int $work_id ): RedirectResponse
    {
        $album_filter = app()->make( AlbumFilter::class );
        $album_filter->setCustomFields( [
            'contact' => $contact_id,
            'type'=> SpecialisationTypeHelper::getTypeFromName( $type )
        ] );

        /** @var Album|null $album */
        $album = $this->album_service->searchWithFiles( $album_filter )?->first();
        if ( $album === null ) {
            return back()->withInput()->withErrors( [ 'message' => 'Не удалось найти альбом' ] );
        }

        /** @var File|null $file */
        $file = $album->files->firstWhere( 'id', $work_id );
        if ( $file === null || $file->fileInfo?->id === null ) {
            return back()->withInput()->withErrors( [ 'message' => 'Не удалось найти текущую работу' ] );
        }

        $dto = FileInfoDTO::fromArray( $request->collect()->except( [ 'is_approved', 'is_adult' ] )->toArray() );
        $dto->attribute =
            SpecialisationDictionaryHelper::prepareAttributesForFileInfo(
                SpecialisationTypeHelper::getTypeFromName( $type ),
                $dto->attribute );

        if ( $this->file_info_service->update( $file->fileInfo->id, $dto ) === null ) {
            return back()->withInput()->withErrors( [ 'message' => 'Не удалось изменить информацию об изображении' ] );
        }

        return redirect()->route( 'account.profile.work-gallery.edit', [
            'contact_id' => $contact_id,
            'type'       => $type,
            'id'         => $work_id
        ] )->with( 'success', 'Информация о работе успешно обновлена!' );
    }

    /**
     * @param int $contact_id
     * @param string $type
     * @param int $work_id
     * @return RedirectResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function delete( int $contact_id, string $type, int $work_id ): RedirectResponse
    {
        $album_filter = app()->make( AlbumFilter::class );
        $album_filter->setCustomFields( [
            'contact' => $contact_id,
            'type'=> SpecialisationTypeHelper::getTypeFromName( $type )
        ] );

        /** @var Album|null $album */
        $album = $this->album_service->searchWithFiles( $album_filter )?->first();
        if ( $album === null ) {
            return redirect( route( 'account.profile.work-gallery.index', [ 'contact_id' => $contact_id, 'type' => $type ] ) )
                ->withErrors( [ 'message' => 'Не удалось найти альбом' ] );
        }

        /** @var File|null $file */
        $file = $album->files->firstWhere( 'id', $work_id );
        if ( $file === null || $file->fileInfo?->id === null ) {
            return redirect( route( 'account.profile.work-gallery.index', [ 'contact_id' => $contact_id, 'type' => $type ] ) )
                ->withErrors( [ 'message' => 'Не удалось найти текущую работу' ] );
        }

        if ( $this->file_info_service->delete( $file->fileInfo->id ) === false ||
             $this->file_service->delete( $work_id ) === false )
        {
            return back()->withInput()->withErrors( [ 'message' => 'Не удалось удалить изображение' ] );
        }

        return redirect()->route( 'account.profile.work-gallery.index', [
            'contact_id' => $contact_id,
            'type'       => $type
        ] )->with( 'success-remove', 'Работа удалена' );
    }
}
