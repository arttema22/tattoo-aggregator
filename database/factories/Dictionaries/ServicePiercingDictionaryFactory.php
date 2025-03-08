<?php

namespace Database\Factories\Dictionaries;

use App\Models\Dictionaries\ServicePiercingDictionary;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServicePiercingDictionaryFactory extends Factory
{
    protected $model = ServicePiercingDictionary::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'type' => ServicePiercingDictionary::TYPE,
            'name' => $this->faker->words
        ];
    }
}
