<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

        // Must be called in this order
        /* $this->call('PermissionsTableSeeder');
         $this->call('RoleTableSeeder');
         $this->call('UserTableSeeder');
         $this->call('ForumCategoryTableSeeder');
         $this->call('ForumThreadTableSeeder');
         $this->call('AlbumTableSeeder');
         $this->call('PhotoTableSeeder'); */
        $this->call( 'CommentTableSeeder' );
        $this->call('TagTableSeeder');
	}

}
