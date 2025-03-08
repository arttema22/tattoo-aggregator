<?php

use App\Models\SalonDistance;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalonDistancesTable extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create( 'salon_distances', static function ( Blueprint $table ) {
            $table->unsignedBigInteger( 'salon_id' )->index();
            $table->unsignedBigInteger( 'salon_nearby_id' );
            $table->unsignedBigInteger( 'distance' )->comment( 'in meters' );

            $table->primary( SalonDistance::PRIMARY_COMPOSITE_KEY );
        } );
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists( 'salon_distances' );
    }
}
