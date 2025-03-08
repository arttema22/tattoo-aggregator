<?php

namespace App\Enums;

use App\Enums\Base\IEnum;

class ProfileTypes implements IEnum
{
    public const UNKNOWN = 0;
    public const MASTER  = 1;
    public const SALON   = 2;
}
