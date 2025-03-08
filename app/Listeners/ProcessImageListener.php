<?php

namespace App\Listeners;

use App\Events\UploadedImageEvent;
use App\Jobs\ProcessImageJob;
use App\Jobs\Queue;

class ProcessImageListener
{
    /**
     * @param UploadedImageEvent $event
     * @return void
     */
    public function handle(UploadedImageEvent $event ): void
    {
        ProcessImageJob::dispatch( $event->getFileDTO() )->onQueue( Queue::IMAGE );
    }
}
