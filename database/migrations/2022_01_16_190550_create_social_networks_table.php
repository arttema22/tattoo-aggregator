<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialNetworksTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'social_networks', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'profile_id' );
            $table->unsignedBigInteger( 'contact_id' )->nullable();
            $table->unsignedBigInteger( 'sn_id' )->index();
            $table->string( 'value', 255 );
            // 0 - off, 1 - on
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
        Schema::dropIfExists( 'social_networks' );
    }
}
