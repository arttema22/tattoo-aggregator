<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'contacts', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'profile_id' )->index();
            $table->unsignedBigInteger( 'country_id' );
            $table->unsignedBigInteger( 'city_id' );
            $table->unsignedBigInteger( 'metro_id' )->default( 0 );
            $table->string( 'alias', 255 )->unique();
            $table->string( 'name', 255 );
            $table->string( 'address', 255 );
            $table->string( 'phone', 255 );
            $table->string( 'site', 255 );
            $table->string( 'email', 255 );
            $table->string( 'district', 255 );
            $table->float( 'lat' );
            $table->float( 'lon' );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'contacts' );
    }
}
