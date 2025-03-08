<?php

namespace App\Repositories;

use App\Models\AdditionalServiceName;
use Illuminate\Database\Eloquent\Collection;

class AdditionalServiceNameRepository
{
    use HasSearch;

    protected static function model(): string
    {
        return AdditionalServiceName::class;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return AdditionalServiceName::all();
    }
}
