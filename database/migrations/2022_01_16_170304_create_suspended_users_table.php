<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuspendedUsersTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'suspended_users', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'user_id' )->index();
            $table->timestamp( 'started_at' )->nullable();
            $table->timestamp( 'ended_at' )->nullable();
            $table->string( 'reason', 64 )->nullable();
            // 0 - n/a, 1 - ban, 2 - end ban
            $table->unsignedTinyInteger( 'status' )->default( 0 );
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'suspended_users' );
    }
}
