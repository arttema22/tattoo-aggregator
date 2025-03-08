<?php

namespace App\Enums;

use App\Enums\Base\IEnum;

class FileSubtypes implements IEnum
{
    // обычное изображение, используемое для работ, профиля и прочего
    public const COMMON = 0;

    // изображение, которое будет использоваться в качестве аватара в профиле
    public const PROFILE_AVATAR = 1;
}
