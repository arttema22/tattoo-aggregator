<?php

namespace Database\Factories\Dictionaries;

use App\Models\Dictionaries\PiercingPlaceDictionary;
use Illuminate\Database\Eloquent\Factories\Factory;

class PiercingPlaceDictionaryFactory extends Factory
{
    protected $model = PiercingPlaceDictionary::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'type' => PiercingPlaceDictionary::TYPE,
            'name' => $this->faker->words
        ];
    }
}
