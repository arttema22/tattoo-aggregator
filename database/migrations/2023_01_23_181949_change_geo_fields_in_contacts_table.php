<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeGeoFieldsInContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        DB::statement( 'ALTER TABLE `contacts` MODIFY `lat` DOUBLE(10,6) DEFAULT NULL;');
        DB::statement( 'ALTER TABLE `contacts` MODIFY `lon` DOUBLE(10,6) DEFAULT NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        DB::statement( 'ALTER TABLE `contacts` MODIFY `lat` DOUBLE(8,2) NOT NULL;');
        DB::statement( 'ALTER TABLE `contacts` MODIFY `lon` DOUBLE(8,2) NOT NULL;');
    }
}
