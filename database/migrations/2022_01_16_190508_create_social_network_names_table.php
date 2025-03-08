<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialNetworkNamesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'social_network_names', static function ( Blueprint $table ) {
            $table->id();
            $table->string( 'name', 128 );
            $table->string( 'alias', 32 )->unique();
            $table->string( 'url', 255 );
            $table->unsignedTinyInteger( 'status' )->default( 1 );
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'social_network_names' );
    }
}
