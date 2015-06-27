<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email')->unique();
			$table->integer('profile_picture')->unsigned()->nullable();
			$table->integer('role_id')->unsigned();
			$table->string('password', 60);
			$table->string('phone_one', 30)->nullable();
			$table->string('phone_two', 30)->nullable();
			$table->string('street_address')->nullable();
			$table->string('city')->nullable();
            $table->string( 'state' )->nullable()->default( null );
            $table->string('zip_code',10)->nullable();
            $table->timestamp( 'birthdate' )->nullable()->default( '0000-00-00 00:00:00' );
            $table->text('website')->nullable();
            $table->json( 'privacy' )->nullable();
            $table->rememberToken();
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
