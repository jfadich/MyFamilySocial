<?php

use Illuminate\Database\Seeder;
use MyFamily\Permission;

class PermissionsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'CreateForumThread',
                'description' => 'Create a thread in the forum'
            ],
            [
                'name' => 'CreateThreadReply',
                'description' => 'Add a reply to an existing thread'
            ],
        ];

        foreach($permissions as $permission)
        {
            Permission::create($permission);
        }

    }

}
