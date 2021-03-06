<?php namespace MyFamily;

use MyFamily\Traits\Presentable;
use MyFamily\Traits\RecordsActivity;
use MyFamily\Traits\Slugify;

class ForumThread extends Model {

    use Presentable, RecordsActivity, Slugify;

    static $slug_field = ['title' => 'slug'];

    protected $fillable = [ 'title', 'body', 'category_id', 'owner_id', 'last_reply' ];

    protected $table = 'forum_threads';

    public $dates = ['last_reply'];

    protected $with = [ 'owner', 'category' ];

    protected $presenter = 'MyFamily\Presenters\ForumThread';

    public function __construct( array $attributes = [ ] )
    {
        parent::__construct( $attributes );
    }

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

    public function getActivityTarget()
    {
        $target[ 'id' ]   = $this->category->id;
        $target[ 'type' ] = 'MyFamily\ForumCategory';

        return $target;
    }
}
