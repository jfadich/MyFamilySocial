<?php namespace MyFamily\Services;

use MyFamily\Repositories\ThreadRepository;
use MyFamily\Repositories\ForumCategoryRepository;
use MyFamily\Repositories\TagRepository;

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

    public function threads()
    {
        return $this->threadRepo;
    }

    public function categories()
    {
        return $this->categoryRepo;
    }

}