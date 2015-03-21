<?php namespace MyFamily\Repositories;

use MyFamily\Album;
use MyFamily\Photo;
use Auth;
use Storage;
use File;
use Image;

class PhotoRepository extends Repository
{
    /**
     * @param $image
     * @param $album_id
     * @return Photo
     */
    public function create($image, $album_id)
    {
        $photo            = new Photo();
        $photo->file_name = uniqid() . '-' . $image->getClientOriginalName();
        $photo->owner_id  = Auth::id();
        $photo->name      = $image->getClientOriginalName();

        $album = Album::findOrFail( $album_id );

        $album->photos()->save( $photo );

        Storage::put( $photo->storagePath() . '/full/full-' . $photo->file_name, File::get( $image->getRealPath() ) );

        return $photo;
    }

    public function getPhoto($id, $size = null)
    {
        if (is_null( $size )) {
            $size = 'full';
        }

        $photo     = Photo::findOrFail( $id );
        $file_name = "{$size}-{$photo->file_name}";
        $file_path = $photo->storagePath() . "/{$size}/{$file_name}";

        if (Storage::exists( $file_path )) {
            return Storage::get( $file_path );
        }

        $original = Storage::get( $photo->storagePath() . "/full/full-{$photo->file_name}" );

        $image    = Image::make( $original );
        $tmp_path = storage_path( 'tmp/' ) . "{$file_name}";
        $this->resize( $size, $image )->save( $tmp_path );
        Storage::put( $file_path, File::get( $tmp_path ) );

        return File::get( $tmp_path );
    }

    private function resize($size, $image)
    {
        switch ($size) {
            case 'small':
                return $image->fit( 50 );

            case 'thumb':
                return $image->fit( 110 );

            case 'medium':
                return $image->fit( 550 );

            default:
                throw \Exception( 'Invalid image size' );
        }
    }
}