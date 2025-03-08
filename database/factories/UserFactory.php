<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'name'              => $this->faker->name(),
            'role'              => 3,
            'email'             => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => Hash::make( 'password' )
        ];
    }

    /**
     * @return \Database\Factories\UserFactory
     */
    public function unverified() : self
    {
        return $this->state( function () {
            return [
                'email_verified_at' => null,
            ];
        } );
    }

    /**
     * @return \Database\Factories\UserFactory
     */
    public function hasAdmin() : self
    {
        return $this->state( function () {
            return [
                'role' => 1,
            ];
        } );
    }

    /**
     * @return \Database\Factories\UserFactory
     */
    public function hasModerator() : self
    {
        return $this->state( function () {
            return [
                'role' => 2,
            ];
        } );
    }
}
