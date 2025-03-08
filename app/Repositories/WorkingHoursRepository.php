<?php

namespace App\Repositories;

use App\DTO\WorkingHours\WorkingHoursDTO;
use App\Models\WorkingHours;

class WorkingHoursRepository
{
    use HasSearch, HasUpdate, HasDelete;

    protected static function model(): string
    {
        return WorkingHours::class;
    }

    /**
     * @param WorkingHoursDTO $dto
     * @return WorkingHours|null
     */
    public function store( WorkingHoursDTO $dto ): ?WorkingHours
    {
        $working_hours = new WorkingHours();
        $working_hours->profile_id = $dto->profile_id;
        $working_hours->contact_id = $dto->contact_id ?? null;
        $working_hours->day        = $dto->day ?? 0;
        $working_hours->start      = $dto->start ?? null;
        $working_hours->end        = $dto->end ?? null;
        $working_hours->is_weekend = $dto->is_weekend ?? false;
        $working_hours->is_nonstop = $dto->is_nonstop ?? false;

        return $working_hours->save() ? $working_hours : null;
    }

    /**
     * @param int $contact_id
     * @return bool
     */
    public function deleteByContactId( int $contact_id ): bool
    {
        return (bool)WorkingHours::whereContactId( $contact_id )->delete();
    }
}
