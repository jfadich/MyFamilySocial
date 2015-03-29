<?php namespace MyFamily;

use MyFamily\Traits\Presentable;

class Album extends Model
{
    use Presentable;

    protected $presenter = 'MyFamily\Presenters\Album';

    protected $guarded = ['id'];

    protected $casts = ['shared' => 'boolean'];

    public function photos()
    {
        return $this->morphMany( 'MyFamily\Photo', 'imageable' );
    }

    public function owner()
    {
        return $this->belongsTo( 'MyFamily\User' );
    }

    public function tags()
    {
        return $this->morphToMany( 'MyFamily\Tag', 'taggable' );
    }

    public function authorize($request)
    {
        if ($this->shared && $request->getAction() === 'UploadPhotoToAlbum') {
            $request->setAuthorized( true );
        }

        return $request;
    }
}
