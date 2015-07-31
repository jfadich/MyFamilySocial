<?php

use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->clearData();

        // Must be called in this order
        $this->call('PermissionsTableSeeder');
        $this->call('RoleTableSeeder');
        $this->call('UserTableSeeder');
        $this->call('ForumCategoryTableSeeder');
        $this->call( 'TagTableSeeder' );
        $this->call('ForumThreadTableSeeder');
        $this->call('AlbumTableSeeder');
    }

    /**
     * Truncate the tables and clear and uploaded files
     *
     */
    protected function clearData()
    {

        DB::statement("SET foreign_key_checks=0");

        $tables = [
            'activities',
            'albums',
            'tags',
            'taggables',
            'comments',
            'photos',
            'photo_user',
            'forum_threads',
            'forum_categories',
            'users',
            'permissions',
            'roles',
            'permission_role'
        ];

        foreach ($tables as $table) {
            DB::table( $table )->truncate();
        }

        if (file_exists(storage_path('app/uploads'))) {
            exec('rm -R ' . storage_path('app/uploads'));
        }

        DB::statement("SET foreign_key_checks=1");
    }

}
