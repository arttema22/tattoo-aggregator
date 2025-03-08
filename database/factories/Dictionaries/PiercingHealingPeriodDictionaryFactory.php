<?php

namespace Database\Factories\Dictionaries;

use App\Models\Dictionaries\PiercingHealingPeriodDictionary;
use Illuminate\Database\Eloquent\Factories\Factory;

class PiercingHealingPeriodDictionaryFactory extends Factory
{
    protected $model = PiercingHealingPeriodDictionary::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'type' => PiercingHealingPeriodDictionary::TYPE,
            'name' => $this->faker->words
        ];
    }
}
