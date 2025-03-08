<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileInfoTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'file_info', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'file_id' );
            $table->string( 'name', 255 );
            $table->mediumText( 'description' );
            $table->jsonb( 'attribute' );
            // 0 - false, 1 - true
            $table->unsignedTinyInteger( 'is_downloadable' )->default( 0 );
            $table->unsignedTinyInteger( 'is_adult' )->default( 0 );
            $table->unsignedTinyInteger( 'is_approved' )->default( 0 );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'file_info' );
    }
}
