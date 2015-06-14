<?php namespace MyFamily\Transformers;

use League\Fractal\TransformerAbstract;
use MyFamily\Role;

class RoleTransformer extends Transformer {

    protected $permissions = [
        'forum_createThread'   => 'CreateForumThread',
        'photos_createAlbum'    => 'CreatePhotoAlbum',
        'photos_upload'          => 'CreatePhoto'
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