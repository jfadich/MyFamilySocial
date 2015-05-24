<?php namespace MyFamily\Transformers;

use League\Fractal\TransformerAbstract;
use MyFamily\Role;

class RoleTransformer extends Transformer {

    protected $permissions = [
        'create_forum_thread'   => 'CreateForumThread',
        'create_photo_album'    => 'CreatePhotoAlbum',
        'upload_photo'          => 'CreatePhoto'
    ];

    public function transform(Role $role)
    {
        return [
            'name'  => $role->name,
            'description' => $role->description,
            'permissions' => $this->getPermissions()
        ];
    }
}