<?php

namespace App\Services;

use App\DTO\Article\ArticleDTO;
use App\Enums\ModelsRelations\ArticleRelations;
use App\Filters\ArticleFilter;
use App\Models\Article;
use App\Repositories\ArticleRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleService
{
    private ArticleRepository $repository;

    /**
     * ArticleService constructor.
     * @param ArticleRepository $repository
     */
    public function __construct( ArticleRepository $repository )
    {
        $this->repository = $repository;
    }

    /**
     * @param ArticleDTO $dto
     * @return Article|null
     */
    public function create( ArticleDTO $dto ): ?Article
    {
        return $this->repository->store( $dto );
    }

    /**
     * @param int $id
     * @return Article|null
     */
    public function publish( int $id ): ?Article
    {
        $dto = new ArticleDTO();
        $dto->published_at = Carbon::now();

        return $this->repository->update( $id, $dto );
    }

    /**
     * @param int $id
     * @param ArticleDTO $dto
     * @return Article|null
     */
    public function update( int $id, ArticleDTO $dto ): ?Article
    {
        return $this->repository->update( $id, $dto );
    }

    /**
     * @param ArticleFilter $filter
     * @param int $paginate
     * @return Collection|LengthAwarePaginator
     */
    public function search( ArticleFilter $filter, int $paginate = 0 )
    {
        return $this->repository->search( $filter, [ ArticleRelations::BANNER ], $paginate );
    }

    /**
     * @param ArticleFilter $filter
     * @return Article|null
     */
    public function get( ArticleFilter $filter ): ?Article
    {
        return $this->repository->search( $filter, [ ArticleRelations::BANNER ] )->first();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete( int $id ): bool
    {
        return $this->repository->delete( $id );
    }
}
