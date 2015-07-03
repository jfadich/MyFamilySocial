<?php namespace MyFamily\Http\Controllers;

use MyFamily\Http\Requests\Photos\CreatePhotoCommentRequest;
use MyFamily\Http\Requests\Photos\EditPhotoRequest;
use MyFamily\Transformers\CommentTransformer;
use MyFamily\Transformers\PhotoTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use MyFamily\Http\Requests;
use MyFamily\Errors;
use MyFamily\Photo;
use Pictures;
use Image;

class PhotosController extends ApiController
{
    protected $photoTransformer;

    protected $availableIncludes = [ 'owner', 'comments', 'parent', 'tags' ];

    protected $eagerLoad = [ 'owner', 'album' ];

    function __construct( PhotoTransformer $photoTransformer, Manager $fractal, Request $request )
    {
        parent::__construct( $fractal, $request );

        $this->photoTransformer = $photoTransformer;
        $this->middleware( 'auth', [ 'except' => 'showPhoto' ] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (!$request->has( 'album_id' )) {
            return $this->respondUnprocessableEntity( 'Album not provided' );
        }

        if ($request->hasFile( 'photo' )) {
            $photo = Pictures::photos()->create( $request->file( 'photo' ),
                Pictures::albums()->findOrFail( $request->get( 'album_id' ) ) );
        } else {
            return $this->setErrorCode( Errors::INVALID_ENTITY )->respondUnprocessableEntity( 'Invalid File' );
        }

        return $this->respondWithItem( $photo, $this->photoTransformer );
    }

    /**
     * @param $photo
     * @return mixed
     */
    public function show( $photo )
    {
        return $this->respondWithItem( $photo, $this->photoTransformer );
    }

    public function showBy( $type, $id )
    {
        $parent = Pictures::photos()->findByType( $type, $id );
        $photos = Pictures::photos()->getBy( $parent->first(), \Input::get( 'limit' ), \Input::get( 'order' ) );

        return $this->respondWithCollection( $photos, $this->photoTransformer );
    }


    /**
     * Display the specified resource.
     *
     * @param $photo
     * @param null $size
     * @return Response
     * @internal param int $id
     */
    public function showPhoto($size, $photo)
    {
        $photo = Pictures::photos()->getPhoto( $photo, $size );

        return Image::make( $photo )->response();
    }

    /**
     * @param $photo
     * @param CreatePhotoCommentRequest $request
     * @param CommentTransformer $commentTransformer
     * @return mixed
     */
    public function addReply( $photo, CreatePhotoCommentRequest $request, CommentTransformer $commentTransformer )
    {
        $reply = Pictures::photos()->createReply( $photo, $request->all() );

        return $this->respondCreated( $reply, $commentTransformer );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Photo $photo
     * @param EditPhotoRequest $request
     * @return Response
     */
    public function update(Photo $photo, EditPhotoRequest $request)
    {
        $photo = Pictures::photos()->updatePhoto( $photo, $request->all() );

        return $this->respondWithItem( $photo, $this->photoTransformer, [ 'status' => 'success' ] );
    }

    /**
     *
     * @param Photo $photo
     * @param Request $request
     * @return mixed
     */
    public function tagUsers(Photo $photo, Request $request)
    {
        $user_ids = explode( ',', $request->get( 'user_tag' ) );

        $photo->tagged_users()->attach( $user_ids );

        return $this->respondWithItem( $photo, $this->photoTransformer, [ 'status' => 'success' ] );
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
