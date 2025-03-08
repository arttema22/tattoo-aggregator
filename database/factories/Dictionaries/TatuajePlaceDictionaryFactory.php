<?php

namespace Database\Factories\Dictionaries;

use App\Models\Dictionaries\TatuajePlaceDictionary;
use Illuminate\Database\Eloquent\Factories\Factory;

class TatuajePlaceDictionaryFactory extends Factory
{
    protected $model = TatuajePlaceDictionary::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'type' => TatuajePlaceDictionary::TYPE,
            'name' => $this->faker->words
        ];
    }
}
