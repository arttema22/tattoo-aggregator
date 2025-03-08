<?php

namespace Database\Seeders;

use App\Models\WorkingHours;
use Illuminate\Database\Seeder;

class WorkingHoursDefaultValuesSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        WorkingHours::where( 'is_weekend', 1 )
            ->whereNull( 'start' )
            ->whereNull( 'end' )
            ->update( [ 'is_weekend' => 0 ] );
    }
}
