<?php

namespace Database\Factories\Dictionaries;

use App\Models\Dictionaries\ServiceTattooDictionary;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceTattooDictionaryFactory extends Factory
{
    protected $model = ServiceTattooDictionary::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'type' => ServiceTattooDictionary::TYPE,
            'name' => $this->faker->words
        ];
    }
}
