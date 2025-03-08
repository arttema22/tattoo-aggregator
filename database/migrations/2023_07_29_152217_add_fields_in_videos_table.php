<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInVideosTable extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::table( 'videos', static function ( Blueprint $table ) {
            $table->string( 'name', 255 )->default( '' )->after( 'preview' );
            $table->text( 'text' )->default( '' )->after( 'name' );
        } );
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table( 'videos', static function ( Blueprint $table ) {
            $table->dropColumn( [ 'name', 'text' ] );
        } );
    }
}
