<?php

namespace App\Services;

use App\DTO\Album\AlbumDTO;
use App\Enums\ModelsRelations\AlbumRelations;
use App\Enums\ModelsRelations\FileRelations;
use App\Enums\WorkApproved;
use App\Filters\AlbumFilter;
use App\Helpers\SpecialisationTypeHelper;
use App\Models\Album;
use App\Models\Contact;
use App\Repositories\AlbumRepository;
use Illuminate\Support\Facades\App;

class AlbumService
{
    private AlbumRepository $repository;

    /**
     * AlbumService constructor.
     * @param AlbumRepository $repository
     */
    public function __construct(AlbumRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param AlbumDTO $dto
     * @param Contact $contact
     * @return Album|null
     */
    public function create( AlbumDTO $dto, Contact $contact ): ?Album
    {
        $dto->contact_id = $contact->id;
        return $this->repository->store( $dto );
    }

    /**
     * @param int $id
     * @param AlbumDTO $dto
     * @return Album|null
     */
    public function update( int $id, AlbumDTO $dto ): ?Album
    {
        return $this->repository->update( $id, $dto );
    }

    /**
     * @param AlbumDTO $dto
     * @param Contact $contact
     * @return Album|null
     */
    public function updateOrCreate( AlbumDTO $dto, Contact $contact ): ?Album
    {
        if ( isset( $dto->id ) ) {
            $id = $dto->id;
            unset( $dto->id );

            return $this->update( $id, $dto );
        }

        return $this->create( $dto, $contact );
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete( int $id ): bool
    {
        return $this->repository->delete( $id );
    }

    public function search( AlbumFilter $filter )
    {
        return $this->repository->search( $filter );
    }

    public function searchWithFiles( AlbumFilter $filter, bool $only_approved = false )
    {
        return $this->repository->search( $filter, [
            AlbumRelations::FILES => fn ( $query ) => $query->whereHas(
                FileRelations::FILE_INFO,
                fn ( $query ) => $query->when(
                    $only_approved,
                    fn ( $query ) => $query->where( 'is_approved', '=', WorkApproved::APPROVE )
                )
            ),
            AlbumRelations::FILES_AND_FILE_INFO,
        ] );
    }

    /**
     * @param Contact $contact
     * @return bool
     */
    public function createAlbumsForContact( Contact $contact ): bool
    {
        $result = true;

        /** @var AlbumDTO $dto */
        $dto = App::make( AlbumDTO::class );
        foreach ( SpecialisationTypeHelper::getForAlbums() as $type => $name ) {
            $dto->type        = $type;
            $dto->name        = $name;
            $dto->description = $name;

            if ( $this->create( $dto, $contact ) === false ) {
                $result = false;
            }
        }

        return $result;
    }
}
