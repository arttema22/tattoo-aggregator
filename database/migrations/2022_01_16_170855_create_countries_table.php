<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'countries', static function ( Blueprint $table ) {
            $table->id();
            $table->char( 'iso', 2 );
            $table->string( 'name', 255 );
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'countries' );
    }
}
