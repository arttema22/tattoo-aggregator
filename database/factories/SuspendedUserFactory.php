<?php

namespace Database\Factories;

use App\Models\SuspendedUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SuspendedUserFactory extends Factory
{
    protected $model = SuspendedUser::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'user_id'    => User::factory(),
            'started_at' => $this->faker->date( 'Y-m-d H:i:s' ),
            'ended_at'   => $this->faker->date( 'Y-m-d H:i:s' ),
            'reason'     => 'ban',
            'status'     => 1
        ];
    }

    /**
     * @return SuspendedUserFactory
     */
    public function unban() : self
    {
        return $this->state( function () {
            return [
                'status' => 2
            ];
        } );
    }

}
