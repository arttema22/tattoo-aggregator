<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSlugDefaultValueInDictionariesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up(): void
    {
        Schema::table( 'dictionaries', static function ( Blueprint $table ) {
            $table->string( 'slug', 255 )->nullable()->change();
        } );

        DB::table( 'dictionaries' )->where( 'slug', '' )->update( [ 'slug' => null ] );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        DB::table( 'dictionaries' )->whereNull( 'slug' )->update( [ 'slug' => '' ] );

        Schema::table( 'dictionaries', static function ( Blueprint $table ) {
            $table->string( 'slug', 255 )->nullable( false )->change();
        } );
    }
}
