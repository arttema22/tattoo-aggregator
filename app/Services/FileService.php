<?php

namespace App\Services;

use App\DTO\File\FileDTO;
use App\Enums\FileSubtypes;
use App\Enums\ModelsRelations\FileRelations;
use App\Events\UploadedImageEvent;
use App\Filters\FileFilter;
use App\Models\Album;
use App\Models\Article;
use App\Models\Contact;
use App\Models\File;
use App\Models\Profile;
use App\Repositories\FileRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Exception\NotWritableException;
use Intervention\Image\Facades\Image;

class FileService
{
    public function __construct(
        private FileRepository $repository,
        private FileFilter $filter,
    ) {}

    /**
     * @param Model $fileable
     * @return bool
     */
    private function isModelFileable( Model $fileable ): bool
    {
        return in_array(
            $fileable->getMorphClass(),
            [
                Profile::class,
                Article::class,
                Album::class,
                Contact::class,
            ]
        );
    }

    /**
     * @param FileDTO $dto
     * @param Model $fileable
     * @return File|null
     */
    public function create( FileDTO $dto, Model $fileable ): ?File
    {
        if ( $this->isModelFileable( $fileable ) === false ) {
            return null;
        }

        $dto->fileable_type = $fileable->getMorphClass();
        $dto->fileable_id   = $fileable->id;

        $file = $this->repository->store( $dto );
        if ( $file !== null ) {
            UploadedImageEvent::dispatch( FileDTO::fromModel( $file ) );
        }

        return $file;
    }

    /**
     * @param int $id
     * @param FileDTO $dto
     * @return Model|null
     */
    public function update( int $id, FileDTO $dto ): ?File
    {
        return $this->repository->update( $id, $dto );
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete( int $id ): bool
    {
        return $this->repository->delete( $id );
    }

    /**
     * @param UploadedFile $uploaded_file
     * @return \Illuminate\Http\File|null
     */
    public function uploadFile( UploadedFile $uploaded_file ): ?\Illuminate\Http\File
    {
        $path = Storage::putFile( config( 'image.original.path' ), $uploaded_file );
        if ( $path === false ) {
            return null;
        }

        return new \Illuminate\Http\File( Storage::path( config( 'image.original.path' ) ) . basename( $path ) );
    }

    /**
     * @param FileDTO $dto
     * @return bool
     */
    public function processOriginalImage( FileDTO $dto ): bool
    {
        /** @var File $file */
        $file = $this->repository->find( $dto->id );
        if ( $file === null ) {
            return false;
        }

        $original_file_path = Storage::path( config( 'image.original.path' ) ) . $file->original;
        if ( !file_exists( $original_file_path ) ) {
            return false;
        }

        $thumbs = [];
        if ( $file->fileable_subtype === FileSubtypes::COMMON ) {
            $thumbs = [
                's' => [
                    'path' => $this->handleImage( $file->original, $original_file_path, config( 'image.thumbs.small' ) )
                ],
                'm' => [
                    'path' => $this->handleImage( $file->original, $original_file_path, config( 'image.thumbs.medium' ) )
                ],
                'b' => [
                    'path' => $this->handleImage( $file->original, $original_file_path, config( 'image.thumbs.big' ) )
                ],
            ];
        } elseif ( $file->fileable_subtype === FileSubtypes::PROFILE_AVATAR ) {
            $thumbs = [
                'a' => [
                    'path' => $this->handleImage( $file->original, $original_file_path, config( 'image.thumbs.avatar' ) )
                ],
            ];
        }

        $update_dto = new FileDTO();
        $update_dto->thumbs = array_filter( $thumbs, static function ( $thumb ) {
            return !empty( $thumb['path'] );
        } );

        if ( empty( $update_dto->thumbs ) ) {
            return false;
        }

        return $this->update( $file->id, $update_dto ) !== null;
    }

    public function getByAlbumAndId( int $album_id, int $file_id ) : ?File
    {
        $this->filter->setCustomFields( [
            'id' => $file_id,
            'albumId' => $album_id
        ] );

        return $this->repository->first(
            $this->filter,
            [
                FileRelations::FILE_INFO,
                FileRelations::ALBUM,
            ]
        );
    }

    /**
     * @param string $file_name
     * @param string $original_file_path
     * @param array $config
     * @return string
     */
    private function handleImage( string $file_name, string $original_file_path, array $config ): string
    {
        $thumbnail = Image::make( $original_file_path );

        if ( $thumbnail->width() < $config['width'] || $thumbnail->height() < $config['height'] ) {
            $thumbnail->resizeCanvas( $config['width'], $config['height'] );
        }

        $thumbnail->fit( $config['width'], $config['height'], function ($constraint) {
            $constraint->upsize();
        } );

        try {
            $storage_path = Storage::path( $config['path'] );
            if ( !is_dir( $storage_path ) && !mkdir( $storage_path, '0755', true ) && !is_dir( $storage_path ) ) {
                return '';
            }

            $thumbnail->save( $storage_path . $file_name, null, 'webp' );
            return $config['path'] . $thumbnail->basename;
        }
        catch ( NotWritableException $exception ) {
            return '';
        }
    }
}
