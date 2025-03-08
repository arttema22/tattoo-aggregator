<?php

namespace Database\Factories\Dictionaries;

use App\Models\Dictionaries\PiercingPainLevelDictionary;
use Illuminate\Database\Eloquent\Factories\Factory;

class PiercingPainLevelDictionaryFactory extends Factory
{
    protected $model = PiercingPainLevelDictionary::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'type' => PiercingPainLevelDictionary::TYPE,
            'name' => $this->faker->word
        ];
    }
}
