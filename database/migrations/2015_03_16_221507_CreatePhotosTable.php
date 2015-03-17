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
            $table->integer( 'album' )->unsigned()->references( 'in' )->on( 'albums' );
            $table->text( 'description' )->nullable();
            $table->integer( 'owner_id' )->unsigned()->references( 'id' )->on( 'users' );
            $table->text( 'metedata' )->nullable();
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
        Schema::drop( 'photos' );
    }

}
