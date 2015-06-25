<?php namespace MyFamily;

use MyFamily\Traits\Presentable;
use MyFamily\Traits\Slugify;
use MyFamily\Traits\RecordsActivity;

class Album extends Model
{
    use Presentable, RecordsActivity, Slugify;

    static $slug_field = ['name' => 'slug'];

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
        if ( $request->getAction() === 'UploadPhotoToAlbum' ) {
            if ( $this->shared ) {
                $request->checkPermission( 'CreatePhoto' );
            } else {
                $request->checkPermission( 'ManageAlbums' );
            }
        }

        return $request;
    }
}
