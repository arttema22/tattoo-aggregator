<?php

namespace App\Repositories;

use App\DTO\User\UserDTO;
use App\Models\User;

class UserRepository
{
    use HasSearch, HasUpdate;

    protected static function model(): string
    {
        return User::class;
    }

    /**
     * @param UserDTO $dto
     * @return User|null
     */
    public function store( UserDTO $dto ): ?User
    {
        $user = new User();
        $user->name              = $dto->name;
        $user->email             = $dto->email;
        $user->role              = $dto->role;
        $user->password          = $dto->password;
        $user->email_verified_at = $dto->email_verified_at ?? null;

        return $user->save() ? $user : null;
    }
}
