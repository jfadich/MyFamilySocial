<?php namespace MyFamily\Repositories;

use MyFamily\ForumThread;
use MyFamily\Comment;

class ThreadRepository extends Repository{

    private $tagRepo;

    protected $eagerLoad =  ['owner', 'replies.owner'];

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
        return ForumThread::with( $this->eagerLoad )->latest()->paginate( $pageCount );
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
        return ForumThread::with( $this->eagerLoad )->where('category_id', '=', $categoryId)->paginate($pageCount);
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
            if( $threadById !== null )
                return $threadById->with('owner')->firstOrFail();
        }

        return ForumThread::with( $this->eagerLoad )->where('slug', '=', $thread)->with('replies.owner')->firstOrFail();
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
        $reply->owner_id = \JWTAuth::toUser();
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
            'owner_id'      => \JWTAuth::toUser(),
            'slug'          => $this->slugify($inputThread['title'])
        ]);

        if(array_key_exists('tags', $inputThread))
        {
            $tags = explode(',', $inputThread['tags']);
            foreach($tags as $tag)
            {
                $tag = $this->tagRepo->findOrCreate($tag);
                if($tag)
                    $thread->tags()->save($tag);
            }
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

        !isset($inputThread['title']) ?: $thread->title = $inputThread['title'];
        !isset($inputThread['body']) ?: $thread->title = $inputThread['body'];
        !isset($inputThread['category_id']) ?: $thread->title = $inputThread['category_id'];

        $thread->save();

        if(isset($inputThread['tags']))
        {
            $tags = explode(',', $inputThread['tags']);
            $tagIds = [];

            foreach($tags as $tag)
            {
                $tag = $this->tagRepo->findOrCreate($tag);
                if($tag)
                    $tagIds[] = $tag->id;
            }

            $thread->tags()->sync($tagIds);
        }


        return $thread;
    }

}