<?php namespace MyFamily;

use MyFamily\Traits\Presentable;

class Tag extends Model {

    use Presentable;

    protected $fillable = ['name', 'description', 'slug'];

    protected $presenter = 'MyFamily\Presenters\Tag';

	public function forumThreads()
    {
        return $this->morphedByMany('MyFamily\ForumThread', 'taggable');
    }

}
