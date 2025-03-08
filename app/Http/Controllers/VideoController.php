<?php

namespace App\Http\Controllers;

use App\Services\VideoService;

class VideoController extends BasePublicController
{
    public function __construct( private VideoService $video_service )
    {
        parent::__construct();
    }

    public function show( int $id )
    {
        $video = $this->video_service->getById( $id );
        if ( $video === null ) {
            abort( 404 );
        }

        return view( 'page.video', [
            'title'  => $video->name . ' | '  . config('app.name', 'Laravel'),
            'video'  => $video,
            'videos' => $this->video_service->getRelatedVideos( $video->id, $video->profile_id )
        ] );
    }
}
