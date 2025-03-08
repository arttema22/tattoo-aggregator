<?php

namespace Database\Factories\Dictionaries;

use App\Models\Dictionaries\TattooPlaceDictionary;
use Illuminate\Database\Eloquent\Factories\Factory;

class TattooPlaceDictionaryFactory extends Factory
{
    protected $model = TattooPlaceDictionary::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'type' => TattooPlaceDictionary::TYPE,
            'name' => $this->faker->words
        ];
    }
}
