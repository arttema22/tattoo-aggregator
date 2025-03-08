<?php

namespace App\Jobs;

use App\DTO\Video\VideoDTO;
use App\Models\Video;
use App\Services\VideoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class GetInfoVideoJob implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * @return void
     */
    public function __construct(
        private int $video_id
    ) {}

    /**
     * @return void
     */
    public function handle(
        VideoService $video_service
    )
    {
        $video = $video_service->getById( $this->video_id );
        logger( 'video', $video->toArray() );
        if ( $video === null ) {
            return;
        }

        $video_hosting = $this->getVideoHosting( $video->url );
        logger( 'hosting', [ $video_hosting ] );
        if ( $video_hosting === null ) {
            return;
        }

        $info = $this->getInfo( $video_hosting, $video->url );
        logger( 'preview', [ $info[ 'preview' ] ?? 'n/a' ] );
        if ( $info === null ) {
            return;
        }

        $this->save( $video_service, $video, $info );
    }

    /**
     * @param string $url
     * @return string|null
     */
    protected function getVideoHosting( string $url ) : ?string
    {
        $host = parse_url( $url, PHP_URL_HOST );
        $host = str_replace( 'www.', '', $host );

        return match ( $host ) {
            'youtube.com',
            'youtu.be' => 'YOUTUBE',

            'rutube.ru' => 'RUTUBE',

            default => null
        };
    }

    /**
     * @param string $video_hosting
     * @param string $url
     * @return string|null
     */
    protected function getVideoHashId( string $video_hosting, string $url ) : ?string
    {
        $parts = parse_url( $url );
        parse_str( $parts[ 'query' ] ?? '', $query );

        if ( $video_hosting === 'YOUTUBE' ) {
            return $query[ 'v' ] ?? trim( $parts[ 'path' ], '/' );
        }

        if ( $video_hosting === 'RUTUBE' ) {
            return preg_match( '/[\/]{1}([0-9a-f]+)[\/]*/', $parts[ 'path' ], $match )
                ? $match[ 1 ]
                : null;
        }

        return null;
    }

    /**
     * @param string $video_hosting
     * @param string $url
     * @return array|null
     */
    protected function getInfo( string $video_hosting, string $url ) : ?array
    {
        return match ( $video_hosting ) {
            'YOUTUBE' => $this->getYoutubeInfo( $url ),
            'RUTUBE'  => $this->getRutubeInfo( $url ),

            default   => null,
        };
    }

    /**
     * @param string $url
     * @return array|null
     */
    protected function getYoutubeInfo( string $url ) : ?array
    {
        $response = Http::get( sprintf( 'https://www.youtube.com/oembed?url=%s&format=json', $url ) );
        if ( $response->ok() ) {
            return [
                'name'    => $response->json( 'title' ),
                'preview' => $response->json( 'thumbnail_url' ),
                'html'    => $response->json( 'html' ),
                'meta'    => $response->json(),
            ];
        }

        return null;
    }

    /**
     * @param string $url
     * @return array|null
     */
    protected function getRutubeInfo( string $url ) : ?array
    {
        $video_id = $this->getVideoHashId( 'RUTUBE', $url );
        if ( $video_id === null ) {
            return null;
        }

        $response = Http::get( sprintf( 'https://rutube.ru/api/video/%s/?format=json', $video_id ) );
        if ( $response->ok() ) {
            return [
                'name'    => $response->json( 'title' ),
                'preview' => $response->json( 'thumbnail_url' ),
                'html'    => $response->json( 'html' ),
                'meta'    => $response->json(),
            ];
        }

        return null;
    }

    /**
     * @param \App\Services\VideoService $service
     * @param \App\Models\Video $video
     * @param array $info
     * @return void
     */
    protected function save( VideoService $service, Video $video, array $info ) : void
    {
        $dto = new VideoDTO();
        $dto->name    = $info[ 'name' ];
        $dto->preview = $info[ 'preview' ];
        $dto->html    = preg_replace( [ '/width="\d+"/', '/height="\d+"/' ], [ 'width="{%width%}"', 'height="{%height%}"' ], $info[ 'html' ] );
        $dto->meta    = $info[ 'meta' ];
        $service->update( $video->id, $dto );
    }
}
