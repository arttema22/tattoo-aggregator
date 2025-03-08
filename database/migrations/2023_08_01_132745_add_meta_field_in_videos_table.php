<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaFieldInVideosTable extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::table( 'videos', static function ( Blueprint $table ) {
            $table->text( 'html' )->after( 'text' );
            $table->jsonb( 'meta' )->after( 'html' );
        } );
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table( 'videos', static function ( Blueprint $table ) {
            $table->dropColumn( [ 'meta', 'html' ] );
        } );
    }
}
