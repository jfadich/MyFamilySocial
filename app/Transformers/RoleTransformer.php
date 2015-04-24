<?php namespace MyFamily\Transformers;

use League\Fractal\TransformerAbstract;
use MyFamily\Role;

class RoleTransformer extends TransformerAbstract {

    public function transform(Role $role)
    {
        return [
            'name'  => $role->name,
            'description' => $role->description,
            'permissions' => $role->permissions
        ];
    }
}