<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugFieldToLandingPagesTable extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::table( 'landing_pages', static function ( Blueprint $table ) {
            $table->string( 'slug' )->after( 'id' );
        } );
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table( 'landing_pages', static function ( Blueprint $table ) {
            $table->dropColumn( 'slug' );
        } );
    }
}
