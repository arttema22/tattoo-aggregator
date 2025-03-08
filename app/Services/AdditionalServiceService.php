<?php

namespace App\Services;

use App\DTO\AdditionalService\AdditionalServiceDTO;
use App\Enums\ModelsRelations\AdditionalServiceRelations;
use App\Filters\AdditionalServiceFilter;
use App\Helpers\JobsHelper;
use App\Models\AdditionalService;
use App\Models\Contact;
use App\Repositories\AdditionalServiceRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AdditionalServiceService
{
    private AdditionalServiceRepository $repository;

    /**
     * AdditionalServiceService constructor.
     * @param AdditionalServiceRepository $repository
     */
    public function __construct(AdditionalServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param AdditionalServiceDTO $dto
     * @param Contact $contact
     * @return AdditionalService|null
     */
    public function create( AdditionalServiceDTO $dto, Contact $contact ): ?AdditionalService
    {
        $dto->profile_id = $contact->profile_id;
        $dto->contact_id = $contact->id;
        return $this->repository->store( $dto );
    }

    /**
     * @param int $id
     * @param AdditionalServiceDTO $dto
     * @return AdditionalService|null
     */
    public function update( int $id, AdditionalServiceDTO $dto ): ?AdditionalService
    {
        return $this->repository->update( $id, $dto );
    }

    /**
     * @param AdditionalServiceDTO $dto
     * @param Contact $contact
     * @return AdditionalService|null
     */
    public function updateOrCreate( AdditionalServiceDTO $dto, Contact $contact ): ?AdditionalService
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
     * @return bool
     */
    public function delete( int $id ): bool
    {
        return $this->repository->delete( $id );
    }

    /**
     * @param AdditionalServiceFilter $filter
     * @return Collection|LengthAwarePaginator
     */
    public function search( AdditionalServiceFilter $filter )
    {
        return $this->repository->search( $filter, [ AdditionalServiceRelations::NAME ] );
    }

    /**
     * @param \Illuminate\Support\Collection $collection_dto
     * @param Contact $contact
     * @return bool
     */
    public function sync( \Illuminate\Support\Collection $collection_dto, Contact $contact ): bool
    {
        $contact_models_id = $contact->additionalServices->pluck( 'id' );
        $dto_models_id = $collection_dto->whereNotNull( 'as_id' )->where( 'id', '!=', 0 )->pluck( 'id' );
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

        $collection_dto->whereNotNull( 'as_id' )->each( fn( $dto ) => $this->updateOrCreate( $dto, $contact ) );
        return true;
    }
}
