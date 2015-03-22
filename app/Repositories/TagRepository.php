<?php namespace MyFamily\Repositories;

use MyFamily\Tag;

class TagRepository extends Repository
{

    public function find($tag)
    {
        return Tag::where( 'name', '=', $tag )->firstOrFail();
    }

    public function findBySlug($tag)
    {
        return Tag::where( 'slug', '=', $tag )->firstOrFail();
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
        if ( $tag == null )
            $tag = Tag::create( ['name' => $inputTag, 'slug' => $this->slugify( $inputTag )] );

        return $tag;
    }

    /**
     * List all threads by the given tag
     * @param $tag
     * @param int $pageCount
     * @return
     */
    public function forumThreads($tag, $pageCount = 10)
    {
        $tag = Tag::where( 'slug', '=', $tag )->firstOrFail();

        return $tag->forumThreads()->fresh()->paginate($pageCount);
    }

}