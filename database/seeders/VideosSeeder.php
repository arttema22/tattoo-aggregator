<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Profile;
use App\Models\Video;
use Illuminate\Database\Seeder;

class VideosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     * @throws \Exception
     */
    public function run() : void
    {
        $videos = collect([
            'https://www.youtube.com/watch?v=dZRqB0JLizw',
            'https://www.youtube.com/watch?v=6TJwFWVjOJU',
            'https://www.youtube.com/watch?v=TWTfhyvzTx0',
            'https://www.youtube.com/watch?v=to2SMng4u1k',
            'https://www.youtube.com/watch?v=giXco2jaZ_4',
            'https://www.youtube.com/watch?v=fb5ELWi-ekk',
        ]);

        Profile::all()->each( function ( Profile $profile ) use ( $videos ) {
            $videos->random( random_int( 0, $videos->count() - 1 ) )->each( function ( $v ) use ( $profile ) {
                $video = Video::factory()
                    ->profile( $profile )
                    ->state( [
                        'url' => $v
                    ] )
                    ->create();

                /** @var File $file */
                $file = File::factory()
                    ->user( $profile->user )
                    ->image( 480, 360, 'video' )
                    ->make();

                $file->fileable()->associate( $video )->save();
            } );
        } );
    }
}
