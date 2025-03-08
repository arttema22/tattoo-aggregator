<?php

namespace App\DTO\WorkingHours;

use App\DTO\BaseDTO;
use App\DTO\IsArray;

/**
 * @property int $id
 * @property int $profile_id
 * @property int $contact_id
 * @property int $day
 * @property string $start
 * @property string $end
 * @property bool $is_weekend
 * @property bool $is_nonstop
 *
 * Class WorkingHoursDTO
 */
class WorkingHoursDTO extends BaseDTO
{
    use IsArray;

    /**
     * @return string
     */
    protected static function array_key(): string
    {
        return 'workingHours';
    }

    /**
     * @return array
     */
    protected static function map(): array
    {
        return [
            'id'         => [ 'property' => 'id',         'type' => 'int'    ],
            'profile_id' => [ 'property' => 'profile_id', 'type' => 'int'    ],
            'contact_id' => [ 'property' => 'contact_id', 'type' => 'int'    ],
            'day'        => [ 'property' => 'day',        'type' => 'int'    ],
            'start'      => [ 'property' => 'start',      'type' => 'string' ],
            'end'        => [ 'property' => 'end',        'type' => 'string' ],
            'is_weekend' => [ 'property' => 'is_weekend', 'type' => 'bool',  'default' => false ],
            'is_nonstop' => [ 'property' => 'is_nonstop', 'type' => 'bool',  'default' => false ],
        ];
    }
}
