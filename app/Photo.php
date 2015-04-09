<?php namespace MyFamily;

use MyFamily\Traits\Presentable;
use MyFamily\Traits\RecordsActivity;

class Photo extends Model
{
    use Presentable, RecordsActivity;

    protected $presenter = 'MyFamily\Presenters\Photo';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $touches = ['imageable'];

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

    public function tags()
    {
        return $this->morphToMany( 'MyFamily\Tag', 'taggable' );
    }

    public function storagePath($size)
    {
        return 'uploads/' . $this->owner_id . '/photos/' . $size;
    }

    public function getActivityTarget()
    {
        $target[ 'id' ]   = $this->imageable->id;
        $target[ 'type' ] = $this->imageable_type;

        return $target;
    }
}
