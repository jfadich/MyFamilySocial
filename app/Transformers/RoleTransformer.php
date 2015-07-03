<?php namespace MyFamily\Transformers;

use League\Fractal\TransformerAbstract;
use MyFamily\Role;

class RoleTransformer extends Transformer {

    protected $permissions = [
        'forum_createThread'   => 'CreateForumThread',
        'forum_glueThread' => 'GlueForumThread',
        'photos_createAlbum'    => 'CreatePhotoAlbum',
        'photos_upload' => 'CreatePhoto',
    ];

    public function transform(Role $role)
    {
        return [
            'id' => $role->id,
            'name'  => $role->name,
            'description' => $role->description,
            'permissions' => $this->getPermissions()
        ];
    }
}