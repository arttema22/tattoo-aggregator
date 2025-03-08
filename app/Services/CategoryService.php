<?php

namespace App\Services;

use App\Filters\CategoryFilter;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryService
{
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $repository;

    /**
     * @var \App\Filters\CategoryFilter
     */
    private CategoryFilter $category_filter;

    public function __construct(
        CategoryRepository $category_repository,
        CategoryFilter $category_filter
    )
    {
        $this->repository      = $category_repository;
        $this->category_filter = $category_filter;
    }

    /**
     * @param CategoryFilter $filter
     * @return Collection
     */
    public function search( CategoryFilter $filter ) : Collection
    {
        return $this->repository->search( $filter );
    }

    public function getAll() : \Illuminate\Support\Collection
    {
        $categories = Cache::get( 'categories' );
        if ( $categories === null ) {
            $categories = $this->repository->search( $this->category_filter );
            Cache::set( 'categories', $categories );
        }

        return $categories;
    }
}
