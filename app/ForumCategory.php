<?php namespace MyFamily;

use MyFamily\Traits\Presentable;
use MyFamily\Traits\Slugify;

class ForumCategory extends Model {

    use Presentable, Slugify;

    static $slug_field = ['name' => 'slug'];

    protected $table = 'forum_categories';

    protected $fillable = ['slug', 'name', 'description'];

    protected $presenter = 'MyFamily\Presenters\ForumCategory';

    public function threads()
    {
        return $this->hasMany('MyFamily\ForumThread', 'category_id');
    }

    public function postCount()
    {
        return \DB::select(
            "SELECT count(*) as posts FROM comments WHERE commentable_type = ? AND commentable_id IN (SELECT id FROM forum_threads WHERE category_id = ?)",
            [ 'MyFamily\ForumThread', $this->id ] )[ 0 ]->posts;
    }

}
