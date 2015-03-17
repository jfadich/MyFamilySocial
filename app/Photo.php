<?php namespace MyFamily;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{

    protected $fillable = ['name', 'description', 'file_name', 'metadata'];

    public function album()
    {
        return $this->belongsTo( 'MyFamily\Album' );
    }

    public function owner()
    {
        return $this->belongsTo( 'MyFamily\User' );
    }
}
