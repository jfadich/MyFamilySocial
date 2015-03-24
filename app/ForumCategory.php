<?php namespace MyFamily;

use MyFamily\Traits\Presentable;

class ForumCategory extends Model {

    use Presentable;
    protected $table = 'forum_categories';

    protected $fillable = ['slug', 'name', 'description'];

    protected $presenter = 'MyFamily\Presenters\ForumCategory';

    public function threads()
    {
        return $this->hasMany('MyFamily\ForumThread', 'category_id');
    }

}
