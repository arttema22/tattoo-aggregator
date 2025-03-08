<?php

namespace App\Repositories;

use App\DTO\File\FileDTO;
use App\Enums\FileSubtypes;
use App\Filters\QueryFilter;
use App\Models\File;

class FileRepository
{
    use HasSearch, HasUpdate, HasDelete;

    /**
     * @return string
     */
    protected static function model(): string
    {
        return File::class;
    }

    /**
     * @param FileDTO $dto
     * @return File|null
     */
    public function store( FileDTO $dto ): ?File
    {
        $file = new File();
        $file->user_id          = $dto->user_id ?? 0;
        $file->original         = $dto->original ?? '';
        $file->fileable_id      = $dto->fileable_id ?? 0;
        $file->fileable_type    = $dto->fileable_type ?? '';
        $file->fileable_subtype = $dto->fileable_subtype ?? FileSubtypes::COMMON;
        $file->size             = $dto->size ?? 0;
        $file->mime_type        = $dto->mime_type ?? '';
        $file->thumbs           = $dto->thumbs ?? [];

        return $file->save() ? $file : null;
    }

    public function first( QueryFilter $filter, array $relations = [] ) : ?File
    {
        return static::model()::with( $relations )->filter( $filter )->first();
    }
}
