<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'profile_id' => Profile::factory(),
            'url'        => $this->faker->url
        ];
    }

    /**
     * @param Profile $profile
     * @return VideoFactory
     */
    public function profile( Profile $profile ) : self
    {
        return $this->state( function () use ( $profile ) {
            return [
                'profile_id' => $profile->id
            ];
        } );
    }
}
