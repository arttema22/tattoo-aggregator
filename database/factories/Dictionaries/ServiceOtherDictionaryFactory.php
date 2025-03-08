<?php

namespace Database\Factories\Dictionaries;

use App\Models\Dictionaries\ServiceOtherDictionary;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceOtherDictionaryFactory extends Factory
{
    protected $model = ServiceOtherDictionary::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'type' => ServiceOtherDictionary::TYPE,
            'name' => $this->faker->words
        ];
    }
}
