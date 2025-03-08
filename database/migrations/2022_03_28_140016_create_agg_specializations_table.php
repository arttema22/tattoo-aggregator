<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAggSpecializationsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'agg_specializations', static function ( Blueprint $table ) {
            $table->unsignedBigInteger( 'contact_id' )->unique();
            $table->unsignedBigInteger( 'type' )->default( 0 )->index();
            $table->jsonb( 'attribute' );
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'agg_specializations' );
    }
}
