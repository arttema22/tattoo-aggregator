<?php

namespace App\Repositories;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

trait HasFirst
{
    abstract protected static function model();

    /**
     * @param QueryFilter $filter
     * @param array $relations
     * @return Model
     */
    public function first( QueryFilter $filter, array $relations = [] )
    {
        return static::model()::with( $relations )->filter( $filter )->first();
    }
}
