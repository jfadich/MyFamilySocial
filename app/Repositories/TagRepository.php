<?php namespace MyFamily\Repositories;

use MyFamily\Tag;
use MyFamily\Model;

class TagRepository extends Repository
{
    /**
     * @param $tag
     * @return \MyFamily\Tag
     */
    public function find( $tag )
    {
        return Tag::with( $this->eagerLoad )->where( 'name', '=', $tag )->firstOrFail();
    }

    /**
     * @param $tag
     * @return \MyFamily\Tag
     */
    public function findBySlug($tag)
    {
        return Tag::with( $this->eagerLoad )->where( 'slug', '=', $tag )->firstOrFail();
    }

    /**
     *  Search for a tag. If it doesn't exist, create it.
     *
     * @param $inputTag
     * @return static
     */
    public function findOrCreate($inputTag)
    {
        $inputTag = $tag = trim( $inputTag );

        if ( empty( $inputTag ) )
            return false;

        $tag = Tag::with( $this->eagerLoad )->where( 'name', '=', $inputTag )->first();
        if ( $tag === null )
            $tag = Tag::create( ['name' => $inputTag] );

        return $tag;
    }

    /**
     * List all threads by the given tag
     *
     * @param $tag
     * @param int $count
     * @return
     */
    public function forumThreads( $tag, $count = null)
    {
        $tag = Tag::with( $this->eagerLoad )->where( 'slug', '=', $tag )->firstOrFail();

        return $tag->forumThreads()->latest()->paginate( $count );
    }

    /**
     * List all photos by the given tag
     *
     * @param $tag
     * @param int $count
     * @param null $order
     * @return
     */
    public function photos( $tag, $count = null, $order = null )
    {
        $tag = Tag::with( $this->eagerLoad )->where( 'slug', '=', $tag )->firstOrFail();

        if ( $order === null ) {
            list( $orderCol, $orderBy ) = $this->defaultOrder;
        } else {
            list( $orderCol, $orderBy ) = $order;
        }

        return $tag->photos()
            ->orderBy( $orderCol, $orderBy )
            ->paginate( $this->perPage( $count ) );
    }

    public function getBy( Model $parent, $count = null, $order = null )
    {
        if ( !method_exists( $parent, 'tags' ) ) {
            throw new \Exception( "Tags method does not exist on model" );
        }

        if ( $order === null ) {
            list( $orderCol, $orderBy ) = $this->defaultOrder;
        } else {
            list( $orderCol, $orderBy ) = $order;
        }

        return $parent->tags()
            ->orderBy( $orderCol, $orderBy )
            ->paginate( $this->perPage( $count ) );
    }

    /**
     *
     * @param $tag
     * @return mixed
     */
    public function getTaggables($tag)
    {
        $taggables = $tag->forumThreads;
        $taggables = $taggables->merge( $tag->albums );
        $taggables = $taggables->merge( $tag->photos );

        return $taggables;
    }

}