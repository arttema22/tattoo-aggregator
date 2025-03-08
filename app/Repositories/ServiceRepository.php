<?php

namespace App\Repositories;

use App\DTO\Service\ServiceDTO;
use App\Enums\CurrencyTypes;
use App\Enums\ServiceStatuses;
use App\Models\Service;

class ServiceRepository
{
    use HasSearch, HasUpdate, HasDelete;

    protected static function model(): string
    {
        return Service::class;
    }

    /**
     * @param ServiceDTO $dto
     * @return Service|null
     */
    public function store( ServiceDTO $dto ): ?Service
    {
        $service = new Service();
        $service->profile_id     = $dto->profile_id;
        $service->contact_id     = $dto->contact_id;
        $service->type           = $dto->type;
        $service->name           = $dto->name;
        $service->price          = $dto->price ?? 0.0;
        $service->currency       = $dto->currency ?? CurrencyTypes::RUB;
        $service->is_start_price = $dto->is_start_price ?? 0;
        $service->status         = $dto->status ?? ServiceStatuses::ON;

        return $service->save() ? $service : null;
    }

    /**
     * @param int $profile_id
     * @return bool
     */
    public function deleteByProfileId( int $profile_id ): bool
    {
        return (bool)Service::whereProfileId( $profile_id )->delete();
    }
}