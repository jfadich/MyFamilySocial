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
     * @param null $owner
     * @return Photo
     * @internal param $album_id
     */
    public function create($image, $owner = null)
    {
        if (is_null( $owner )) {
            $owner = Auth::id();
        }

        $file = Image::make( File::get( $image->getRealPath() ) )->save( $image->getRealPath() )->orientate();

        $metadata = $file->exif();

        if (!is_null( $metadata )) {
            $metadata = json_encode( $metadata );
        }

        $photo = Photo::create( [
            'file_name' => uniqid() . '-' . $image->getClientOriginalName(),
            'owner_id'  => $owner,
            'name'      => $image->getClientOriginalName(),
            'metadata'  => $metadata
        ] );

        Storage::put( $photo->storagePath( 'full' ) . '/full-' . $photo->file_name, $file );

        return $photo;
    }

    /**
     * Get the file for the given photo
     *
     * @param $id
     * @param null $size
     * @return mixed
     * @throws
     */
    public function getPhoto($id, $size = null)
    {
        if (is_null( $size )) {
            $size = 'full';
        }

        $photo     = Photo::findOrFail( $id );
        $file_name = "{$size}-{$photo->file_name}";
        $file_path = $photo->storagePath( $size ) . "/{$file_name}";

        if (Storage::exists( $file_path )) {
            //    return Storage::get( $file_path );
        }

        $original = Storage::get( $photo->storagePath( 'full' ) . "/full-{$photo->file_name}" );

        $image    = Image::make( $original );
        $tmp_path = storage_path( 'tmp/' ) . "{$file_name}";
        $this->resize( $size, $image )->save( $tmp_path, 70 );
        Storage::put( $file_path, File::get( $tmp_path ) );

        return File::get( $tmp_path );
    }

    public function latest($count = 10)
    {
        return Photo::latest()->take( $count );
    }

    private function resize($size, $image)
    {
        switch ($size) {
            case 'small':
                return $image->fit( 50 );

            case 'thumb':
                return $image->fit( 150 );

            case 'medium':
                return $image->fit( 390 );

            case 'large':
                return $image->resize( 1920, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                } );

            default:
                throw \Exception( 'Invalid image size' );
        }
    }
}