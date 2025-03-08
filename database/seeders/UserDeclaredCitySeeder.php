<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\UserDeclaredCity;
use Illuminate\Database\Seeder;

class UserDeclaredCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     * @throws \Exception
     */
    public function run() : void
    {
        Profile::all()->random( random_int( 2, 5 ) )->each( function ( Profile $profile ) {
            UserDeclaredCity::factory()
                ->user( $profile->user )
                ->count( random_int( 1, 3 ) )
                ->create();
        } );
    }
}
