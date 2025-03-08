<?php

namespace App\Repositories;

use App\DTO\Review\SalonSelectionRequestDTO;
use App\Models\SalonSelectionRequest;

class SalonSelectionRequestRepository
{
    use HasSearch,
        HasUpdate;

    protected static function model(): string
    {
        return SalonSelectionRequest::class;
    }

    /**
     * @param SalonSelectionRequestDTO $dto
     * @return SalonSelectionRequest|null
     */
    public function store( SalonSelectionRequestDTO $dto ): ?SalonSelectionRequest
    {
        $salon_selection_request = new SalonSelectionRequest();
        $salon_selection_request->landing_page_id = $dto->landing_page_id;
        $salon_selection_request->city_id         = $dto->city_id;
        $salon_selection_request->types           = $dto->types;
        $salon_selection_request->phone           = $dto->phone ?? '';
        $salon_selection_request->description     = $dto->description ?? '';
        $salon_selection_request->is_mail_sent    = $dto->is_mail_sent ?? 0;

        return $salon_selection_request->save() ? $salon_selection_request : null;
    }
}