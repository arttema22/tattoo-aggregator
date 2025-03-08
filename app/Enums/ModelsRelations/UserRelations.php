<?php

namespace App\Enums\ModelsRelations;

use App\Enums\Base\IEnum;

class UserRelations implements IEnum
{
    public const PROFILE_AND_CONTACTS = 'profile.contacts';

    public const PROFILE = 'profile';
}
