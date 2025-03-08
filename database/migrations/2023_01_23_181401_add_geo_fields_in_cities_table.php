<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeoFieldsInCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::table( 'cities', static function ( Blueprint $table ) {
            $table->float( 'lat', 10, 6 )->nullable()->after( 'population' );
            $table->float( 'lon', 10, 6 )->nullable()->after( 'lat' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        Schema::table( 'cities', static function ( Blueprint $table ) {
            $table->dropColumn( 'lat' );
            $table->dropColumn( 'lon' );
        } );
    }
}
