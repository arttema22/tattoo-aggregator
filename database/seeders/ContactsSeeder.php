<?php

namespace Database\Seeders;

use App\Enums\ProfileTypes;
use App\Models\City;
use App\Models\Contact;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     * @throws \Exception
     */
    public function run() : void
    {
        $masters = Profile::where( 'type', ProfileTypes::MASTER )->get();
        $salons  = Profile::where( 'type', ProfileTypes::SALON )->get();
        $cities  = City::with( 'metro', 'country' )->where( 'country_id', 1 )->get();

        $masters->each( function ( Profile $item ) use ( $cities ) {
            /** @var City $current_geo */
            $current_geo = $cities->random();
            Contact::factory()
                ->profile( $item )
                ->country( $current_geo->country )
                ->city( $current_geo )
                ->metro( $current_geo->has_metro === 1 ? $current_geo->metro->random() : null )
                ->create();
        } );

        $salons->each( function ( Profile $item ) use ( $cities ) {
            /** @var City $current_geo */
            $current_geo = $cities->random();
            Contact::factory()
                ->profile( $item )
                ->country( $current_geo[ 'country' ] )
                ->city( $current_geo )
                ->metro( $current_geo->has_metro === 1 ? $current_geo->metro->random() : null  )
                ->count( random_int( 1, 3 ) )
                ->create();
        } );
    }
}
