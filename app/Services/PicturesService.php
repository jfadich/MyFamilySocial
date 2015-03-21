<?php namespace MyFamily\Services;

use MyFamily\Repositories\PhotoRepository;

class PicturesService
{

    private $photosRepo;

    /**
     * @param PhotoRepository $photos
     * @internal param ThreadRepository $threadRepo
     */
    function __construct(PhotoRepository $photos)
    {
        $this->photosRepo = $photos;
    }

    public function photos()
    {
        return $this->photosRepo;
    }

    public function albums()
    {
        //return $this->albumsRepo;
    }

}