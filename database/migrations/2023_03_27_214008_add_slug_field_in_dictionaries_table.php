<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugFieldInDictionariesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up(): void
    {
        Schema::table( 'dictionaries', static function ( Blueprint $table ) {
            $table->string( 'slug', 255 );
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::table( 'dictionaries', static function ( Blueprint $table ) {
            $table->dropColumn( 'slug' );
        } );
    }
}
