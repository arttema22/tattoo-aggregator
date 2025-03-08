<?php

namespace App\Services;

use App\DTO\Contact\ContactDTO;
use App\Enums\ModelsRelations\ContactRelations;
use App\Filters\ContactFilter;
use App\Helpers\AliasHelper;
use App\Models\Contact;
use App\Models\Profile;
use App\Repositories\ContactRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;

class ContactService
{

    public function __construct(
        private ContactRepository $repository,
        private ContactFilter     $filter,
    ){}

    /**
     * @param ContactDTO $dto
     * @param Profile $profile
     * @return Contact|null
     */
    public function create( ContactDTO $dto, Profile $profile ): ?Contact
    {
        $dto->profile_id = $profile->id;
        if (empty($dto->alias)) {
            $dto->alias = AliasHelper::getRandom( $profile->id );
        }

        return $this->repository->store( $dto );
    }

    /**
     * @param Profile $profile
     * @return Contact|null
     */
    public function createEmpty( Profile $profile ): ?Contact
    {
        $dto = new ContactDTO();
        $dto->profile_id = $profile->id;
        $dto->alias      = AliasHelper::getRandom( $profile->id );

        return $this->repository->store( $dto );
    }

    /**
     * @param int $id
     * @param ContactDTO $dto
     * @return Contact|null
     */
    public function update( int $id, ContactDTO $dto ): ?Contact
    {
        if ( isset( $dto->alias ) ) {
            $dto->alias = AliasHelper::getFromString( $dto->alias );
        }

        return $this->repository->update( $id, $dto );
    }

    /**
     * @param ContactDTO $dto
     * @param Profile $profile
     * @return Contact|null
     */
    public function updateOrCreate( ContactDTO $dto, Profile $profile ): ?Contact
    {
        if ( isset( $dto->id ) ) {
            $id = $dto->id;
            unset( $dto->id );

            return $this->update( $id, $dto );
        }

        return $this->create( $dto, $profile );
    }

    /**
     * @param int $id
     * @param array $relations
     * @return Contact|null
     */
    public function find( int $id, array $relations = [] ): ?Contact
    {
        return $this->repository->find( $id, $relations );
    }

    /**
     * @param int $id
     * @return Contact|null
     */
    public function findWithCityAndCountry( int $id ): ?Contact
    {
        return $this->repository->find( $id, [ ContactRelations::CITY, ContactRelations::COUNTRY ] );
    }

    /**
     * @param int $id
     * @return Contact|null
     */
    public function findWithAdditionalServices( int $id ): ?Contact
    {
        return $this->repository->find( $id, [ ContactRelations::ADDITIONAL_SERVICES ] );
    }

    /**
     * @param int $id
     * @return Contact|null
     */
    public function findWithSocialNetworks( int $id ): ?Contact
    {
        return $this->repository->find( $id, [ ContactRelations::SOCIAL_NETWORKS ] );
    }

    /**
     * @param int $id
     * @return Contact|null
     */
    public function findWithVideos( int $id ): ?Contact
    {
        return $this->repository->find( $id, [ ContactRelations::VIDEOS ] );
    }

    /**
     * @param int $id
     * @return Contact|null
     */
    public function findWithWorkingHours( int $id ): ?Contact
    {
        return $this->repository->find( $id, [ ContactRelations::WORKING_HOURS ] );
    }

    /**
     * @param int $id
     * @return Contact|null
     */
    public function findWithServices( int $id ): ?Contact
    {
        return $this->repository->find( $id, [ ContactRelations::SERVICES ] );
    }

    /**
     * @param int $id
     * @return Contact|null
     */
    public function findWithProfileAndCover( int $id ): ?Contact
    {
        return $this->repository->find( $id, [ ContactRelations::PROFILE_AND_COVER ] );
    }

    /**
     * @param int $id
     * @return Contact|null
     */
    public function findWithCover( int $id ): ?Contact
    {
        return $this->repository->find( $id, [ ContactRelations::COVER ] );
    }

    /**
     * @param int $id
     * @return Contact|null
     */
    public function findWithAlbums( int $id ): ?Contact
    {
        return $this->repository->find( $id, [ ContactRelations::ALBUMS ] );
    }

    /**
     * @param int $id
     * @return Contact|null
     */
    public function findWithProfile( int $id ): ?Contact
    {
        return $this->repository->find( $id, [ ContactRelations::PROFILE ] );
    }

    /**
     * @param string $alias
     * @return bool
     */
    public function isAliasAvailable( string $alias ): bool
    {
        $filter = App::make( ContactFilter::class );
        $filter->setCustomFields( [ 'alias' => $alias ] );

        return $this->repository->search( $filter )->isEmpty();
    }

    /**
     * @param ContactFilter $filter
     * @param int $paginate
     * @return Collection|LengthAwarePaginator
     */
    public function search( ContactFilter $filter, int $paginate = 0 )
    {
        return $this->repository->search(
            $filter,
            [
                ContactRelations::PROFILE_AND_COVER,
                ContactRelations::PROFILE_AND_AVATAR,
                ContactRelations::CITY,
                ContactRelations::SPECIALIZATION,
            ],
            $paginate
        );
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete( int $id ): bool
    {
        return $this->repository->delete( $id );
    }

    /**
     * @param string $alias
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findByAlias( string $alias ) : ?Contact
    {
        $this->filter->setCustomFields( [
            'alias' => $alias
        ] );

        return $this->repository->first( $this->filter );
    }

    public function getAllShort( ContactFilter $filter )
    {
        return $this->repository->search(
            $filter,
        );
    }
}
