<?php namespace MyFamily\Repositories;

use MyFamily\Comment;
use MyFamily\ForumThread;
use MyFamily\Traits\Slugify;

class ForumRepository extends Repository{

    use Slugify;

    /**
     * Return all threads
     *
     * @param int $pageCount
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllThreads($pageCount = 10)
    {
        return ForumThread::with('category', 'owner')->paginate($pageCount);
    }

    /**
     * Get threads in a category. Paginate by default
     * @param $categoryId
     * @param int $pageCount
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getThreadByCategory($categoryId, $pageCount = 10)
    {
        return ForumThread::with('owner')->where('category_id', '=', $categoryId)->paginate($pageCount);
    }

    /**
     * Get a thread by id or slug
     *
     * @param $thread
     * @return mixed|null
     */
    public function getThread($thread)
    {
        if(is_numeric($thread))
        {
            $threadById = ForumThread::find($thread);
            if($threadById != null)
                return $threadById->first();
        }

        return ForumThread::where('slug', '=', $thread)->with('replies')->first();
    }

    /**
     * Create a new thread
     *
     * @param $inputThread
     * @return ForumThread
     */
    public function createThread($inputThread)
    {
        $thread = new ForumThread();
        $thread->body = $inputThread['message'];
        $thread->title = $inputThread['title'];
        $thread->category_id = $inputThread['category'];
        $thread->owner_id = \Auth::id();

        $thread->slug = $this->cleanSlug($thread->title);
        $thread->save();
        return $thread;
    }

    /**
     * Create a reply on a given thread
     *
     * @param $thread
     * @param $inputComment
     * @return Comment
     */
    public function createThreadReply($thread, $inputComment)
    {
        $reply = new Comment();
        $reply->owner_id = \Auth::id();
        $reply->body = $inputComment['comment'];
        $thread->replies()->save($reply);
        return $reply;
    }

}