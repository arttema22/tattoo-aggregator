<?php

namespace App\Observers;

use App\Helpers\JobsHelper;
use App\Models\WorkingHours;

class WorkingHoursObserver
{
    public function created( WorkingHours $working_hours ) : void
    {
        JobsHelper::calculateContactFilledPercent( $working_hours->contact_id );
    }

    public function updated( WorkingHours $working_hours ) : void
    {
        JobsHelper::calculateContactFilledPercent( $working_hours->contact_id );
    }

    public function deleted( WorkingHours $working_hours ) : void
    {
        JobsHelper::calculateContactFilledPercent( $working_hours->contact_id );
    }
}
