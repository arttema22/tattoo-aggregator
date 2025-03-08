<?php

namespace Database\Factories;

use App\Models\AdditionalServiceName;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdditionalServiceNameFactory extends Factory
{
    protected $model = AdditionalServiceName::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'name' => $this->faker->words
        ];
    }
}
