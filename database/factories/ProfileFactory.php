<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'user_id'     => User::factory(),
            'type'        => $this->faker->numberBetween( 1, 2 ),
            'name'        => $this->faker->name,
            'description' => $this->faker->text(),
        ];
    }

    /**
     * @param User $user
     * @return ProfileFactory
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
