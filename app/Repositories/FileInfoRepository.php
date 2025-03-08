<?php

namespace App\Repositories;

use App\DTO\FileInfo\FileInfoDTO;
use App\Enums\WorkApproved;
use App\Models\FileInfo;

class FileInfoRepository
{
    use HasSearch, HasUpdate, HasDelete;

    /**
     * @return string
     */
    protected static function model(): string
    {
        return FileInfo::class;
    }

    /**
     * @param FileInfoDTO $dto
     * @return FileInfo|null
     */
    public function store( FileInfoDTO $dto ): ?FileInfo
    {
        $file_info = new FileInfo();
        $file_info->file_id         = $dto->file_id;
        $file_info->name            = $dto->name;
        $file_info->description     = $dto->description;
        $file_info->attribute       = $dto->attribute;
        $file_info->is_downloadable = $dto->is_downloadable ?? 0;
        $file_info->is_adult        = $dto->is_adult ?? 0;
        $file_info->is_approved     = $dto->is_approved ?? WorkApproved::WAIT;

        return $file_info->save() ? $file_info : null;
    }
}
