<?php

namespace App\Repositories;

use App\DTO\AdditionalService\AdditionalServiceDTO;
use App\Models\AdditionalService;

class AdditionalServiceRepository
{
    use HasSearch, HasUpdate, HasDelete;

    protected static function model(): string
    {
        return AdditionalService::class;
    }

    /**
     * @param AdditionalServiceDTO $dto
     * @return AdditionalService|null
     */
    public function store( AdditionalServiceDTO $dto ): ?AdditionalService
    {
        $additional_service = new AdditionalService();
        $additional_service->profile_id = $dto->profile_id;
        $additional_service->contact_id = $dto->contact_id ?? null;
        $additional_service->as_id      = $dto->as_id;

        return $additional_service->save() ? $additional_service : null;
    }

    /**
     * @param int $contact_id
     * @return bool
     */
    public function deleteByContactId( int $contact_id ): bool
    {
        return (bool)AdditionalService::whereContactId( $contact_id )->delete();
    }
}
