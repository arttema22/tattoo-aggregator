<?php

namespace Database\Factories\Dictionaries;

use App\Models\Dictionaries\ServiceTatuajeDictionary;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceTatuajeDictionaryFactory extends Factory
{
    protected $model = ServiceTatuajeDictionary::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'type' => ServiceTatuajeDictionary::TYPE,
            'name' => $this->faker->words
        ];
    }
}
