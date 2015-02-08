<?php namespace MyFamily;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    public $timestamps = false;

	public function roles()
    {
        return $this->belongsToMany('MyFamily\Roles', 'permission_role');
    }

}
