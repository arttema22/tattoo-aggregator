<?php

namespace App\Http\Controllers\Profile;

use App\DTO\Video\VideoDTO;
use App\Events\VideoAddEvent;
use App\Http\Requests\Profile\UpdateVideoGalleryRequest;
use App\Providers\RouteServiceProvider;
use App\Services\ContactService;
use App\Services\VideoService;
use Illuminate\Http\RedirectResponse;

class VideoGalleryController extends BaseProfileController
{
    /**
     * VideoGalleryController constructor.
     * @param ContactService $contact_service
     * @param VideoService $video_service
     */
    public function __construct(
        private ContactService $contact_service,
        private VideoService $video_service )
    {
        parent::__construct();
    }

    public function edit( int $contact_id )
    {
        $salon = $this->contact_service->findWithVideos( $contact_id );
        if ( $salon === null ) {
            return redirect( RouteServiceProvider::ACCOUNT_INDEX )
                ->withErrors( [ 'message' => 'Ошибка получения данных салона' ] );
        }

        return view( 'account.profile.video-gallery.edit', [
            'user'       => $this->auth_user,
            'contact_id' => $contact_id,
            'salon'      => $salon,
            'title'      => 'Видео галерея | ' . $salon->name . ' | Личный кабинет',
        ] );
    }

    /**
     * @param UpdateVideoGalleryRequest $request
     * @param int $contact_id
     * @return RedirectResponse
     */
    public function add( UpdateVideoGalleryRequest $request, int $contact_id ): RedirectResponse
    {
        $salon = $this->contact_service->findWithVideos( $contact_id );
        if ( $salon === null ) {
            return back()->withInput()->withErrors( [ 'message' => 'Ошибка получения данных салона' ] );
        }

        $dto = VideoDTO::fromRequest( $request );
        $dto->name = '';
        $dto->text = '';
        $dto->meta = [];

        $dto->contact_id = $contact_id;
        $new_video = $this->video_service->create( $dto, $salon->profile );
        if ( $new_video === null ) {
            return back()->withInput()->withErrors( [ 'message' => 'Ошибка обновления данных' ] );
        }

        VideoAddEvent::dispatch( $new_video->id );

        return redirect()->route( 'account.profile.video-gallery.edit', [
            'contact_id' => $contact_id
        ] );
    }

    public function remove( int $contact_id, int $video_id ): RedirectResponse
    {
        $video = $this->video_service->getById( $video_id );
        if ( $video === null ) {
            return back()->withInput()->withErrors( [ 'message' => 'Ошибка видео не найдено' ] );
        }

        if ( $video->contact_id !== $contact_id ) {
            return back()->withInput()->withErrors( [ 'message' => 'Ошибка нет прав на удаление видео' ] );
        }

        $video->delete();

        return redirect()->route( 'account.profile.video-gallery.edit', [
            'contact_id' => $contact_id
        ] );
    }
}
