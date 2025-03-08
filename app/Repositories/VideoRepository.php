<?php

namespace App\Repositories;

use App\DTO\Video\VideoDTO;
use App\Models\Video;
use Illuminate\Support\Collection;

class VideoRepository
{
    use HasSearch, HasUpdate, HasDelete;

    protected static function model(): string
    {
        return Video::class;
    }

    /**
     * @param VideoDTO $dto
     * @return Video|null
     */
    public function store( VideoDTO $dto ): ?Video
    {
        $video = new Video();
        $video->profile_id = $dto->profile_id;
        $video->url        = $dto->url;
        $video->name       = $dto->name;
        $video->text       = $dto->text;
        $video->meta       = $dto->meta;

        if ( property_exists( $dto, 'contact_id' ) ) {
            $video->contact_id = $dto->contact_id;
        }

        return $video->save() ? $video : null;
    }

    /**
     * @param int $profile_id
     * @return bool
     */
    public function deleteByProfileId( int $profile_id ): bool
    {
        return (bool)Video::whereProfileId( $profile_id )->delete();
    }

    public function getAllIds(): Collection
    {
        return Video::get('id')->pluck('id');
    }
}
