<?php

namespace App\Observers;

use App\Helpers\JobsHelper;
use App\Models\AdditionalService;

class AdditionalServiceObserver
{
    public function created( AdditionalService $additional_service ) : void
    {
        JobsHelper::calculateContactFilledPercent( $additional_service->contact_id );
    }

    public function updated( AdditionalService $additional_service ) : void
    {
        JobsHelper::calculateContactFilledPercent( $additional_service->contact_id );
    }

    public function deleted( AdditionalService $additional_service ) : void
    {
        JobsHelper::calculateContactFilledPercent( $additional_service->contact_id );
    }
}
