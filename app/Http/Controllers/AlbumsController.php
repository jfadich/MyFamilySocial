<?php namespace MyFamily\Http\Controllers;

use MyFamily\Http\Requests\Photos\CreateAlbumRequest;
use MyFamily\Http\Requests\Photos\EditAlbumRequest;
use Pictures;

class AlbumsController extends Controller
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
        return view( 'photos.listAlbums', [
            'albums' => Pictures::albums()->select( '*' )->paginate( 4 )
        ] );
    }

    /**
     * Display the specified resource.
     *
     * @param $album
     * @return Response
     * @internal param $photo
     * @internal param null $size
     * @internal param int $id
     */
    public function show($album)
    {
        return view( 'photos.gallery', ['album' => $album] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view( 'photos.createAlbum' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAlbumRequest $request
     * @return Response
     */
    public function store(CreateAlbumRequest $request)
    {
        $album = Pictures::albums()->create( $request->all() );

        return redirect( $album->present()->url );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $album
     * @return Response
     */
    public function edit($album)
    {
        return view( 'photos.editAlbum', ['album' => $album] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $album
     * @param EditAlbumRequest $request
     * @return Response
     */
    public function update($album, EditAlbumRequest $request)
    {
        Pictures::albums()->update( $album, $request->all() );

        return redirect( $album->present()->url );
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
