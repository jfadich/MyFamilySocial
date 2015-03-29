<?php namespace MyFamily;

use MyFamily\Traits\Presentable;

class Photo extends Model
{
    use Presentable;

    protected $presenter = 'MyFamily\Presenters\Photo';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function owner()
    {
        return $this->belongsTo( 'MyFamily\User' );
    }

    public function comments()
    {
        return $this->morphMany( 'MyFamily\Comment', 'commentable' );
    }

    public function storagePath($size)
    {
        return 'uploads/' . $this->owner_id . '/photos/' . $size;
    }
}
