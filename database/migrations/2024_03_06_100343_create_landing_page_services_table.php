<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingPageServicesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'landing_page_services', function ( Blueprint $table ) {
            $table->id();
            $table->unsignedInteger( 'landing_page_id' )->index();
            $table->unsignedTinyInteger( 'type' );
            $table->string( 'name', 255 );
            $table->decimal( 'price', 8, 2, true )->default( 0.00 );
            $table->string( 'currency', 8 )->default('RUB');
            $table->unsignedTinyInteger( 'is_start_price' )->default( 0 );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'landing_page_services' );
    }
}
