<?php

namespace App\Services;

use App\Filters\ContactFilledCriteriaFilter;
use App\Repositories\ContactFilledCriteriaRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;

class ContactFilledCriteriaService
{
    public function __construct(private ContactFilledCriteriaRepository $repository) {}

    public function search( ContactFilledCriteriaFilter $filter ): Collection
    {
        return $this->repository->search( $filter );
    }

    public function getByType( int $type ): Collection
    {
        /** @var ContactFilledCriteriaFilter $filter */
        $filter = App::make( ContactFilledCriteriaFilter::class );
        $filter->setCustomFields( [ 'type' => $type ] );

        return $this->search( $filter );
    }
}