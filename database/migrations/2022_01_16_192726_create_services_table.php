<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'services', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'profile_id' );
            $table->string( 'name', 255 );
            // 0 - n/a, 1 - tattoo, 2 - tatuaje, 3 - piercing, 4 - other
            $table->unsignedBigInteger( 'type' );
            $table->decimal( 'price', 8, 2, true )->default( 0 );
            $table->char( 'currency', 3 );
            // 0 - false, 1 - true
            $table->unsignedTinyInteger( 'is_start_price' )->default( 0 );
            // 0 - n/a, 1 - on, 2 - off
            $table->unsignedTinyInteger( 'status' )->default( 0 );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'services' );
    }
}
