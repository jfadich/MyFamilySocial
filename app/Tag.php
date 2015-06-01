<?php namespace MyFamily;

use MyFamily\Traits\Presentable;
use MyFamily\Traits\Slugify;

class Tag extends Model {

    use Presentable, Slugify;

    static $slug_field = ['name' => 'slug'];

    protected $fillable = ['name', 'description', 'slug'];

    protected $presenter = 'MyFamily\Presenters\Tag';

	public function forumThreads()
    {
        return $this->morphedByMany('MyFamily\ForumThread', 'taggable');
    }

    public function albums()
    {
        return $this->morphedByMany( 'MyFamily\Album', 'taggable' );
    }

    public function photos()
    {
        return $this->morphedByMany( 'MyFamily\Photo', 'taggable' );
    }


}
