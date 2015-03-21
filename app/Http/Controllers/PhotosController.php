<?php namespace MyFamily\Http\Controllers;

use MyFamily\Repositories\PhotoRepository;
use MyFamily\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MyFamily\Http\Requests;
use MyFamily\Album;
use Pictures;
use Image;


class PhotosController extends Controller
{

    function __construct()
    {
        $this->middleware( 'auth' );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
        $photo = Pictures::photos()->create( $request->file( 'photo' ) );

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
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
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
