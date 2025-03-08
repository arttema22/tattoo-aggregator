<?php

namespace App\Services;

use App\DTO\User\ChangePasswordDTO;
use App\DTO\User\UserDTO;
use App\Enums\ModelsRelations\UserRelations;
use App\Enums\ProfileTypes;
use App\Filters\UserFilter;
use App\Models\Contact;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private UserRepository $repository;

    /**
     * UserService constructor.
     * @param UserRepository $repository
     */
    public function __construct( UserRepository $repository )
    {
        $this->repository = $repository;
    }

    /**
     * @param UserDTO $dto
     * @return User|null
     */
    public function create( UserDTO $dto ): ?User
    {
        // пока что тут добавляем только обычного пользователя
        $dto->role = config( 'roles.seller' );

        $dto->password = Hash::make( $dto->password );

        return $this->repository->store( $dto );
    }

    /**
     * @param int $id
     * @param UserDTO $dto
     * @return User|null
     */
    public function update( int $id, UserDTO $dto ): ?User
    {
        return $this->repository->update( $id, $dto );
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function find( int $id ): ?User
    {
        return $this->repository->find( $id );
    }

    /**
     * @param UserFilter $filter
     * @return Collection|LengthAwarePaginator
     */
    public function search( UserFilter $filter )
    {
        return $this->repository->search( $filter );
    }

    /**
     * @param int $id
     * @param ChangePasswordDTO $dto
     * @return bool
     */
    public function changePassword( int $id, ChangePasswordDTO $dto ): bool
    {
        $dto->password = Hash::make( $dto->password );

        return $this->repository->update( $id, $dto ) !== null;
    }

    /**
     * @param int $id
     * @return Contact|null
     */
    public function getContactForMaster( int $id ): ?Contact
    {
        /** @var User $user */
        $user = $this->repository->find( $id, [ UserRelations::PROFILE_AND_CONTACTS ] );
        if ( $user === null ) {
            return null;
        }

        if ( $user->profile?->type !== ProfileTypes::MASTER ) {
            return null;
        }

        return $user->profile->contacts->first();
    }

    /**
     * @param string $email
     * @return bool
     */
    public function isApproved( string $email ): bool
    {
        $filter = App::make( UserFilter::class );
        $filter->setCustomFields( [ 'email' => $email ] );

        /** @var User|null $user */
        $user = $this->repository->search( $filter, [ UserRelations::PROFILE ] )?->first();

        return $user?->profile?->approved ?? false;
    }
}
