<?php

namespace App\Enums\ModelsRelations;

use App\Enums\Base\IEnum;

class AlbumRelations implements IEnum
{
    public const CONTACT_AND_CITY = 'contact.city';

    public const CONTACT_AND_PROFILE = 'contact.profile';

    public const FILES = 'files';

    public const FILES_AND_FILE_INFO = 'files.fileInfo';
}
