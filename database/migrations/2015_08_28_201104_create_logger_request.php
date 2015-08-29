<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoggerRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'db_logger_requests', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->string( 'uri' );
            $table->string( 'method' );
            $table->float( 'total_time' );
            $table->text( 'parameters' );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop( 'db_logger_requests' );
    }
}
