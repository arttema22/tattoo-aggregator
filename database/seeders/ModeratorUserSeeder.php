<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class ModeratorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run() : void
    {
        $password = app()->environment() === 'local' ? '12345' : '!HC7*DsAML_B*9B5+U';
        User::factory()
            ->state( [
                'name'     => 'moderator',
                'email'    => 'moderator@example.com',
                'password' => Hash::make( $password ),
            ] )
            ->hasModerator()
            ->create();
    }
}
