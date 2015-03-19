<?php namespace MyFamily\Repositories;

use MyFamily\Album;

class AlbumRepository extends Repository
{
    public function create($album)
    {
        return Album::create( $album );
    }
}