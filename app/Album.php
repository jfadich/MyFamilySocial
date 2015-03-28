<?php namespace MyFamily;

use MyFamily\Traits\Presentable;

class Album extends Model
{
    use Presentable;

    protected $presenter = 'MyFamily\Presenters\Album';

    protected $fillable = ['name', 'description'];

    protected $casts = ['shared' => 'boolean'];

    public function photos()
    {
        return $this->morphMany( 'MyFamily\Photo', 'imageable' );
    }

    public function owner()
    {
        return $this->belongsTo( 'MyFamily\User' );
    }

    public function authorize()
    {
        $authorized = false;

        if ($this->shared) {
            $authorized = true;
        }

        return $authorized;
    }
}
