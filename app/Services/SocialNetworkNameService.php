<?php

namespace App\Services;

use App\Enums\SocialNetworkStatuses;
use App\Filters\SocialNetworkNameFilter;
use App\Repositories\SocialNetworkNameRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SocialNetworkNameService
{
    /**
     * SocialNetworkNameService constructor.
     * @param SocialNetworkNameRepository $repository
     */
    public function __construct(
        private SocialNetworkNameRepository $repository
    ) {}

    /**
     * @param SocialNetworkNameFilter $filter
     * @return Collection|LengthAwarePaginator
     */
    public function search( SocialNetworkNameFilter $filter )
    {
        return $this->repository->search( $filter );
    }

    /**
     * @return Collection
     */
    public function allEnabled(): Collection
    {
        $social_network_name_filter = app( SocialNetworkNameFilter::class );
        $social_network_name_filter->setCustomFields( [ 'status' => SocialNetworkStatuses::ENABLED ] );

        return $this->repository->search( $social_network_name_filter );
    }
}
