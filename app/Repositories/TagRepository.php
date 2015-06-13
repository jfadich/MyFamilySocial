<?php namespace MyFamily\Repositories;

use MyFamily\Tag;

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

        $tag = Tag::where( 'name', '=', $inputTag )->first();
        if ( $tag === null )
            $tag = Tag::create( ['name' => $inputTag] );

        return $tag;
    }

    /**
     * List all threads by the given tag
     *
*@param $tag
     * @param int $count
     * @return
     */
    public function forumThreads( $tag, $count = null)
    {
        $tag = Tag::where( 'slug', '=', $tag )->firstOrFail();

        return $tag->forumThreads()->latest()->paginate( $count );
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