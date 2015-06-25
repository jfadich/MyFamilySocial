<?php

use MyFamily\Permission;
use MyFamily\Role;

class RoleTableSeeder extends Seeder {

    /**
     * Create the default Roles. These can be edited dynamically in admin console
     *
     * @return void
     */
    public function run()
    {
        // Contributor: Assign permissions to participate, but not edit other peoples content
        Role::create( [
            'name'        => 'Contributor',
            'description' => 'Standard user'
        ] )->permissions()->sync( Permission::whereIn( 'name', [
            'CreateForumThread',
            'CreateThreadReply',
            'CreatePhoto',
            'CreatePhotoAlbum',
            'CreatePhotoComment',
            'CreateComment',
        ] )->lists( 'id' )->toArray() );

        // Viewer: Role with no permissions. Users can only view content
        Role::create( [
            'name'        => 'Viewer',
            'description' => 'Read only'
        ] );

        // Admin: Assign all permission
        Role::create( [
            'name'        => 'Super Admin',
            'description' => 'Master of all'
        ] )->permissions()->sync( Permission::lists( 'id' )->toArray() );



    }

}
