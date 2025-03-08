<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'cities', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'country_id' )->index();
            $table->string( 'alias', 128 )->unique();
            $table->string( 'name', 255 );
            $table->unsignedTinyInteger( 'has_metro' )->default( 0 );
            $table->unsignedTinyInteger( 'show_in_filter' )->default( 0 );
            $table->unsignedInteger( 'population' )->default( 0 );
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'cities' );
    }
}
