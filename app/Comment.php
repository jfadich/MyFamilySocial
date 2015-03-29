<?php namespace MyFamily;

use MyFamily\Traits\Presentable;

class Comment extends Model {

    use Presentable;

	protected $fillable = ['body', 'owner'];

    protected $touches = array('commentable');

    protected $presenter = 'MyFamily\Presenters\Comment';

    public function commentable()
    {
        return $this->morphTo();
    }

    public function owner()
    {
        return $this->belongsTo('MyFamily\User');
    }

}
