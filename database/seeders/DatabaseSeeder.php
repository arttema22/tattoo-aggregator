<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @return void
     */
    public function run() : void
    {
        $seeder_list = [
            AdminUserSeeder::class,
            ModeratorUserSeeder::class,
            DictionarySeeder::class,
            AdditionalServiceNameSeeder::class,
            SocialNetworkNameSeeder::class,
            GeoSeeder::class,
            CategoriesSeeder::class,
            ContactFilledCriteriaSeeder::class,
        ];

        if ( app()->environment() === 'local' ) {
            $seeder_list[] = UsersSeeder::class;
            $seeder_list[] = ProfilesSeeder::class;
            $seeder_list[] = ContactsSeeder::class;
            $seeder_list[] = AggSpecializationSeeder::class;
            $seeder_list[] = AlbumsSeeder::class;
            $seeder_list[] = FileInfoSeeder::class;
            $seeder_list[] = SocialNetworksSeeder::class;
            $seeder_list[] = UserDeclaredCitySeeder::class;
            $seeder_list[] = WorkingHoursSeeder::class;
            $seeder_list[] = VideosSeeder::class;
            $seeder_list[] = ServicesSeeder::class;
            $seeder_list[] = ArticlesSeeder::class;
            $seeder_list[] = AdditionalServicesSeeder::class;
            $seeder_list[] = FeedbackSeeder::class;
            $seeder_list[] = SalonDistancesSeeder::class;
            $seeder_list[] = LandingPagesSeeder::class;
            $seeder_list[] = LandingPageTagsSeeder::class;
            $seeder_list[] = SalonSelectionRequestsSeeder::class;
        }

        $this->call( $seeder_list );
    }
}
