<?php namespace MyFamily;

use MyFamily\Traits\Presentable;
use MyFamily\Traits\RecordsActivity;
use MyFamily\Traits\Slugify;

class ForumThread extends Model {

    use Presentable, RecordsActivity, Slugify;

    static $slug_field = ['title' => 'slug'];

    protected $fillable = [ 'title', 'body', 'owner_id', 'category_id', ];

    protected $table = 'forum_threads';

    public $dates = ['last_reply'];

    protected $with = [ 'owner', 'category' ];

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

    public function getReplyCountAttribute()
    {
        return count($this->getRelations()['loadReplyCount']);
    }

    public function authorize($request)
    {
        if ( $request->getAction()->name === 'CreateThreadReply' ) {
            $request->checkPermission( 'CreateComment' );

            if ( $this->owner_id == \JWTAuth::toUser()->id ) {
                $request->setAuthorized( true );
            }
        }

        return $request;
    }
}
