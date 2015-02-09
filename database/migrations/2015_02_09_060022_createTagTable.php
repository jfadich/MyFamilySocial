<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tags', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('slug')->unique();
			$table->text('description')->nullable();
			$table->timestamps();
		});

		Schema::create('taggables', function(Blueprint $table)
		{
			$table->string('taggable_type')->index();
			$table->integer('taggable_id')->unsigned()->index();
			$table->integer('tag_id')->unsigned()->index();

			$table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('taggables');
		Schema::drop('tags');
	}

}
