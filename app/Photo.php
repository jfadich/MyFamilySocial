<?php namespace MyFamily;

use MyFamily\Traits\Presentable;
use MyFamily\Traits\RecordsActivity;

class Photo extends Model
{
    use Presentable, RecordsActivity;

    protected $presenter = Presenters\Photo::class;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $touches = ['imageable'];

    public static $sizes = ['small', 'thumb', 'medium', 'card', 'large'];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function owner()
    {
        return $this->belongsTo( User::class );
    }

    public function comments()
    {
        return $this->morphMany( Comment::class, 'commentable' );
    }

    public function tags()
    {
        return $this->morphToMany( Tag::class, 'taggable' );
    }

    public function tagged_users()
    {
        return $this->belongsToMany( 'MyFamily\User' );
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
