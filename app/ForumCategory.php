<?php namespace MyFamily;

class ForumCategory extends Model {

    protected $table = 'forum_categories';

    protected $fillable = ['slug', 'name', 'description'];

    public function threads()
    {
        return $this->hasMany('MyFamily\ForumThread', 'category_id');
    }

}
