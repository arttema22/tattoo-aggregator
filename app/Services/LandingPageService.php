<?php

namespace App\Services;

use App\Enums\ModelsRelations\LandingPageRelations;
use App\Filters\LandingPageFilter;
use App\Models\LandingPage;
use App\Repositories\LandingPageRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class LandingPageService
{
    public function __construct(
        private LandingPageRepository $repository
    ) {}

    public function search( LandingPageFilter $filter, int $paginate = 0 ): Collection|LengthAwarePaginator
    {
        return $this->repository->search(
            $filter,
            [],
            $paginate
        );
    }

    /**
     * @param LandingPageFilter $filter
     * @return LandingPage|null
     */
    public function get( LandingPageFilter $filter ): ?LandingPage
    {
        return $this->repository->search(
            $filter,
            [
                LandingPageRelations::TAG,
                LandingPageRelations::CITY,
                LandingPageRelations::REVIEWS,
                LandingPageRelations::USER_TAG,
            ]
        )->first();
    }

    public function syncReviews( LandingPage $landing_page, \Illuminate\Support\Collection $review_ids ): void
    {
        $landing_page->reviews()->sync( $review_ids );
    }
}
