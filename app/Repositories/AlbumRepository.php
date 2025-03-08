<?php

namespace App\Repositories;

use App\DTO\Album\AlbumDTO;
use App\Models\Album;

class AlbumRepository
{
    use HasSearch, HasUpdate, HasDelete;

    protected static function model(): string
    {
        return Album::class;
    }

    /**
     * @param AlbumDTO $dto
     * @return Album|null
     */
    public function store( AlbumDTO $dto ): ?Album
    {
        $album = new Album();
        $album->contact_id  = $dto->contact_id;
        $album->type        = $dto->type;
        $album->name        = $dto->name;
        $album->description = $dto->description ?? '';

        return $album->save() ? $album : null;
    }
}
