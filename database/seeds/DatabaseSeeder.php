<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use MyFamily\Activity;
use MyFamily\Album;
use MyFamily\Comment;
use MyFamily\ForumCategory;
use MyFamily\ForumThread;
use MyFamily\Permission;
use MyFamily\Photo;
use MyFamily\Role;
use MyFamily\Tag;
use MyFamily\User;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
        DB::statement( "SET foreign_key_checks=0" );

        Activity::truncate();
        Tag::truncate();
        Comment::truncate();
        Photo::truncate();
        Album::truncate();
        ForumThread::truncate();
        ForumCategory::truncate();
        User::truncate();
        Permission::truncate();
        Role::truncate();
        DB::delete( 'delete from permission_role' );
        exec( 'rm -R ' . storage_path( 'app/uploads' ) );

        DB::statement( "SET foreign_key_checks=1" );

        // Must be called in this order
        $this->call( 'PermissionsTableSeeder' );
        $this->call( 'RoleTableSeeder' );
        $this->call( 'UserTableSeeder' );
        $this->call( 'ForumCategoryTableSeeder' );
        $this->call( 'ForumThreadTableSeeder' );
        $this->call( 'AlbumTableSeeder' );
        $this->call( 'PhotoTableSeeder' );
        $this->call( 'CommentTableSeeder' );
        $this->call('TagTableSeeder');
	}

}
