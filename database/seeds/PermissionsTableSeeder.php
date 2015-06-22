<?php

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
                'name'        => 'EditForumThread',
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
                'name'        => 'EditComment',
                'description' => 'Modify any existing comment'
            ],
            [
                'name'        => 'DeleteComment',
                'description' => 'Delete any comment'
            ],
            // User
            [
                'name'        => 'EditProfileInfo',
                'description' => 'Edit any users profile'
            ],
            [
                'name' => 'EditUserRole',
                'description' => 'Assign a new role to as user'
            ],
            // Photo
            [
                'name'        => 'CreatePhoto',
                'description' => 'Upload new photos'
            ],
            [
                'name' => 'EditPhoto',
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
            [
                'name'        => 'EditPhotoAlbum',
                'description' => 'Edit and existing album'
            ],
            [
                'name'        => 'CreatePhotoComment',
                'description' => 'Comment on a photo'
            ],
            [
                'name'        => 'CreateComment',
                'description' => 'Comment on a photo'
            ],
        ];

        foreach($permissions as $permission)
        {
            Permission::create($permission);
        }

    }

}
