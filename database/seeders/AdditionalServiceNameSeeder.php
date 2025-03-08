<?php

namespace Database\Seeders;

use App\Models\AdditionalServiceName;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AdditionalServiceNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run() : void
    {
        File::lines( __DIR__ . '/../data/additional_service/additional_service.txt' )->each( function ( $item ) {
            if ( $item === '' ) {
                return;
            }

            AdditionalServiceName::factory()
                ->state( [
                    'name' => $item
                ] )
                ->create();
        } );
    }
}
