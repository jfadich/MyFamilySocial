<?php namespace MyFamily;

use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model {

    protected $table = 'forum_categories';

    protected $fillable = ['slug', 'name', 'description'];

    public function threads()
    {
        return $this->hasMany('MyFamily\ForumThread');
    }

}
