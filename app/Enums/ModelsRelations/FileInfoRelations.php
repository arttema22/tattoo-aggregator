<?php

namespace App\Enums\ModelsRelations;

use App\Enums\Base\IEnum;

class FileInfoRelations implements IEnum
{
    public const FILE = 'file';

    public const FILE_AND_FILEABLE = 'file.fileable';
}
