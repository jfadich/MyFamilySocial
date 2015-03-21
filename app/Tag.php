<?php namespace MyFamily;

class Tag extends Model {

    protected $fillable = ['name', 'description', 'slug'];

	public function forumThreads()
    {
        return $this->morphedByMany('MyFamily\ForumThread', 'taggable');
    }

}
