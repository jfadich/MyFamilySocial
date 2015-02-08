<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumThreads extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forum_threads', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('owner_id')->unsigned()->index();
			$table->integer('category_id')->unsigned()->index();
			$table->string('slug')->unique();
			$table->string('title');
			$table->text('body');
			$table->timestamps();
			$table->foreign('owner_id')->references('id')->on('users');
			$table->foreign('category_id')->references('id')->on('forum_categories')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('forum_threads');
	}

}
