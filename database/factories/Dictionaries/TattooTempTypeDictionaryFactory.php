<?php

namespace Database\Factories\Dictionaries;

use App\Models\Dictionaries\TattooTempTypeDictionary;
use Illuminate\Database\Eloquent\Factories\Factory;

class TattooTempTypeDictionaryFactory extends Factory
{
    protected $model = TattooTempTypeDictionary::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'type' => TattooTempTypeDictionary::TYPE,
            'name' => $this->faker->words
        ];
    }
}
