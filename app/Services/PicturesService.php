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

    /**
     * Set relations to eager load and return the photo repository
     *
     * @param null $eagerLoad
     * @return PhotoRepository
     */
    public function photos( $eagerLoad = null )
    {
        if ( $eagerLoad !== null ) {
            $this->photosRepo->setEagerLoad( $eagerLoad );
        }

        return $this->photosRepo;
    }

    /**
     * Set relations to eager load and return the album repository
     *
     * @param null $eagerLoad
     * @return AlbumRepository
     */
    public function albums( $eagerLoad = null)
    {
        if ( $eagerLoad !== null )
            $this->albumsRepo->setEagerLoad( $eagerLoad);

        return $this->albumsRepo;
    }

}