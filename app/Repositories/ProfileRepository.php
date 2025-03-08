<?php

namespace App\Repositories;

use App\DTO\Profile\ProfileDTO;
use App\Models\Profile;

class ProfileRepository
{
    use HasSearch, HasUpdate;

    protected static function model(): string
    {
        return Profile::class;
    }

    /**
     * @param ProfileDTO $dto
     * @return Profile|null
     */
    public function store( ProfileDTO $dto ): ?Profile
    {
        $profile = new Profile();
        $profile->user_id     = $dto->user_id;
        $profile->type        = $dto->type;
        $profile->name        = $dto->name;
        $profile->description = $dto->description ?? '';

        return $profile->save() ? $profile : null;
    }
}
