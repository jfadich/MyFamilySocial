<?php namespace MyFamily;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function album()
    {
        return $this->belongsTo( 'MyFamily\Album', 'id', 'album' );
    }

    public function owner()
    {
        return $this->belongsTo( 'MyFamily\User' );
    }

    public function storagePath()
    {
        return 'uploads/' . $this->owner_id . '/photos';
    }
}
