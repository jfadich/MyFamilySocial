<?php namespace MyFamily\Services;

use MyFamily\Repositories\AlbumRepository;
use MyFamily\Repositories\PhotoRepository;

class PicturesService
{

    private $photosRepo;

    /**
     * @param PhotoRepository $photos
     * @param AlbumRepository $albums
     * @internal param ThreadRepository $threadRepo
     */
    function __construct(PhotoRepository $photos, AlbumRepository $albums)
    {
        $this->photosRepo = $photos;

        $this->albumsRepo = $albums;
    }

    public function photos()
    {
        return $this->photosRepo;
    }

    public function albums()
    {
        return $this->albumsRepo;
    }

}