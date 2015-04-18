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
        $this->call('ForumThreadTableSeeder');
        $this->call('AlbumTableSeeder');
        $this->call('PhotoTableSeeder');
        $this->call('CommentTableSeeder');
        $this->call('TagTableSeeder');
    }

    /**
     * Truncate the tables and clear and uploaded files
     *
     */
    private function clearData()
    {

        DB::statement("SET foreign_key_checks=0");

        $tables = [
            'activities',
            'tags',
            'comments',
            'photos',
            'album',
            'forum_threads',
            'forum_categories',
            'users',
            'permissions',
            'roles',
            'permission_role'
        ];

        foreach ($tables as $table) {
            \DB::table($table)->truncate();
        }

        if (file_exists(storage_path('app/uploads'))) {
            exec('rm -R ' . storage_path('app/uploads'));
        }

        DB::statement("SET foreign_key_checks=1");
    }

}
