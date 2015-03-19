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
            $table->text( 'description' )->nullable();
            $table->integer( 'owner_id' )->unsigned();
            $table->boolean( 'shared' )->default( false );
            $table->string( 'imageable_type' )->index();
            $table->integer( 'imageable_id' )->unsigned()->index();
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
