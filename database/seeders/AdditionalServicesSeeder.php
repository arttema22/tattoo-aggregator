<?php

namespace Database\Seeders;

use App\Models\AdditionalService;
use App\Models\AdditionalServiceName;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class AdditionalServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     * @throws \Exception
     */
    public function run() : void
    {
        $profiles = Profile::all();
        $additional_service_names = AdditionalServiceName::all();

        $profiles->each( function ( Profile $profile ) use ( $additional_service_names ) {
            $additional_service_names
                ->random( random_int( 1, $additional_service_names->count() - 1 ) )
                ->each( function ( AdditionalServiceName $item ) use ( $profile ) {
                    AdditionalService::factory()
                        ->withoutContact()
                        ->profile( $profile )
                        ->service( $item )
                        ->create();
                } );
        } );
    }
}
