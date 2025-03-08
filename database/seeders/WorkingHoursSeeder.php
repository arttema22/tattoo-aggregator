<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\WorkingHours;
use Illuminate\Database\Seeder;

class WorkingHoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run() : void
    {
        Profile::all()->each( function ( Profile $profile ) {
            $days = range( 1, 7 );
            foreach ( $days as $day ) {
                WorkingHours::factory()
                    ->profile( $profile )
                    ->day( $day )
                    ->create();
            }
        } );
    }
}
