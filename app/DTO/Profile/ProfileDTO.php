<?php

namespace App\DTO\Profile;

use App\DTO\BaseDTO;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @property int $type
 * @property string $name
 * @property string $description
 * @property bool $approved
 * @property int $user_id
 * @property int $cover_id
 *
 * Class ProfileDTO
 */
class ProfileDTO extends BaseDTO
{
    /**
     * @return array
     */
    protected static function map(): array
    {
        return [
            'type'        => [ 'property' => 'type',        'type' => 'int' ],
            'name'        => [ 'property' => 'name',        'type' => 'string' ],
            'description' => [ 'property' => 'description', 'type' => 'string' ],
            'user_id'     => [ 'property' => 'user_id',     'type' => 'int' ],
            'approved'    => [ 'property' => 'approved',    'type' => 'bool',  'default' => false ]
        ];
    }

    /**
     * @param BaseFormRequest $request
     * @return static
     */
    public static function fromRequest( BaseFormRequest $request ): self
    {
        $dto = parent::fromRequest( $request );
        $dto->user_id = (int)Auth::id();

        return $dto;
    }
}
