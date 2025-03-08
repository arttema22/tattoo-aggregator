<?php

namespace App\DTO\File;

use App\DTO\BaseDTO;
use App\Models\File;
use Illuminate\Support\Facades\Auth;

/**
 * @property int $id
 * @property int $user_id
 * @property string $fileable_type
 * @property int $fileable_id
 * @property int $fileable_subtype
 * @property string $original
 * @property array $thumbs
 * @property int $size
 * @property string $mime_type
 *
 * Class ProfileDTO
 */
class FileDTO extends BaseDTO
{
    /**
     * @return array
     */
    protected static function map(): array
    {
        return [
            'id'               => [ 'property' => 'id',               'type' => 'int' ],
            'user_id'          => [ 'property' => 'user_id',          'type' => 'int' ],
            'original'         => [ 'property' => 'original',         'type' => 'string' ],
            'fileable_id'      => [ 'property' => 'fileable_id',      'type' => 'int' ],
            'fileable_type'    => [ 'property' => 'fileable_type',    'type' => 'string' ],
            'fileable_subtype' => [ 'property' => 'fileable_subtype', 'type' => 'int' ],
            'thumbs'           => [ 'property' => 'thumbs',           'type' => 'array' ],
            'size'             => [ 'property' => 'size',             'type' => 'int' ],
            'mime_type'        => [ 'property' => 'mime_type',        'type' => 'string' ],
        ];
    }

    /**
     * @param File $file
     * @return FileDTO
     */
    public static function fromModel( File $file ): FileDTO
    {
        return parent::fromArray( $file->toArray() );
    }

    /**
     * @param \Illuminate\Http\File $uploaded_file
     * @param int $file_subtype
     * @return FileDTO
     */
    public static function fromFile( \Illuminate\Http\File $uploaded_file, int $file_subtype = 0 ): FileDTO
    {
        $dto = new self();
        $dto->original         = $uploaded_file->getBasename();
        $dto->fileable_subtype = $file_subtype;
        $dto->size             = $uploaded_file->getSize();
        $dto->mime_type        = $uploaded_file->getMimeType();
        $dto->user_id          = Auth::id();

        return $dto;
    }
}