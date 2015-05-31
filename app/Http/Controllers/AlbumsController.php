<?php namespace MyFamily\Http\Controllers;

use Illuminate\Http\Request;
use League\Fractal\Manager;
use MyFamily\Http\Requests\Photos\CreateAlbumRequest;
use MyFamily\Http\Requests\Photos\EditAlbumRequest;
use MyFamily\Transformers\AlbumTransformer;
use Pictures;

class AlbumsController extends ApiController
{
    private $albumTransformer;

    protected $availableIncludes = [
        'owner' => 'owner',
        'photos' => 'photos',
    ];

    function __construct(AlbumTransformer $albumTransformer, Manager $fractal, Request $request)
    {
        parent::__construct($fractal, $request);
        $this->albumTransformer = $albumTransformer;
        $this->middleware( 'auth' );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->respondWithCollection(Pictures::albums()->getAllAlbums(), $this->albumTransformer);
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
        return $this->respondWithItem($album, $this->albumTransformer);
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
        $meta['status'] = 'success';

        return $this->respondWithItem($album, $this->albumTransformer, $meta);
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
        $album = Pictures::albums()->update( $album, $request->all() );

        $meta['status'] = 'success';

        return $this->respondWithItem($album, $this->threadTransformer, $this->albumTransformer, $meta);
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
