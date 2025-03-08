<?php

namespace Database\Seeders;

use App\Enums\ModelsRelations\ContactRelations;
use App\Helpers\SpecialisationTypeHelper;
use App\Models\Album;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactMissingAlbumsSeeder extends Seeder
{
    /**
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $albums = SpecialisationTypeHelper::getForAlbums();

        $contacts = Contact::with( ContactRelations::ALBUMS )->get();
        $contacts->each( function ( Contact $contact ) use ( $albums ) {
            foreach ( $albums as $type => $name ) {
                if ( $contact->albums->where( 'type', $type )->isNotEmpty() ) {
                    continue;
                }

                Album::factory()
                    ->state( [
                        'type'        => $type,
                        'name'        => $name,
                        'description' => $name,
                    ] )
                    ->for( $contact )
                    ->create();
            }
        } );
    }
}
