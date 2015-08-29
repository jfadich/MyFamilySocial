<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoggerQuery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'db_logger_queries', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->integer( 'request_id' )->unsigned();
            $table->text( 'params' );
            $table->text( 'query' );
            $table->float( 'time' );
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
        Schema::drop( 'db_logger_queries' );
    }
}
