<?php

namespace App\Models\Dictionaries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class ADictionary extends Model
{
    use HasFactory;

    public $table = 'dictionaries';

    public $timestamps = false;

    public static function all( $columns = [ '*' ] )
    {
        return static::query()->where( 'type', static::TYPE )->get(
            is_array( $columns ) ? $columns : func_get_args()
        );
    }
}
