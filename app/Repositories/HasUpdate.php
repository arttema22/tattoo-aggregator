<?php

namespace App\Repositories;

use App\DTO\BaseDTO;
use Illuminate\Database\Eloquent\Model;

trait HasUpdate
{
    abstract protected static function model();

    /**
     * @param int $id
     * @param BaseDTO $dto
     * @param array $relations
     * @return Model|null
     */
    public function update( int $id, BaseDTO $dto, array $relations = [] ): ?Model
    {
        /** @var Model|null $model */
        $model = $this->find( $id, $relations );
        if ( $model === null ) {
            return null;
        }

        return $model->update( $dto->toArray() ) ? $model : null;
    }
}
