<?php

namespace App\Listeners;

use App\Events\SalonCoordinatesChangedEvent;
use App\Jobs\CalculateDistanceBetweenSalonsJob;

class SalonCoordinatesChangedListener
{
    /**
     * @param SalonCoordinatesChangedEvent $event
     * @return void
     */
    public function handle( SalonCoordinatesChangedEvent $event ): void
    {
        CalculateDistanceBetweenSalonsJob::dispatch( $event->getContactDto() );
    }
}
