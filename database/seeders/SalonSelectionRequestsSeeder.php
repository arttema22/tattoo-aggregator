<?php

namespace Database\Seeders;

use App\Enums\SpecializationTypes;
use App\Models\City;
use App\Models\LandingPage;
use App\Models\SalonSelectionRequest;
use Illuminate\Database\Seeder;

class SalonSelectionRequestsSeeder extends Seeder
{
    public function run(): void
    {
        $cities        = City::where( 'country_id', 1 )->get();
        $landing_pages = LandingPage::get();

        $landing_pages->each( function ( $landing_page ) use ( $cities ) {
            $type = random_int( 1, 15 );
            $types = [];
            if ( $type & SpecializationTypes::TATTOO ) {
                $types[] = SpecializationTypes::TATTOO;
            }

            if ( $type & SpecializationTypes::TATUAJE ) {
                $types[] = SpecializationTypes::TATUAJE;
            }

            if ( $type & SpecializationTypes::PIERCING ) {
                $types[] = SpecializationTypes::PIERCING;
            }

            SalonSelectionRequest::factory()
                ->landingPage( $landing_page )
                ->city( $cities->random() )
                ->types( $types )
                ->create();
        } );
    }
}
