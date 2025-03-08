<?php

namespace App\Services;

use App\DTO\Service\ServiceDTO;
use App\Enums\SpecializationTypeNames;
use App\Enums\SpecializationTypes;
use App\Filters\ServiceFilter;
use App\Helpers\DictionaryHelper;
use App\Helpers\JobsHelper;
use App\Models\Contact;
use App\Models\Service;
use App\Repositories\ServiceRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Psr\SimpleCache\InvalidArgumentException;

class ServiceService
{
    private ServiceRepository $repository;

    /**
     * ServiceService constructor.
     * @param ServiceRepository $repository
     */
    public function __construct(ServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ServiceDTO $dto
     * @param Contact $contact
     * @return Service|null
     */
    public function create( ServiceDTO $dto, Contact $contact ): ?Service
    {
        $dto->profile_id = $contact->profile_id;
        $dto->contact_id = $contact->id;

        return $this->repository->store( $dto );
    }

    /**
     * @param int $id
     * @param ServiceDTO $dto
     * @return Service|null
     */
    public function update( int $id, ServiceDTO $dto ): ?Service
    {
        return $this->repository->update( $id, $dto );
    }

    /**
     * @param ServiceDTO $dto
     * @param Contact $contact
     * @return Service|null
     */
    public function updateOrCreate( ServiceDTO $dto, Contact $contact ): ?Service
    {
        if ( isset( $dto->id ) ) {
            $id = $dto->id;
            unset( $dto->id );

            return $this->update( $id, $dto );
        }

        return $this->create( $dto, $contact );
    }

    /**
     * @param ServiceFilter $filter
     * @return Collection|LengthAwarePaginator
     */
    public function search( ServiceFilter $filter )
    {
        return $this->repository->search( $filter );
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
        $contact_models_id = $contact->services->pluck( 'id' );
        $dto_models_id = $collection_dto->whereNotNull( 'id' )->pluck( 'id' );
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

        $collection_dto->each( fn( $dto ) => $this->updateOrCreate( $dto, $contact ) );
        return true;
    }

    /**
     * @param Collection $services
     * @return array
     */
    public function getServicesByTypes( Collection $services ): array
    {
        if ( $services->isEmpty() ) {
            return [];
        }

        $collection_dto = $services->map( fn( $service ) => ServiceDTO::fromModel( $service ) );
        return [
            SpecializationTypeNames::TATTOO   => $collection_dto->where( 'type', SpecializationTypes::TATTOO ),
            SpecializationTypeNames::TATUAJE  => $collection_dto->where( 'type', SpecializationTypes::TATUAJE ),
            SpecializationTypeNames::PIERCING => $collection_dto->where( 'type', SpecializationTypes::PIERCING ),
            SpecializationTypeNames::OTHER    => $collection_dto->where( 'type', SpecializationTypes::OTHER ),
        ];
    }

    /**
     * @return array
     * @throws InvalidArgumentException
     */
    public function getDefaultServicesByTypes(): array
    {
        $createServiceDTO = static function( $item ) {
            $dto = App::make( ServiceDTO::class );
            $dto->name = $item;
            return $dto;
        };

        return [
            SpecializationTypeNames::TATTOO   => DictionaryHelper::serviceTattoo()->map( fn( $item ) => $createServiceDTO( $item ) ),
            SpecializationTypeNames::TATUAJE  => DictionaryHelper::serviceTatuaje()->map( fn( $item ) => $createServiceDTO( $item ) ),
            SpecializationTypeNames::PIERCING => DictionaryHelper::servicePiercing()->map( fn( $item ) => $createServiceDTO( $item ) ),
            SpecializationTypeNames::OTHER    => DictionaryHelper::serviceOther()->map( fn( $item ) => $createServiceDTO( $item ) ),
        ];
    }
}
