<?php namespace MyFamily;

use Illuminate\Database\Eloquent\Model;

class ForumThread extends Model {

    protected $table = 'forum_threads';

    protected $with = ['loadReplyCount', 'category'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    private $replyCount;

    public function category()
    {
        return $this->hasOne('MyFamily\ForumCategory', 'id', 'category_id');
    }

    public function replies()
    {
        return $this->morphMany('MyFamily\Comment', 'commentable');
    }

    public function owner()
    {
        return $this->belongsTo('MyFamily\User', 'owner_id');
    }

    public function getUrlAttribute()
    {
        return 'forum/'.$this->category->slug . '/' . $this->slug;
    }

    public function loadReplyCount()
    {
        return $this->replies()->whereIn('comments.commentable_id', $this->replies()->lists('commentable_id'))->where('comments.commentable_type', '=', 'MyFamily\ForumThread')->select('commentable_id');
        //return $this->replies()->whereIn('count(*) as aggregate');
    }

    public function getReplyCountAttribute()
    {
        return count($this->getRelations()['loadReplyCount']);
    }
}
