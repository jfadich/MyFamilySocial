<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'albums', function (Blueprint $table) {
            $table->increments( 'id' );
            $table->string( 'name' );
            $table->string( 'slug' )->unique();
            $table->text( 'description' )->nullable();
            $table->integer( 'owner_id' )->unsigned();
            $table->boolean( 'shared' )->default( false );
            $table->timestamps();

            $table->foreign( 'owner_id' )->references( 'id' )->on( 'users' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop( 'albums' );
    }

}
