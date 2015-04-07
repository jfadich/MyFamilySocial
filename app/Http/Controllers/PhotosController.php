<?php namespace MyFamily\Http\Controllers;

use MyFamily\Http\Requests\Photos\CreatePhotoCommentRequest;
use MyFamily\Repositories\PhotoRepository;
use MyFamily\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MyFamily\Http\Requests;
use MyFamily\Album;
use Pictures;
use Image;
use Flash;


class PhotosController extends Controller
{

    function __construct()
    {
        $this->middleware( 'auth' );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view( 'photos.singleUploadForm' );
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
            return response()->json( ['error' => 'Album not provided'] );
        }

        if ($request->hasFile( 'photo' )) {
            $photo = Pictures::photos()->create( $request->file( 'photo' ),
                Pictures::albums()->findOrFail( $request->get( 'album_id' ) ) );

        } else {
            return response()->json( ['error' => 'File to large'], 422 );
        }

        dd( $photo );
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
     * Display the specified resource.
     *
     * @param $photo
     * @return Response
     */
    public function show($photo)
    {
        return view( 'photos.showPhoto', ['photo' => $photo] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    public function addReply($photo, CreatePhotoCommentRequest $request)
    {
        $reply = Pictures::photos()->createReply( $photo, $request->all() );

        Flash::success( 'Reply added successfully' );

        $replies = $photo->comments()->paginate( 10 );
        $url     = $photo->present()->url . '?page=' . $replies->lastPage() . '#comment-' . $reply->id;

        return redirect( $url );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
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
