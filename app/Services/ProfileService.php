<?php

namespace App\Services;

use App\DTO\Profile\ProfileDTO;
use App\Enums\ModelsRelations\ProfileRelations;
use App\Filters\ProfileFilter;
use App\Models\Profile;
use App\Models\User;
use App\Repositories\ProfileRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;

class ProfileService
{
    private ProfileRepository $repository;

    /**
     * ProfileService constructor.
     * @param ProfileRepository $repository
     */
    public function __construct( ProfileRepository $repository )
    {
        $this->repository = $repository;
    }

    /**
     * @param ProfileDTO $dto
     * @param User $user
     * @return Profile|null
     */
    public function create( ProfileDTO $dto, User $user ): ?Profile
    {
        $dto->user_id = $user->id;
        $dto->name    = $user->name;
        return $this->repository->store( $dto );
    }

    /**
     * @param int $id
     * @param ProfileDTO $dto
     * @return Profile|null
     */
    public function update( int $id, ProfileDTO $dto ): ?Profile
    {
        return $this->repository->update( $id, $dto );
    }

    /**
     * @param ProfileFilter $filter
     * @return Collection|LengthAwarePaginator
     */
    public function search( ProfileFilter $filter )
    {
        return
            $this->repository->search(
                $filter,
                [
                    ProfileRelations::SOCIAL_NETWORKS,
                    ProfileRelations::ADDITIONAL_SERVICES
                ] );
    }

    /**
     * @param int $id
     * @return Profile|null
     */
    public function find( int $id ): ?Profile
    {
        return $this->repository->find( $id );
    }

    /**
     * @param ProfileFilter $filter
     * @return Profile|null
     */
    public function get( ProfileFilter $filter ): ?Profile
    {
        return
            $this->repository->search(
                $filter,
                [
                    ProfileRelations::SOCIAL_NETWORKS,
                    ProfileRelations::ADDITIONAL_SERVICES
                ] )->first();
    }

    /**
     * @param int $id
     * @return Profile|null
     */
    public function approve( int $id ): ?Profile
    {
        /** @var ProfileDTO $dto */
        $dto = App::make( ProfileDTO::class );
        $dto->approved = 1;

        return $this->repository->update( $id, $dto );
    }
}
