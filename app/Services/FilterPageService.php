<?php

namespace App\Services;

use App\Filters\FilterPageFilter;
use App\Models\FilterPage;
use App\Repositories\FilterPageRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class FilterPageService
{
    public function __construct(
        private FilterPageRepository $repository,
    ) {}

    public function get( FilterPageFilter $filter ) : ?FilterPage
    {
        return $this->repository->search( $filter )->first();
    }

    public function searchRelated( int $type, array $dictionary_ids ): Collection|LengthAwarePaginator
    {
        if ( !$dictionary_ids ) {
            return collect();
        }

        $filter = app()->make( FilterPageFilter::class );
        $filter->setCustomFields( [ 'type' => $type, 'dictionaries' => $dictionary_ids ] );

        return
            $this->repository
                ->search( $filter )
                ->filter( fn ( FilterPage $filter_page ) => array_diff( $filter_page->dictionary, $dictionary_ids ) );
    }
}
