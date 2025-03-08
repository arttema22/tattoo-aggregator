<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalServicesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'additional_services', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'profile_id' );
            $table->unsignedBigInteger( 'contact_id' )->nullable();
            $table->unsignedBigInteger( 'as_id' );
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'additional_services' );
    }
}
