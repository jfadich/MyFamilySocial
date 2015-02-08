<?php namespace MyFamily;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

	protected $fillable = ['body', 'owner'];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function owner()
    {
        return $this->belongsTo('MyFamily\User');
    }

}
