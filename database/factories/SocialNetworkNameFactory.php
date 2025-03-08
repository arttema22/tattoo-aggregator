<?php

namespace Database\Factories;

use App\Models\SocialNetworkName;
use Illuminate\Database\Eloquent\Factories\Factory;

class SocialNetworkNameFactory extends Factory
{
    protected $model = SocialNetworkName::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'name'  => $this->faker->company,
            'alias' => $this->faker->unique->regexify( '/[a-z]{10}/' ),
            'url'   => $this->faker->url,
        ];
    }
}
