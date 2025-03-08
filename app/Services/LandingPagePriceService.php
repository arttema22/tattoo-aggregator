<?php

namespace App\Services;

use App\Filters\LandingPageServiceFilter;
use App\Repositories\LandingPageServiceRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class LandingPagePriceService
{
    public function __construct(
        private LandingPageServiceRepository $repository
    ) {}

    /**
     * @param LandingPageServiceFilter $filter
     * @return Collection|LengthAwarePaginator
     */
    public function search( LandingPageServiceFilter $filter ) : Collection|LengthAwarePaginator
    {
        return $this->repository->search( $filter );
    }

    /**
     * @param int $landing_page_id
     * @param int $type
     * @param array $data
     * @return void
     */
    public function fill( int $landing_page_id, int $type, array $data ) : void
    {
        foreach ($data as $item) {
            $insert = [
                'landing_page_id' => $landing_page_id,
                'type'            => $type,
                'name'            => $item[ 'name' ],
                'price'           => $item[ 'price' ],
                'currency'        => $item[ 'currency' ],
                'is_start_price'  => $item[ 'start' ],
            ];

            $model = \App\Models\LandingPageService::make();
            $model->fill( $insert )->save();
        }
    }
}
