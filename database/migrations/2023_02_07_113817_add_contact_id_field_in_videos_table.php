<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactIdFieldInVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::table( 'videos', static function ( Blueprint $table ) {
            $table->unsignedBigInteger( 'contact_id' )->nullable()->after( 'profile_id' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        Schema::table( 'videos', static function ( Blueprint $table ) {
            $table->dropColumn( 'contact_id' );
        } );
    }
}
