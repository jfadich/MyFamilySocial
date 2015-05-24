<?php namespace MyFamily;

use MyFamily\Traits\Presentable;
use MyFamily\Traits\RecordsActivity;

class ForumThread extends Model {

    use Presentable, RecordsActivity;

    protected $table = 'forum_threads';

    protected $with = ['loadReplyCount', 'category'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $presenter = 'MyFamily\Presenters\ForumThread';

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

    public function tags()
    {
        return $this->morphToMany('MyFamily\Tag', 'taggable');
    }

    public function loadReplyCount()
    {
        return $this->replies()->whereIn( 'comments.commentable_id',
            $this->replies()->lists( 'commentable_id' ) )->where( 'comments.commentable_type', '=',
            'MyFamily\ForumThread' )->select( 'commentable_id' );
    }

    public function getReplyCountAttribute()
    {
        return count($this->getRelations()['loadReplyCount']);
    }

    public function authorize($request)
    {
        if ($request->getAction() === 'CreateThreadReply' && $this->owner_id == \JWTAuth::toUser()->id) {
            $request->setAuthorized( true );
        }

        return $request;
    }
}
