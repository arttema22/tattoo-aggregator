<?php

namespace App\Services;

use App\Filters\SalonSelectionRequestFilter;
use App\Repositories\SalonSelectionRequestRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SalonSelectionRequestService
{
    public function __construct(
        private SalonSelectionRequestRepository $repository
    ) {}

    public function search( SalonSelectionRequestFilter $filter, int $paginate = 0 ): Collection|LengthAwarePaginator
    {
        return $this->repository->search(
            $filter,
            [],
            $paginate
        );
    }
}