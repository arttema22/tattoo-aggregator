<?php

namespace Database\Factories;

use App\Enums\ContactFilledCriteriaTypes;
use App\Models\ContactFilledCriteria;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFilledCriteriaFactory extends Factory
{
    protected $model = ContactFilledCriteria::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement( [
                ContactFilledCriteriaTypes::GENERAL,
                ContactFilledCriteriaTypes::SALON,
                ContactFilledCriteriaTypes::WORK_GALLERY,
                ContactFilledCriteriaTypes::SERVICE,
                ContactFilledCriteriaTypes::ADDITIONAL_SERVICE,
                ContactFilledCriteriaTypes::SOCIAL_NETWORK,
                ContactFilledCriteriaTypes::WORKING_HOURS,
            ] ),
            'subtype' => null,
            'value' => $this->faker->randomNumber( 2 ),
            'percent' => $this->faker->randomNumber( 1 )
        ];
    }
}
