<?php

namespace Database\Factories\Dictionaries;

use App\Models\Dictionaries\GenderDictionary;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenderDictionaryFactory extends Factory
{
    protected $model = GenderDictionary::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'type' => GenderDictionary::TYPE,
            'name' => $this->faker->word
        ];
    }
}
