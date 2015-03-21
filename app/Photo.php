<?php namespace MyFamily;

class Photo extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function imagable()
    {
        return $this->morphTo();
    }

    public function owner()
    {
        return $this->belongsTo( 'MyFamily\User' );
    }

    public function storagePath($size)
    {
        return 'uploads/' . $this->owner_id . '/photos/' . $size;
    }
}
