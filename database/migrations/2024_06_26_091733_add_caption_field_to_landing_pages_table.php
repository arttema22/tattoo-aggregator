<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCaptionFieldToLandingPagesTable extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::table( 'landing_pages', static function ( Blueprint $table ) {
            $table->string( 'caption' )->nullable()->after( 'description' );
        } );
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table( 'landing_pages', static function ( Blueprint $table ) {
            $table->dropColumn( 'caption' );
        } );
    }
}
