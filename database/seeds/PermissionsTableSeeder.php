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
        MyFamily\Model::unguard();
        $permissions = [

            // Forum
            [
                'name' => 'CreateForumThread',
                'description'   => 'Create a thread in the forum',
                'subject_bound' => false
            ],
            [
                'name'          => 'GlueForumThread',
                'description'   => 'make a post stick so it stays on top',
                'subject_bound' => false
            ],
            [
                'name'        => 'EditForumThread',
                'description'   => 'Modify any existing thread in the forum',
                'subject_bound' => true
            ],
            [
                'name'        => 'DeleteForumThread',
                'description'   => 'Modify any existing thread in the forum',
                'subject_bound' => true
            ],
            [
                'name' => 'CreateThreadReply',
                'description'   => 'Add a reply to an existing thread',
                'subject_bound' => true
            ],
            [
                'name'        => 'EditComment',
                'description'   => 'Modify any existing comment',
                'subject_bound' => true
            ],
            [
                'name'        => 'DeleteComment',
                'description'   => 'Delete any comment',
                'subject_bound' => true
            ],
            // User
            [
                'name'        => 'EditProfileInfo',
                'description'   => 'Edit any users profile',
                'subject_bound' => true
            ],
            [
                'name' => 'EditUserRole',
                'description'   => 'Assign a new role to as user',
                'subject_bound' => true
            ],
            // Photo
            [
                'name'        => 'CreatePhoto',
                'description'   => 'Upload new photos',
                'subject_bound' => false
            ],
            [
                'name' => 'EditPhoto',
                'description'   => 'Modify any existing photo',
                'subject_bound' => true
            ],
            [
                'name'        => 'UploadPhotoToAlbum',
                'description'   => 'Add photo to an exiting album',
                'subject_bound' => true
            ],
            [
                'name'        => 'CreatePhotoAlbum',
                'description'   => 'Add create a new album',
                'subject_bound' => false
            ],
            [
                'name'        => 'EditPhotoAlbum',
                'description'   => 'Edit and existing album',
                'subject_bound' => true
            ],
            [
                'name'        => 'ManageAlbums',
                'description'   => 'Add photos to any album',
                'subject_bound' => false
            ],
            [
                'name'        => 'CreatePhotoComment',
                'description'   => 'Comment on a photo',
                'subject_bound' => true
            ],
            [
                'name'        => 'CreateComment',
                'description'   => 'Create a comment',
                'subject_bound' => false
            ],
            [
                'name'          => 'DeletePhotoAlbum',
                'description'   => 'Delete an existing photo album',
                'subject_bound' => true
            ]
        ];

        foreach($permissions as $permission)
        {
            Permission::create($permission);
        }

    }

}
