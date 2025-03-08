<?php

namespace Database\Factories\Dictionaries;

use App\Models\Dictionaries\TattooSizeDictionary;
use Illuminate\Database\Eloquent\Factories\Factory;

class TattooSizeDictionaryFactory extends Factory
{
    protected $model = TattooSizeDictionary::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'type' => TattooSizeDictionary::TYPE,
            'name' => $this->faker->words
        ];
    }
}
