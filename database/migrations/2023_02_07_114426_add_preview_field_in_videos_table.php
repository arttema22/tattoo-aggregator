<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreviewFieldInVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::table( 'videos', static function ( Blueprint $table ) {
            $table->text( 'preview' )->nullable()->after( 'url' );
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
            $table->dropColumn( 'preview' );
        } );
    }
}
