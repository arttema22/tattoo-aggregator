<?php

namespace App\Observers;

use App\Helpers\JobsHelper;
use App\Models\Service;

class ServiceObserver
{
    public function created( Service $service ) : void
    {
        JobsHelper::calculateContactFilledPercent( $service->contact_id );
    }

    public function updated( Service $service ) : void
    {
        JobsHelper::calculateContactFilledPercent( $service->contact_id );
    }

    public function deleted( Service $service ) : void
    {
        JobsHelper::calculateContactFilledPercent( $service->contact_id );
    }
}
