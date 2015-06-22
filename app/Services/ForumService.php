<?php namespace MyFamily\Services;

use MyFamily\Repositories\ForumCategoryRepository;
use MyFamily\Repositories\ThreadRepository;

class ForumService {

    private $threadRepo;

    private $categoryRepo;

    /**
     * @param ThreadRepository $threadRepo
     * @param ForumCategoryRepository $categoryRepo
     */
    function __construct(ThreadRepository $threadRepo, ForumCategoryRepository $categoryRepo)
    {
        $this->threadRepo = $threadRepo;

        $this->categoryRepo = $categoryRepo;

    }

    /**
     * Set relations to eager load and return the thread repository
     *
     * @param null $eagerLoad
     * @return ThreadRepository
     */
    public function threads($eagerLoad = null)
    {
        if ( $eagerLoad !== null )
            $this->threadRepo->setEagerLoad($eagerLoad);

        return $this->threadRepo;
    }

    /**
     * Set relations to eager load and return the category repository
     *
     * @param null $eagerLoad
     * @return ForumCategoryRepository
     */
    public function categories($eagerLoad = null)
    {
        if ( $eagerLoad !== null )
            $this->threadRepo->setEagerLoad($eagerLoad);

        return $this->categoryRepo;
    }

    public function post_count()
    {
        return \DB::select( "SELECT count(*) as posts FROM comments WHERE commentable_type = ?",
            [ 'MyFamily\ForumThread' ] )[ 0 ]->posts;
    }

}