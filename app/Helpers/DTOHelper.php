<?php

namespace App\Helpers;

use App\DTO\BaseDTO;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Support\Collection;

class DTOHelper
{
    public static function getDTOCollection( string $dto_class, BaseFormRequest $request ): Collection
    {
        /** @var BaseDTO $dto_class */
        $collection = new Collection();
        if ( method_exists( $dto_class, 'generatorFromRequest' ) ) {
            foreach ( $dto_class::generatorFromRequest( $request ) as $dto ) {
                $collection->push( $dto );
            }
        }

        return $collection;
    }
}