<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserDeclaredCity;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDeclaredCityFactory extends Factory
{
    protected $model = UserDeclaredCity::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'user_id' => User::factory(),
            'name'    => $this->faker->city,
            'status'  => 1
        ];
    }

    /**
     * @return UserDeclaredCityFactory
     */
    public function hasApproved() : self
    {
        return $this->state( function () {
            return [
                'status' => 2
            ];
        } );
    }

    /**
     * @return UserDeclaredCityFactory
     */
    public function hasRejected() : self
    {
        return $this->state( function () {
            return [
                'status' => 3
            ];
        } );
    }

    /**
     * @param User $user
     * @return UserDeclaredCityFactory
     */
    public function user( User $user ) : self
    {
        return $this->state( function () use ( $user ) {
            return [
                'user_id' => $user->id
            ];
        } );
    }
}
