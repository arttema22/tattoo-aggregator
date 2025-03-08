<?php

namespace App\Services;

use App\Filters\AdditionalServiceNameFilter;
use App\Repositories\AdditionalServiceNameRepository;
use Illuminate\Database\Eloquent\Collection;

class AdditionalServiceNameService
{
    private AdditionalServiceNameRepository $repository;

    /**
     * AdditionalServiceNameService constructor.
     * @param AdditionalServiceNameRepository $repository
     */
    public function __construct( AdditionalServiceNameRepository $repository )
    {
        $this->repository = $repository;
    }

    public function search( AdditionalServiceNameFilter $filter )
    {
        return $this->repository->search( $filter );
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->repository->all();
    }
}
