<?php namespace MyFamily\Repositories;

use MyFamily\Album;
use MyFamily\User;

class AlbumRepository extends Repository
{
    /*
     * TagRepository
     */
    protected $tagRepo;

    /**
     * @param TagRepository $tags
     */
    function __construct(TagRepository $tags)
    {
        $this->tagRepo = $tags;
    }

    /**
     * @param null $count
     * @return \Illuminate\Database\Collection
     */
    public function getAllAlbums( $count = null )
    {
        return Album::with( $this->eagerLoad )->latest()->paginate( $this->perPage( $count ) );
    }

    /**
     * @param $album
     * @param $useSlug
     * @return Album
     */
    public function getAlbum( $album, $useSlug = true )
    {
        if ( is_int( $album ) && !$useSlug ) {
            return Album::with( $this->eagerLoad )->findorFail( $album );
        }

        return Album::with( $this->eagerLoad )->where( 'slug', '=', $album )->firstorFail();
    }

    /**
     * @param User $user
     * @param null $count
     * @param $order
     * @return mixed
     */
    public function getUserAlbums( User $user, $count = null, $order = null )
    {
        if ( $order === null ) {
            list( $orderCol, $orderBy ) = $this->defaultOrder;
        } else {
            list( $orderCol, $orderBy ) = $order;
        }

        return $user->albums()
            ->with( $this->eagerLoad )
            ->orderBy( $orderCol, $orderBy )
            ->paginate( $this->perPage( $count ) );
    }

    /**
     * @param $inputAlbum
     * @return Album
     */
    public function create($inputAlbum)
    {
        $album = Album::create( [
            'name'        => $inputAlbum[ 'name' ],
            'description' => isset( $inputAlbum[ 'description' ] ) ? $inputAlbum[ 'description' ] : '',
            'owner_id'    => \Auth::id(),
            'shared'      => (boolean)$inputAlbum[ 'shared' ],
        ] );

        if (isset( $inputAlbum[ 'tags' ] )) {
            $this->saveTags( $inputAlbum[ 'tags' ], $album );
        }

        return $album;
    }

    /**
     * @param int $count
     * @return mixed
     */
    public function latest( $count = null)
    {
        return Album::with( $this->eagerLoad )->latest()->take( $this->perPage( $count ) );
    }

    /**
     * @param $album
     * @return mixed
     */
    public function findOrFail($album)
    {
        return Album::with( $this->eagerLoad )->findOrFail( $album );
    }

    /**
     * @param $album
     * @param $updatedAlbum
     * @return mixed
     */
    public function update($album, $updatedAlbum)
    {

        $album->update( $updatedAlbum );

        if ( isset( $updatedAlbum[ 'tags' ] ) && is_string( $updatedAlbum[ 'tags' ] ) ) {
            $this->saveTags( $updatedAlbum[ 'tags' ], $album);
        }

        return $album;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection[]
     */
    public function all()
    {
        return Album::with( $this->eagerLoad )->all();
    }
}