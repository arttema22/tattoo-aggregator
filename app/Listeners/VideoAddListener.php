<?php

namespace App\Listeners;

use App\Events\Base\IVideoEvent;
use App\Jobs\GetInfoVideoJob;

class VideoAddListener
{
    /**
     * Handle the event.
     * @param  IVideoEvent $event
     * @return void
     */
    public function handle( IVideoEvent $event )
    {
        GetInfoVideoJob::dispatch( $event->video_id );
    }
}
