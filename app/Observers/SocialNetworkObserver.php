<?php

namespace App\Observers;

use App\Helpers\JobsHelper;
use App\Models\SocialNetwork;

class SocialNetworkObserver
{
    public function created( SocialNetwork $social_network ) : void
    {
        JobsHelper::calculateContactFilledPercent( $social_network->contact_id );
    }

    public function updated( SocialNetwork $social_network ) : void
    {
        JobsHelper::calculateContactFilledPercent( $social_network->contact_id );
    }

    public function deleted( SocialNetwork $social_network ) : void
    {
        JobsHelper::calculateContactFilledPercent( $social_network->contact_id );
    }
}
