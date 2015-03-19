<?php namespace MyFamily\Repositories;

use Symfony\Component\HttpFoundation\File\File;
use MyFamily\Album;
use MyFamily\Photo;
use Auth;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotoRepository extends Repository
{
    /**
     * @param $image
     * @param $album
     * @return Photo
     */
    public function create(UploadedFile $image)
    {
        $photo                = new Photo();
        $photo->file_name     = uniqid() . '.' . $image->getClientOriginalExtension();
        $photo->owner_id      = Auth::id();
        $photo->original_name = time() . '-' . $image->getClientOriginalName();
        $photo->name          = $image->getClientOriginalName();
        $photo->album         = 1;
        $photo->save();

        $path = storage_path() . '/app/' . $photo->storagePath() . '/originals';

        if (!file_exists( $path )) {
            mkdir( $path, 0777, true );
        }
        $image->move( $path, $photo->original_name );


        return $photo;
    }

    public function getPhoto($id, $size = null)
    {

    }
}