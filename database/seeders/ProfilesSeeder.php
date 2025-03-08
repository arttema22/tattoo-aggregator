<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run() : void
    {
        $users = User::where( 'role', 3 )->get();

        $users->each( function ( User $user ) {
            /** @var Profile $profile */
            $profile = Profile::factory()
                ->user( $user )
                ->create();

            /** @var File $file */
            $file = File::factory()
                ->image( 1920, 200, 'cover' )
                ->user( $user )
                ->make();

            $file->fileable()->associate( $profile )->save();
        } );
    }
}
