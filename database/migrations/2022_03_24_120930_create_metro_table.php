<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetroTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'metro', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'city_id' )->index();
            $table->unsignedBigInteger( 'line_id' )->index();
            $table->string( 'name', 255 );
            $table->float( 'lat' )->nullable();
            $table->float( 'lon' )->nullable();
            $table->unsignedTinyInteger( 'position' )->default( 0 );
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'metro' );
    }
}
