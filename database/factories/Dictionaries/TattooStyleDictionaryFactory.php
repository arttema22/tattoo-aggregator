<?php

namespace Database\Factories\Dictionaries;

use App\Models\Dictionaries\TattooStyleDictionary;
use Illuminate\Database\Eloquent\Factories\Factory;

class TattooStyleDictionaryFactory extends Factory
{
    protected $model = TattooStyleDictionary::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'type' => TattooStyleDictionary::TYPE,
            'name' => $this->faker->words
        ];
    }
}
