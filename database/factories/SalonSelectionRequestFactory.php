<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\LandingPage;
use App\Models\SalonSelectionRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalonSelectionRequestFactory extends Factory
{
    protected $model = SalonSelectionRequest::class;

    public function definition(): array
    {
        return [
            'types'           => [],
            'city_id'         => City::factory(),
            'phone'           => $this->faker->phoneNumber,
            'description'     => $this->faker->realTextBetween( 20, 250 ),
            'is_mail_sent'    => true,
            'landing_page_id' => LandingPage::factory(),
        ];
    }

    /**
     * @param City $city
     * @return SalonSelectionRequestFactory
     */
    public function city( City $city ) : self
    {
        return $this->state( fn () => [
            'city_id' => $city->id
        ] );
    }

    /**
     * @param LandingPage $landing_page
     * @return SalonSelectionRequestFactory
     */
    public function landingPage( LandingPage $landing_page ) : self
    {
        return $this->state( fn () => [
            'landing_page_id' => $landing_page->id
        ] );
    }

    /**
     * @param array $types
     * @return SalonSelectionRequestFactory
     */
    public function types( array $types ): self
    {
        return $this->state( fn () => [
            'types' => $types
        ] );
    }
}
