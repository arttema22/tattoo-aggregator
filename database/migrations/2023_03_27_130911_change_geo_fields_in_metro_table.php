<?php

use Illuminate\Database\Migrations\Migration;

class ChangeGeoFieldsInMetroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        DB::statement( 'ALTER TABLE `metro` MODIFY `lat` DOUBLE(10,6) DEFAULT NULL;');
        DB::statement( 'ALTER TABLE `metro` MODIFY `lon` DOUBLE(10,6) DEFAULT NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        DB::statement( 'ALTER TABLE `metro` MODIFY `lat` DOUBLE(8,2) NOT NULL;');
        DB::statement( 'ALTER TABLE `metro` MODIFY `lon` DOUBLE(8,2) NOT NULL;');
    }
}
