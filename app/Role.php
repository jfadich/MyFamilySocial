<?php namespace MyFamily;

class Role extends Model {

    protected $fillable = ['name', 'description'];

    protected $hidden = ['created_at', 'updated_at', 'id'];

	public function permissions()
    {
        return $this->belongsToMany('MyFamily\Permission');
    }

    public function users()
    {
        return $this->hasMany('MyFamily\User');
    }
}
