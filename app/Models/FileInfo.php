<?php

namespace App\Models;

use App\Filters\FileInfoFilter;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\FileInfo
 *
 * @property int $id
 * @property int $file_id
 * @property string $name
 * @property string $description
 * @property array $attribute
 * @property int $is_downloadable
 * @property int $is_adult
 * @property int $is_approved
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\File|null $file
 * @method static \Database\Factories\FileInfoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereAttribute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereIsAdult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereIsDownloadable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FileInfo extends Model
{
    use HasFactory, Filterable;

    protected $table = 'file_info';

    protected $fillable = [
        'name',
        'description',
        'attribute',
        'is_downloadable',
        'is_adult',
        'is_approved',
    ];

    protected $hidden = [
        'file_id'
    ];

    protected $casts = [
        'attribute' => 'array'
    ];

    public function file(): BelongsTo
    {
        return $this->belongsTo( File::class );
    }
}
