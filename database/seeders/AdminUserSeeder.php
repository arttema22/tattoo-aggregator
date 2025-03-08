<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run() : void
    {
        $password = app()->environment() === 'local' ? '12345' : 'KF7E$QUFYEf,Qzg;_%';
        User::factory()
            ->state( [
                'name'     => 'admin',
                'email'    => 'admin@example.com',
                'password' => Hash::make( $password ),
            ] )
            ->hasAdmin()
            ->create();
    }
}
