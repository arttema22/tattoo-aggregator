<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\SocialNetwork;
use App\Models\SocialNetworkName;
use Illuminate\Database\Seeder;

class SocialNetworksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     * @throws \Exception
     */
    public function run() : void
    {
        $profiles = Profile::all();
        $social_networks = SocialNetworkName::all();

        $profiles->each( function ( Profile $profile ) use ( $social_networks ) {
            $social_networks_arr = $social_networks->random( random_int( 1, 5 ) );
            $social_networks_arr->each( function ( SocialNetworkName $name ) use ( $profile ) {
                SocialNetwork::factory()
                    ->profile( $profile )
                    ->socialNetwork( $name )
                    ->create();
            } );
        } );
    }
}
