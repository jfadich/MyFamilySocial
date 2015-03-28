<?php namespace MyFamily\Repositories;

use MyFamily\Album;

class AlbumRepository extends Repository
{
    public function create($album)
    {
        return Album::create( $album );
    }

    public function latest($count = 10)
    {
        return Album::latest()->take( $count );
    }

    public function findOrFail($album)
    {
        return Album::findOrFail( $album );
    }

    public function all()
    {
        return Album::all();
    }
}