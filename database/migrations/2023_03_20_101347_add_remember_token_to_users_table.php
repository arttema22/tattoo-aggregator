<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRememberTokenToUsersTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::table( 'users', static function ( Blueprint $table ) {
            $table->rememberToken()->after( 'password' );
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::table( 'users', static function ( Blueprint $table ) {
            $table->dropRememberToken();
        } );
    }
}
