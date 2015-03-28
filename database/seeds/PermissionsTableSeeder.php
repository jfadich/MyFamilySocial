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

            // Forum
            [
                'name' => 'CreateForumThread',
                'description' => 'Create a thread in the forum'
            ],
            [
                'name'        => 'ModifyForumThread',
                'description' => 'Modify any existing thread in the forum'
            ],
            [
                'name'        => 'DeleteForumThread',
                'description' => 'Modify any existing thread in the forum'
            ],
            [
                'name' => 'CreateThreadReply',
                'description' => 'Add a reply to an existing thread'
            ],
            [
                'name'        => 'ModifyThreadReply',
                'description' => 'Modify any existing forum reply'
            ],
            [
                'name'        => 'DeleteThreadReply',
                'description' => 'Delete any forum reply'
            ],
            // User
            [
                'name'        => 'EditProfileInfo',
                'description' => 'Edit any users profile'
            ],
            [
                'name'        => 'ModifyUserRole',
                'description' => 'Assign a new role to as user'
            ],
            // Photo
            [
                'name'        => 'CreatePhoto',
                'description' => 'Upload new photos'
            ],
            [
                'name'        => 'ModifyPhoto',
                'description' => 'Modify any existing photo'
            ],
            [
                'name'        => 'UploadPhotoToAlbum',
                'description' => 'Add photo to an exiting album'
            ],
            [
                'name'        => 'CreatePhotoAlbum',
                'description' => 'Add create a new album'
            ],
        ];

        foreach($permissions as $permission)
        {
            Permission::create($permission);
        }

    }

}
