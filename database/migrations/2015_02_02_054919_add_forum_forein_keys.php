<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForumForeinKeys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('forum_threads', function(Blueprint $table)
		{
			$table->foreign('owner')->references('id')->on('users');
			$table->foreign('category')->references('id')->on('forum_categories');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('forum_threads', function(Blueprint $table)
		{
			$table->dropForeign('forum_threads_owner_foreign');
			$table->dropForeign('forum_threads_category_foreign');
		});
	}

}
