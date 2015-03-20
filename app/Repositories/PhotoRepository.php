<?php namespace MyFamily\Repositories;

use MyFamily\Album;
use MyFamily\Photo;
use Auth;
use Storage;
use File;

class PhotoRepository extends Repository
{
    /**
     * @param $image
     * @return Photo
     */
    public function create($image)
    {
        $photo = Photo::create( [
            'file_name' => uniqid() . '-' . $image->getClientOriginalName(),
            'owner_id'  => Auth::id(),
            'name'      => $image->getClientOriginalName(),
            'album'     => 1
        ] );

        Storage::put( $photo->storagePath() . '/originals/' . $photo->file_name, File::get( $image->getRealPath() ) );

        return $photo;
    }

    public function getPhoto($id, $size = null)
    {
        $photo = Photo::find( $id );

// Set header with http://image.intervention.io/api/response
        return Storage::get( $photo->storagePath() . '/originals/' . $photo->file_name );
    }
}