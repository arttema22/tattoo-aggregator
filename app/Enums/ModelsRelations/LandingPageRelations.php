<?php

namespace App\Enums\ModelsRelations;

use App\Enums\Base\IEnum;

class LandingPageRelations implements IEnum
{
    public const TAG      = 'landingPageTags';
    public const USER_TAG = 'landingPageUserTags';
    public const CITY     = 'city';
    public const REVIEWS  = 'reviews';
    public const SERVICES = 'services';
}
