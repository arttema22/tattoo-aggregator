<?php

namespace Database\Seeders;

use App\Enums\ContactFilledCriteriaSubtypes;
use App\Enums\ContactFilledCriteriaTypes;
use App\Models\ContactFilledCriteria;
use Illuminate\Database\Seeder;

class ContactFilledCriteriaSeeder extends Seeder
{
    private const CONFIG = [
        [
            'type' => ContactFilledCriteriaTypes::GENERAL,
            'subtype' => ContactFilledCriteriaSubtypes::GENERAL_NAME,
            'value' => null,
            'percent' => 5,
        ],
        [
            'type' => ContactFilledCriteriaTypes::GENERAL,
            'subtype' => ContactFilledCriteriaSubtypes::GENERAL_DESCRIPTION,
            'value' => null,
            'percent' => 5,
        ],
        [
            'type' => ContactFilledCriteriaTypes::GENERAL,
            'subtype' => ContactFilledCriteriaSubtypes::GENERAL_COVER,
            'value' => null,
            'percent' => 5,
        ],
        [
            'type' => ContactFilledCriteriaTypes::SALON,
            'subtype' => ContactFilledCriteriaSubtypes::SALON_ADDRESS,
            'value' => null,
            'percent' => 10,
        ],
        [
            'type' => ContactFilledCriteriaTypes::SALON,
            'subtype' => ContactFilledCriteriaSubtypes::SALON_EMAIL,
            'value' => null,
            'percent' => 5,
        ],
        [
            'type' => ContactFilledCriteriaTypes::SALON,
            'subtype' => ContactFilledCriteriaSubtypes::SALON_PHONE,
            'value' => null,
            'percent' => 10,
        ],
        [
            'type' => ContactFilledCriteriaTypes::SALON,
            'subtype' => ContactFilledCriteriaSubtypes::SALON_COORDINATES,
            'value' => null,
            'percent' => 5,
        ],
        [
            'type' => ContactFilledCriteriaTypes::WORK_GALLERY,
            'subtype' => null,
            'value' => 1,
            'percent' => 10,
        ],
        [
            'type' => ContactFilledCriteriaTypes::WORK_GALLERY,
            'subtype' => null,
            'value' => 5,
            'percent' => 15,
        ],
        [
            'type' => ContactFilledCriteriaTypes::WORK_GALLERY,
            'subtype' => null,
            'value' => 10,
            'percent' => 20,
        ],
        [
            'type' => ContactFilledCriteriaTypes::SERVICE,
            'subtype' => null,
            'value' => 1,
            'percent' => 5,
        ],
        [
            'type' => ContactFilledCriteriaTypes::SERVICE,
            'subtype' => null,
            'value' => 3,
            'percent' => 8,
        ],
        [
            'type' => ContactFilledCriteriaTypes::SERVICE,
            'subtype' => null,
            'value' => 5,
            'percent' => 13,
        ],
        [
            'type' => ContactFilledCriteriaTypes::ADDITIONAL_SERVICE,
            'subtype' => null,
            'value' => 1,
            'percent' => 5,
        ],
        [
            'type' => ContactFilledCriteriaTypes::SOCIAL_NETWORK,
            'subtype' => null,
            'value' => 1,
            'percent' => 5,
        ],
        [
            'type' => ContactFilledCriteriaTypes::SOCIAL_NETWORK,
            'subtype' => null,
            'value' => 2,
            'percent' => 7,
        ],
        [
            'type' => ContactFilledCriteriaTypes::WORKING_HOURS,
            'subtype' => null,
            'value' => null,
            'percent' => 10,
        ],
    ];

    /**
     * @return void
     */
    public function run(): void
    {
        foreach ( self::CONFIG as $criteria ) {
            ContactFilledCriteria::factory()->state( $criteria )->create();
        }
    }
}
