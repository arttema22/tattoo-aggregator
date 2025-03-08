<?php

namespace Database\Seeders;

use App\Jobs\CalculateContactFilledPercentJob;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactFilledPercentSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Contact::all()->each( fn ( Contact $contact ) => CalculateContactFilledPercentJob::dispatch( $contact->id ) );
    }
}
