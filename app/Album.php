<?php namespace MyFamily;

use Illuminate\Database\Eloquent\Model;

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
