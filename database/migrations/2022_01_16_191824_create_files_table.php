<?php

use App\Enums\FileSubtypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'files', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'user_id' )->index();
            $table->morphs( 'fileable' );
            $table->unsignedInteger( 'fileable_subtype' )->default( FileSubtypes::COMMON );
            $table->string( 'original', 255 );
            $table->mediumText( 'thumbs' );
            $table->unsignedInteger( 'size' )->default( 0 );
            $table->string( 'mime_type', 255 );
            $table->timestamps();
            $table->timestamp( 'deleted_at' )->nullable();
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'files' );
    }
}
