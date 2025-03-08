<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFilledPercentFieldsToContactsTable extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::table( 'contacts', static function ( Blueprint $table ) {
            $table->unsignedSmallInteger( 'filled_percent' )->default( 0 )->after( 'lon' );
            $table->integer( 'additional_filled_percent' )->default( 0 )->after( 'filled_percent' );
        } );
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table( 'contacts', static function ( Blueprint $table ) {
            $table->dropColumn( 'filled_percent' );
            $table->dropColumn( 'additional_filled_percent' );
        } );
    }
}
