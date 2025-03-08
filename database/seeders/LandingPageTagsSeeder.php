<?php

namespace Database\Seeders;

use App\Models\LandingPage;
use App\Models\LandingPageTag;
use Illuminate\Database\Seeder;

class LandingPageTagsSeeder extends Seeder
{
    public function run(): void
    {
        LandingPage::get()->each( fn ( $landing_page ) =>
            LandingPageTag::factory()
                ->landingPage( $landing_page )
                ->create()
        );
    }
}
