<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     * @throws \Exception
     */
    public function run() : void
    {
        Profile::all()->each( function ( Profile $profile ) {
            Service::factory()
                ->profile( $profile )
                ->count( random_int( 5, 30 ) )
                ->create();
        } );
    }
}
