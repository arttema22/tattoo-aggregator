<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    public function run() : void
    {
        $contacts = Contact::all();

        foreach ( $contacts as $contact ) {
            if ( random_int( 0, 10 ) > 9 ) {
                continue;
            }

            Review::factory()
                ->contact( $contact )
                ->count( random_int( 1, 30 ) )
                ->create();
        }
    }
}
