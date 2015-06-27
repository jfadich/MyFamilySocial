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
            $table->integer( 'owner_id' )->unsigned()->index()->nullable();
			$table->integer('category_id')->unsigned()->index();
			$table->string('slug')->unique();
			$table->string('title');
			$table->text('body');
            $table->tinyInteger( 'sticky' )->default( 0 );
            $table->timestamp( 'last_reply' )->default( DB::raw( 'CURRENT_TIMESTAMP' ) );
            $table->timestamps();
            $table->foreign( 'owner_id' )->references( 'id' )->on( 'users' )->onDelete( 'set null' )->onUpdate( 'cascade' );
            $table->foreign( 'category_id' )->references( 'id' )->on( 'forum_categories' )->onDelete( 'restrict' )->onUpdate( 'cascade' );
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
