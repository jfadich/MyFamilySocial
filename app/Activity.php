<?php namespace MyFamily;


class Activity extends Model
{

    protected $guarded = ['id'];

    protected $with = ['actor', 'subject'];

    public function actor()
    {
        return $this->belongsTo( 'MyFamily\User', 'owner_id' );
    }

    public function subject()
    {
        return $this->morphTo();
    }
}