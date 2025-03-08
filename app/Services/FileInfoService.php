<?php

namespace App\Services;

use App\DTO\FileInfo\FileInfoDTO;
use App\Enums\ModelsRelations\AlbumRelations;
use App\Enums\ModelsRelations\FileInfoRelations;
use App\Filters\FileInfoFilter;
use App\Models\Album;
use App\Models\File;
use App\Models\FileInfo;
use App\Repositories\FileInfoRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Pagination\LengthAwarePaginator;

class FileInfoService
{
    private FileInfoRepository $repository;

    /**
     * FileInfoService constructor.
     * @param FileInfoRepository $repository
     */
    public function __construct(FileInfoRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * @param FileInfoDTO $dto
     * @param File $file
     * @return FileInfo|null
     */
    public function create( FileInfoDTO $dto, File $file ): ?FileInfo
    {
        $dto->file_id = $file->id;

        return $this->repository->store( $dto );
    }

    /**
     * @param int $id
     * @param FileInfoDTO $dto
     * @return FileInfo|null
     */
    public function update( int $id, FileInfoDTO $dto ): ?FileInfo
    {
        return $this->repository->update( $id, $dto );
    }

    /**
     * @param FileInfoDTO $dto
     * @param File $file
     * @return FileInfo|null
     */
    public function updateOrCreate( FileInfoDTO $dto, File $file ): ?FileInfo
    {
        if ( isset( $dto->id ) ) {
            $id = $dto->id;
            unset( $dto->id );

            return $this->update( $id, $dto );
        }

        return $this->create( $dto, $file );
    }

    /**
     * @param FileInfoFilter $filter
     * @param int $paginate
     * @return Collection|LengthAwarePaginator
     */
    public function search( FileInfoFilter $filter, int $paginate = 0 )
    {
        return $this->repository->search(
            $filter,
            [
                FileInfoRelations::FILE
            ],
            $paginate );
    }

    /**
     * @param FileInfoFilter $filter
     * @param int $paginate
     * @return Collection|LengthAwarePaginator
     */
    public function searchForCatalog( FileInfoFilter $filter, int $paginate = 0 )
    {
        $result = FileInfo::with( [
            FileInfoRelations::FILE,
            FileInfoRelations::FILE_AND_FILEABLE => function( MorphTo $morphTo ) {
                $morphTo->morphWith( [
                    Album::class => [
                        AlbumRelations::CONTACT_AND_CITY,
                        AlbumRelations::CONTACT_AND_PROFILE
                    ]
                ] );
            }
        ] )->filter( $filter );
        if ( $paginate !== 0 ) {
            return $result->paginate( $paginate );
        }

        return $result->get();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete( int $id ): bool
    {
        return $this->repository->delete( $id );
    }
}