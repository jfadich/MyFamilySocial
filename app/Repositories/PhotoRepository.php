<?php namespace MyFamily\Repositories;

use Chumper\Zipper\Zipper;
use MyFamily\Comment;
use MyFamily\Photo;
use MyFamily\Model;
use Storage;
use File;
use Image;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PhotoRepository extends Repository
{
    protected $tagRepo;

    protected $polymorphic = 'imageable';

    /**
     * @param TagRepository $tagRepo
     * @param Zipper $zipper
     */
    function __construct( TagRepository $tagRepo, Zipper $zipper )
    {
        $this->zipper = $zipper;
        $this->tagRepo = $tagRepo;
    }

    /**
     * @param $image
     * @param $album
     * @param null $owner
     * @return Photo
     * @internal param $album_id
     */
    public function create($image, $album, $owner = null)
    {
        if ( $owner === null ) {
            $owner = \JWTAuth::toUser()->id;
        }

        $file = Image::make( $image );

        $metadata = $file->exif();
        $file->orientate()->save( $image->getPathname(), 100 );
        if (!is_null( $metadata )) {
            $metadata = json_encode( $metadata );
        }

        $photo = Photo::create( [
            'file_name'      => uniqid() . '-' . $image->getClientOriginalName(),
            'owner_id'       => $owner,
            'name'           => $image->getClientOriginalName(),
            'imageable_type' => get_class( $album ),
            'imageable_id'   => $album->id,
            'metadata'       => $metadata
        ] );

        Storage::put( $photo->storagePath( 'full' ) . '/full-' . $photo->file_name, (string)$file );

        return $photo;
    }

    public function findPhoto($id)
    {
        return Photo::with( $this->eagerLoad )->findOrFail( $id );
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

        $photo = $this->findPhoto( $id );
        $file_name = "{$size}-{$photo->file_name}";
        $file_path = $photo->storagePath( $size ) . "/{$file_name}";

        if (Storage::exists( $file_path )) {
            return Storage::get( $file_path );
        }

        $original_path = $photo->storagePath( 'full' ) . "/full-{$photo->file_name}";
        if ( !Storage::exists( $original_path ) ) {
            throw new NotFoundHttpException( 'Photo not found' );
        }

        $original = Storage::get( $original_path );

        $image    = Image::make( $original );
        $tmp_path = storage_path( "tmp/$file_name" );
        $this->resize( $size, $image )->save( $tmp_path, 70 );
        Storage::put( $file_path, File::get( $tmp_path ) );

        return File::get( $tmp_path );
    }

    /**
     * @param $photo
     * @param $comment
     * @return Comment
     */
    public function createReply($photo, $comment)
    {
        $reply           = new Comment();
        $reply->owner_id = \JWTAuth::toUser()->id;;
        $reply->body     = $comment[ 'comment' ];

        $photo->comments()->save( $reply );

        return $reply;
    }

    /**
     * Update an existing thread
     *
     * @param Photo $photo
     * @param $inputPhoto
     * @return ForumThread
     */
    public function updatePhoto(Photo $photo, $inputPhoto)
    {
        if ( isset( $inputPhoto[ 'tags' ] ) ) {
            $this->saveTags( $inputPhoto[ 'tags' ], $photo );
            unset( $inputPhoto[ 'tags' ] );
        }

        $photo->update( $inputPhoto );

        return $photo;
    }

    public function latest( $count = null )
    {
        return Photo::with( $this->eagerLoad )->latest()->paginate( $this->perPage( $count ) );
    }

    public function getZip( $photos )
    {
        $name       = 'photos-' . uniqid();
        $tmp_folder = storage_path( "tmp/" . uniqid() );
        mkdir( $tmp_folder );

        $photos->each( function ( $photo ) use ( $tmp_folder ) {
            $relativePath = $photo->storagePath( 'full' ) . "/full-{$photo->file_name}";

            if ( Storage::exists( $relativePath ) ) {
                file_put_contents( $tmp_folder . '/' . $photo->file_name, Storage::get( $relativePath ) );
            }
        } );

        $zip = $this->zipper->make( "../storage/tmp/$name.zip" );
        $zip->add( glob( $tmp_folder . '/*' ) )->close();

        return storage_path( "tmp/$name.zip" );
    }

    private function resize($size, $image)
    {
        switch ($size) {
            case 'small':
                return $image->fit( 50 );

            case 'thumb':
                return $image->fit( 120 );

            case 'medium':
                return $image->fit( 340 );

            case 'card':
                return $image->fit( 765 );

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