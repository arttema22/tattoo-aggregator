<?php

namespace Database\Factories;

use App\Models\LandingPage;
use App\Models\LandingPageTag;
use Illuminate\Database\Eloquent\Factories\Factory;

class LandingPageTagFactory extends Factory
{
    protected $model = LandingPageTag::class;

    public function definition(): array
    {
        return [
            'landing_page_id' => LandingPage::factory(),
            'name'            => $this->faker->realTextBetween( 15, 30 ),
        ];
    }

    /**
     * @param LandingPage $landing_page
     * @return LandingPageTagFactory
     */
    public function landingPage( LandingPage $landing_page ) : self
    {
        return $this->state( function () use ( $landing_page ) {
            return [
                'landing_page_id' => $landing_page->id
            ];
        } );
    }
}
