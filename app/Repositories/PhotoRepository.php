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
     * @return Photo
     * @internal param $album_id
     */
    public function create($image)
    {
        $photo = Photo::create( [
            'file_name' => uniqid() . '-' . $image->getClientOriginalName(),
            'owner_id' => Auth::id(),
            'name'      => $image->getClientOriginalName()
        ] );

        Storage::put( $photo->storagePath( 'full' ) . '/full-' . $photo->file_name,
            File::get( $image->getRealPath() ) );

        return $photo;
    }

    public function getPhoto($id, $size = null)
    {
        if (is_null( $size )) {
            $size = 'full';
        }

        $photo     = Photo::findOrFail( $id );
        $file_name = "{$size}-{$photo->file_name}";
        $file_path = $photo->storagePath( $size ) . "/{$file_name}";

        if (Storage::exists( $file_path )) {
            return Storage::get( $file_path );
        }

        $original = Storage::get( $photo->storagePath( 'full' ) . "/full-{$photo->file_name}" );

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