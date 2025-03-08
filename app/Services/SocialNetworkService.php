<?php

namespace App\Services;

use App\DTO\SocialNetwork\SocialNetworkDTO;
use App\Enums\ModelsRelations\SocialNetworkRelations;
use App\Enums\SocialNetworkStatuses;
use App\Filters\SocialNetworkFilter;
use App\Helpers\JobsHelper;
use App\Models\Contact;
use App\Models\SocialNetwork;
use App\Repositories\SocialNetworkRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SocialNetworkService
{
    private SocialNetworkRepository $repository;

    /**
     * SocialNetworkService constructor.
     * @param SocialNetworkRepository $repository
     */
    public function __construct(SocialNetworkRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param SocialNetworkDTO $dto
     * @param Contact $contact
     * @return SocialNetwork|null
     */
    public function create( SocialNetworkDTO $dto, Contact $contact ): ?SocialNetwork
    {
        $dto->contact_id = $contact->id;
        $dto->profile_id = $contact->profile_id;
        $dto->status = SocialNetworkStatuses::ENABLED;
        return $this->repository->store( $dto );
    }

    /**
     * @param int $id
     * @param SocialNetworkDTO $dto
     * @return SocialNetwork|null
     */
    public function update( int $id, SocialNetworkDTO $dto ): ?SocialNetwork
    {
        return $this->repository->update( $id, $dto );
    }

    /**
     * @param SocialNetworkDTO $dto
     * @param Contact $contact
     * @return SocialNetwork|null
     */
    public function updateOrCreate( SocialNetworkDTO $dto, Contact $contact ): ?SocialNetwork
    {
        if ( isset( $dto->id ) && $dto->id !== 0 ) {
            $id = $dto->id;
            unset( $dto->id );

            return $this->update( $id, $dto );
        }

        return $this->create( $dto, $contact );
    }

    /**
     * @param int $id
     * @return SocialNetwork|null
     */
    public function disable( int $id ): ?SocialNetwork
    {
        $dto = new SocialNetworkDTO();
        $dto->status = SocialNetworkStatuses::DISABLED;
        return $this->update( $id, $dto );
    }

    /**
     * @param int $id
     * @return SocialNetwork|null
     */
    public function enable( int $id ): ?SocialNetwork
    {
        $dto = new SocialNetworkDTO();
        $dto->status = SocialNetworkStatuses::ENABLED;
        return $this->update( $id, $dto );
    }

    /**
     * @param SocialNetworkFilter $filter
     * @return Collection|LengthAwarePaginator
     */
    public function search( SocialNetworkFilter $filter )
    {
        return $this->repository->search( $filter, [ SocialNetworkRelations::NAME ] );
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
     * @param \Illuminate\Support\Collection $collection_dto
     * @param Contact $contact
     * @return bool
     */
    public function sync( \Illuminate\Support\Collection $collection_dto, Contact $contact ): bool
    {
        $contact_models_id = $contact->socialNetworks->pluck( 'id' );
        $dto_models_id = $collection_dto->where( 'id', '!=', 0 )->where( 'value', '!=', '' )->pluck( 'id' );
        if ( $dto_models_id->diff( $contact_models_id )->isNotEmpty() ) {
            // если в переданных данных есть идентификаторы модели не относящиеся к переданному контакту,
            // то пришли некорректные данные, и ничего не синхронизируем
            return false;
        }

        // удаляем данные, по которым не пришло идентификаторов
        $contact_models_id
            ->diff( $dto_models_id )
            ->each( fn( $id ) => $this->delete( $id ) );

        JobsHelper::calculateContactFilledPercent( $contact->id );

        $collection_dto->where( 'value', '!=', '' )->each( fn( $dto ) => $this->updateOrCreate( $dto, $contact ) );
        return true;
    }
}
