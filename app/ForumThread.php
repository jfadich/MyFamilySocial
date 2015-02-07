<?php namespace MyFamily;

use Illuminate\Database\Eloquent\Model;

class ForumThread extends Model {

    protected $table = 'forum_threads';

    protected $guarded = ['id', 'created_at', 'updated_at'];

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

    public function getReplyCountAttribute()
    {
        return $this->replies()->count();
    }
}
