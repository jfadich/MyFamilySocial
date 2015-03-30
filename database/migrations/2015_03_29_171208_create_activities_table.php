<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'activities', function (Blueprint $table) {
            $table->increments( 'id' );
            $table->integer( 'owner_id' )->unsigned()->index();
            $table->integer( 'subject_id' )->unsigned();
            $table->string( 'subject_type' );
            $table->string( 'name' );
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
        Schema::drop( 'activities' );
    }

}
