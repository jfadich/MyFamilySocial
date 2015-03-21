<?php namespace MyFamily;

class Album extends Model
{

    protected $fillable = ['name', 'description'];

    public function photos()
    {
        return $this->hasMany( 'MyFamily\Photo' );
    }

    public function owner()
    {
        return $this->belongsTo( 'MyFamily\User' );
    }
}
