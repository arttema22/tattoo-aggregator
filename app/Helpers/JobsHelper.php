<?php

namespace App\Helpers;

use App\Jobs\CalculateContactFilledPercentJob;

class JobsHelper
{
    public static function calculateContactFilledPercent( int $contact_id ): void
    {
        CalculateContactFilledPercentJob::dispatch( $contact_id )
            ->delay( config( 'jobs.calculate_contact_filled_percent.seconds_delay' ) );
    }
}