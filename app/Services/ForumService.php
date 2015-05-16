<?php namespace MyFamily\Services;

use MyFamily\Repositories\ThreadRepository;
use MyFamily\Repositories\ForumCategoryRepository;

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

    public function threads($eagerLoad = null)
    {
        if(!is_null($eagerLoad))
            $this->threadRepo->setEagerLoad($eagerLoad);

        return $this->threadRepo;
    }

    public function categories($eagerLoad = null)
    {
        if(!is_null($eagerLoad))
            $this->threadRepo->setEagerLoad($eagerLoad);

        return $this->categoryRepo;
    }

}