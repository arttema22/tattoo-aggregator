<?php

namespace Database\Seeders;

use App\Models\SocialNetworkName;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SocialNetworkNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run() : void
    {
        $raw  = File::get( __DIR__ . '/../data/social_networks/social_networks.json' );
        $json = json_decode( $raw, true );

        foreach ( $json as $item ) {
            SocialNetworkName::factory()
                ->state( [
                    'name'  => $item[ 'name' ],
                    'alias' => $item[ 'alias' ],
                    'url'   => $item[ 'url' ]
                ] )
                ->create();
        }
    }
}
