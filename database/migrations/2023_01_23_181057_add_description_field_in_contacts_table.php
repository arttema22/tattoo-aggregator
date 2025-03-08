<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionFieldInContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::table( 'contacts', static function ( Blueprint $table ) {
            $table->mediumText( 'description' )->nullable()->after( 'name' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        Schema::table( 'contacts', static function ( Blueprint $table ) {
            $table->dropColumn( 'description' );
        } );
    }
}
