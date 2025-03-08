<?php

namespace App\Enums;

use App\Enums\Base\IEnum;

class ServiceStatuses implements IEnum
{
    public const UNKNOWN = 0;
    public const ON      = 1;
    public const OFF     = 2;
}
