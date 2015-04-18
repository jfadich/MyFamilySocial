<?php namespace MyFamily\Repositories;

use MyFamily\ForumThread;
use MyFamily\Comment;

class ThreadRepository extends Repository{

    private $tagRepo;

    public function __construct(TagRepository $tags)
    {
        $this->tagRepo = $tags;
    }

    /**
     * Return all threads
     *
     * @param int $pageCount
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllThreads($pageCount = 10)
    {
        return ForumThread::with( 'owner', 'replies.owner' )->latest()->paginate( $pageCount );
    }

    /**
     * Get threads in a category. Paginate by default
     *
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
                return $threadById->with('owner')->firstOrFail();
        }

        return ForumThread::with('owner')->where('slug', '=', $thread)->with('replies.owner')->firstOrFail();
    }

    /**
     * Get a list of threads tagged with given tag
     *
     * @param $tag
     * @return mixed
     */
    public function getThreadsByTag($tag)
    {
        return $this->tagRepo->forumThreads($tag);
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

    /**
     * Create a new thread
     *
     * @param $inputThread
     * @return ForumThread
     */
    public function createThread($inputThread)
    {
        $thread  = ForumThread::create([
            'body'          =>  $inputThread['body'],
            'title'         => $inputThread['title'],
            'category_id'   => $inputThread['category'],
            'owner_id'      => \Auth::id(),
            'slug'          => $this->slugify($inputThread['title'])
        ]);

        $tags = explode(',', $inputThread['tags']);
        foreach($tags as $tag)
        {
            $tag = $this->tagRepo->findOrCreate($tag);
            if($tag)
                $thread->tags()->save($tag);
        }

        return $thread;
    }

    /**
     * Update an existing thread
     *
     * @param ForumThread $thread
     * @param $inputThread
     * @return ForumThread
     */
    public function updateThread(ForumThread $thread, $inputThread)
    {
        $thread->update([
            'title'         => $inputThread['title'],
            'body'          => $inputThread['body'],
            'category_id'   => $inputThread['category']
        ]);

        $tags = explode(',', $inputThread['tags']);
        $tagIds = [];

        foreach($tags as $tag)
        {
            $tag = $this->tagRepo->findOrCreate($tag);
            if($tag)
                $tagIds[] = $tag->id;
        }

        $thread->tags()->sync($tagIds);

        return $thread;
    }

}