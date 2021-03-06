<?php namespace MyFamily\Repositories;

use MyFamily\Permission;

class PermissionRepository extends Repository
{

    /**
     * @param $perm
     * @return mixed
     */
    public function find($perm)
    {
        if (is_numeric( $perm )) {
            return Permission::findOrFail( $perm );
        }

        return Permission::where( 'name', '=', $perm )->firstOrFail();
    }
}