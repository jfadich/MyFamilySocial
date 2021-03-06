<?php namespace MyFamily;


class Activity extends Model
{

    protected $guarded = ['id'];

    protected $with = ['actor', 'subject', 'target'];

    public function actor()
    {
        return $this->belongsTo( 'MyFamily\User', 'owner_id' );
    }

    public function subject()
    {
        return $this->morphTo();
    }

    public function target()
    {
        return $this->morphTo();
    }
}