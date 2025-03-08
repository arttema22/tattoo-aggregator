<?php

namespace App\Observers;

use App\Helpers\JobsHelper;
use App\Models\FileInfo;

class FileInfoObserver
{
    public function created( FileInfo $file_info ) : void
    {
        JobsHelper::calculateContactFilledPercent( $file_info->file->album->contact_id );
    }

    public function updated( FileInfo $file_info ) : void
    {
        JobsHelper::calculateContactFilledPercent( $file_info->file->album->contact_id );
    }

    public function deleted( FileInfo $file_info ) : void
    {
        JobsHelper::calculateContactFilledPercent( $file_info->file->album->contact_id );
    }
}
