<?php

namespace App\Services;

use App\Filters\ReviewFilter;
use App\Repositories\ReviewRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class ReviewService
{
    public function __construct(
        private ReviewRepository $repository
    ) {}

    public function search( ReviewFilter $filter, int $paginate = 0 ): Collection|LengthAwarePaginator
    {
        return $this->repository->search(
            $filter,
            [],
            $paginate
        );
    }

    private function getMaxId(): int
    {
        return (int) Cache::remember(
            'reviewsMaxId',
            config( 'review.cache_max_id_ttl' ),
            fn () => $this->repository->getMaxId()
        );
    }

    public function getRandom( int $count ): Collection|LengthAwarePaginator
    {
        // получаем больше записей, чем есть на случай не аппрувленных или удаленных
        $limit = 3 * $count;

        $ids = [];
        for ( $i = 0; $i < $limit; $i++ ) {
            $ids[] = random_int( 1, $this->getMaxId() );
        }

        $filter = app()->make( ReviewFilter::class );
        $filter->setCustomFields( [
            'ids' => [ array_unique( $ids ) ],
            'limit' => $limit,
            'isApproved' => true,
        ] );

        return $this->search( $filter )->slice( 0, $count );
    }
}
