<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Contact;
use App\Models\File;
use Illuminate\Database\Seeder;

class AlbumsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     * @throws \Exception
     */
    public function run() : void
    {
        $albums = [
            \App\Enums\SpecializationTypes::TATTOO   => 'Tattoo',
            \App\Enums\SpecializationTypes::TATUAJE  => 'Tatuaje',
            \App\Enums\SpecializationTypes::PIERCING => 'Piercing',
            \App\Enums\SpecializationTypes::OTHER    => 'Other',
        ];

        $contacts = Contact::with( \App\Enums\ModelsRelations\ContactRelations::SPECIALIZATION )->get();
        $contacts->each( function ( Contact $contact ) use ( $albums ) {
            foreach ( $albums as $type => $name ) {
                if ( $contact->specialization->type & $type === 0 ) {
                    continue;
                }

                $album = Album::factory()
                    ->state( [
                        'name' => $name,
                        'type' => $type,
                    ] )
                    ->for( $contact )
                    ->create();

                $files = File::factory()
                    ->user( $contact->profile->user )
                    ->image( 640, 480, 'album ' . $name )
                    ->count( random_int( 1, 15 ) )
                    ->make();

                $files->each( function ( File $file ) use ( $album ) {
                    $file->fileable()->associate( $album )->save();
                } );
            }
        } );
    }
}
