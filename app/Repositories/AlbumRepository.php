<?php namespace MyFamily\Repositories;

use MyFamily\Album;

class AlbumRepository extends Repository
{
    protected $tagRepo;

    /**
     * @param TagRepository $tags
     */
    function __construct(TagRepository $tags)
    {
        $this->tagRepo = $tags;
    }

    public function getAllAlbums()
    {
        return Album::latest()->paginate(10);
    }

    public function getAlbum($album, $useSlug)
    {
        if (is_numeric( $album ) && !$useSlug) {
            $threadById = Album::findorFail( $album );
            if ( $threadById !== null) {
                return $threadById->with( 'owner' )->first();
            }
        }

        return Album::with( 'owner' )->where( 'slug', '=', $album )->firstorFail();
    }

    public function create($inputAlbum)
    {
        $album = Album::create( [
            'name'        => $inputAlbum[ 'name' ],
            'description' => $inputAlbum[ 'description' ],
            'owner_id' => isset( $inputAlbum[ 'owner_id' ] ) ? $inputAlbum[ 'owner_id' ] : \Auth::id(),
            'shared'      => isset( $inputAlbum[ 'shared' ] ),
        ] );

        if (isset( $inputAlbum[ 'tags' ] )) {
            $this->saveTags( $inputAlbum[ 'tags' ], $album );
        }

        return $album;
    }

    public function latest($count = 10)
    {
        return Album::latest()->take( $count );
    }

    public function findOrFail($album)
    {
        return Album::findOrFail( $album );
    }

    public function update($album, $updatedAlbum)
    {
        $album->update( [
            'name'        => $updatedAlbum[ 'name' ],
            'description' => $updatedAlbum[ 'description' ],
            'shared'      => isset( $updatedAlbum[ 'shared' ] )
        ] );

        $tags   = explode( ',', $updatedAlbum[ 'tags' ] );
        $tagIds = [];

        foreach ($tags as $tag) {
            $tag = $this->tagRepo->findOrCreate( $tag );
            if ($tag) {
                $tagIds[ ] = $tag->id;
            }
        }

        $album->tags()->sync( $tagIds );

        return $album;
    }

    public function all()
    {
        return Album::all();
    }
}