<?php

namespace App\Services;

use App\DTO\Video\VideoDTO;
use App\Enums\ModelsRelations\VideoRelations;
use App\Filters\VideoFilter;
use App\Models\Profile;
use App\Models\Video;
use App\Repositories\VideoRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class VideoService
{
    private VideoRepository $repository;

    /**
     * VideoService constructor.
     * @param VideoRepository $repository
     */
    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param VideoDTO $dto
     * @param Profile $profile
     * @return Video|null
     */
    public function create( VideoDTO $dto, Profile $profile ): ?Video
    {
        $dto->profile_id = $profile->id;
        return $this->repository->store( $dto );
    }

    /**
     * @param int $id
     * @param VideoDTO $dto
     * @return Video|null
     */
    public function update( int $id, VideoDTO $dto ): ?Video
    {
        /** @var Video|null $result */
        $result = $this->repository->update( $id, $dto );
        return $result;
    }

    /**
     * @param VideoDTO $dto
     * @param Profile $profile
     * @return Video|null
     */
    public function updateOrCreate( VideoDTO $dto, Profile $profile ): ?Video
    {
        if ( isset( $dto->id ) ) {
            $id = $dto->id;
            unset( $dto->id );

            return $this->update( $id, $dto );
        }

        return $this->create( $dto, $profile );
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
     * @param VideoFilter $filter
     * @return Collection|LengthAwarePaginator
     */
    public function search( VideoFilter $filter )
    {
        return $this->repository->search( $filter );
    }

    /**
     * @param int $id
     * @return \App\Models\Video|null
     */
    public function getById( int $id ) : ?Video
    {
        return $this->repository->find( $id, [ VideoRelations::CONTACT ] );
    }

    /**
     * @param \Illuminate\Support\Collection $collection_dto
     * @param Profile $profile
     * @return bool
     */
    public function sync( \Illuminate\Support\Collection $collection_dto, Profile $profile ): bool
    {
        $profile_models_id = $profile->videos->pluck( 'id' );
        $dto_models_id = $collection_dto->whereNotNull( 'id' )->pluck( 'id' );
        if ( $dto_models_id->diff( $profile_models_id )->isNotEmpty() ) {
            // если в переданных данных есть идентификаторы модели не относящиеся к переданному контакту,
            // то пришли некорректные данные, и ничего не синхронизируем
            return false;
        }

        // удаляем данные, по которым не пришло идентификаторов
        $profile_models_id
            ->diff( $dto_models_id )
            ->each( fn( $id ) => $this->delete( $id ) );

        $collection_dto->each( fn( $dto ) => $this->updateOrCreate( $dto, $profile ) );
        return true;
    }

    private function getAllVideoIds(): array
    {
        return Cache::remember( 'videoIds', config( 'video.cache_ids_ttl' ), fn () => $this->repository->getAllIds()->all() );
    }

    public function getRelatedVideos( int $video_id, int $profile_id ): Collection
    {
        $videos_on_page = config( 'video.count_on_page' );

        $videoFilter = App::make( VideoFilter::class );
        $videoFilter->setCustomFields( [
            'exceptId' => $video_id,
            'limit' => $videos_on_page,
            'random' => '',
            'profile' => $profile_id
        ] );

        $videos = $this->search( $videoFilter );
        if ( $videos->count() < $videos_on_page ) {
            $ids =
                collect( $this->getAllVideoIds() )
                    ->diff( $videos->pluck( 'id' )->push( $video_id )->all() )
                    ->random( $videos_on_page - $videos->count() )
                    ->all();
            $videoFilter->setCustomFields( [ 'ids' => [ $ids ] ] );

            $videos = $videos->push( ...$this->search( $videoFilter ) );
        }

        return $videos;
    }
}
