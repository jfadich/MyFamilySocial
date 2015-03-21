<?php namespace MyFamily;

class Comment extends Model {

	protected $fillable = ['body', 'owner'];

    protected $touches = array('commentable');

    public function commentable()
    {
        return $this->morphTo();
    }

    public function owner()
    {
        return $this->belongsTo('MyFamily\User');
    }

}
