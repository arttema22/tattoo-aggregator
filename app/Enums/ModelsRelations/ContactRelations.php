<?php

namespace App\Enums\ModelsRelations;

use App\Enums\Base\IEnum;

class ContactRelations implements IEnum
{
    public const PROFILE = 'profile';

    public const PROFILE_AND_COVER = 'profile.cover';

    public const PROFILE_AND_AVATAR = 'profile.avatar';

    public const PROFILE_AND_VIDEOS = 'profile.videos';

    public const PROFILE_AND_SERVICES = 'profile.services';

    public const SERVICES = 'services';

    public const COUNTRY = 'country';

    public const WORKING_HOURS = 'workingHours';

    public const CITY = 'city';

    public const SPECIALIZATION = 'specialization';

    public const ADDITIONAL_SERVICES = 'additionalServices';

    public const SOCIAL_NETWORKS = 'socialNetworks';

    public const ALBUMS = 'albums';

    public const COVER = 'cover';

    public const VIDEOS = 'videos';
}
