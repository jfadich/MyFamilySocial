<?php namespace MyFamily\Http\Controllers;

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
            'albums' => Pictures::albums()->latest( 10 )->
            with( [
                'photos' => function ($q) {
                    $q->latest()->take( 7 );
                }
            ] )->get()
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
        $album = Pictures::albums()->findOrFail( $album );

        return view( 'photos.gallery', ['album' => $album] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
