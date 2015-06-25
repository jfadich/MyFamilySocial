<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->text('description')->nullable();
			$table->timestamps();
		});

		Schema::table('users', function(Blueprint $table)
		{
            $table->foreign( 'role_id' )->references( 'id' )->on( 'roles' )->onDelete( 'restrict' )->onUpdate( 'cascade' );
		});

		Schema::create('permissions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('description')->nullable();
            $table->tinyInteger( 'subject_bound' )->default( 0 );
		});

		Schema::create('permission_role', function(Blueprint $table)
		{
			$table->integer('role_id')->unsigned()->index();
            $table->foreign( 'role_id' )->references( 'id' )->on( 'roles' )->onDelete( 'cascade' )->onUpdate( 'cascade' );

			$table->integer('permission_id')->unsigned()->index();
            $table->foreign( 'permission_id' )->references( 'id' )->on( 'permissions' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('roles');
		Schema::drop('permissions');
		Schema::drop('permissions_role');
	}

}
