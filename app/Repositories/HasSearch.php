<?php

namespace App\Repositories;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

trait HasSearch
{
    abstract protected static function model();

    /**
     * @param int $id
     * @param array $relations
     */
    public function find( int $id, array $relations = [] )
    {
        $contact = static::model()::with( $relations )->find( $id );
        return
            $contact instanceof (static::model())
                ? $contact
                : null;
    }

    /**
     * @param QueryFilter $filter
     * @param array $relations
     * @param int $paginate
     * @return Collection|LengthAwarePaginator
     */
    public function search( QueryFilter $filter, array $relations = [], int $paginate = 0 )
    {
        $result = static::model()::with( $relations )->filter( $filter );
        if ( $paginate !== 0 ) {
            return $result->paginate( $paginate );
        }

        return $result->get();
    }
}
