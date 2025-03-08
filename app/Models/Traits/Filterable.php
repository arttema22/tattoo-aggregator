<?php

namespace App\Models\Traits;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * @param Builder $builder
     * @param QueryFilter $filter
     */
    public function scopeFilter( Builder $builder, QueryFilter $filter ): void
    {
        $filter->apply( $builder, self::getTable() );
    }
}
