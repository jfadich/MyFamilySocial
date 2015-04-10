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
            $table->text( 'description' )->nullable();
            $table->integer( 'owner_id' )->unsigned();
            $table->text( 'metadata' )->nullable();
            $table->string( 'imageable_type' )->index();
            $table->integer( 'imageable_id' )->unsigned()->index();
            $table->timestamps();

            $table->foreign( 'owner_id' )->references( 'id' )->on( 'users' );
        } );


        Schema::create( 'photo_user', function (Blueprint $table) {
            $table->integer( 'user_id' )->unsigned()->index();
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );

            $table->integer( 'photo_id' )->unsigned()->index();
            $table->foreign( 'photo_id' )->references( 'id' )->on( 'photos' )->onDelete( 'cascade' );
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
