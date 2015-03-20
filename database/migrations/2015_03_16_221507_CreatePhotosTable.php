<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'photos', function (Blueprint $table) {
            $table->increments( 'id' );
            $table->string( 'name' );
            $table->string( 'file_name' );
            $table->integer( 'album' )->unsigned();
            $table->text( 'description' )->nullable();
            $table->integer( 'owner_id' )->unsigned();
            $table->text( 'metedata' )->nullable();
            $table->timestamps();

            $table->foreign( 'owner_id' )->references( 'id' )->on( 'users' );
            $table->foreign( 'album' )->references( 'id' )->on( 'albums' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop( 'photos' );
    }

}
