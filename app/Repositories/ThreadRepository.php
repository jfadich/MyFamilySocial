<?php namespace MyFamily\Repositories;

use MyFamily\Comment;
use MyFamily\ForumThread;
use MyFamily\Tag;
use MyFamily\Traits\Slugify;

class ThreadRepository extends Repository{

    use Slugify;

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
        return ForumThread::with('owner', 'replies.owner')->fresh()->paginate($pageCount);
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
                return $threadById->with('owner')->first();
        }

        return ForumThread::with('owner')->where('slug', '=', $thread)->with('replies.owner')->first();
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
     * Create a new thread
     *
     * @param $inputThread
     * @return ForumThread
     */
    public function createThread($inputThread)
    {
        $thread = new ForumThread();
        $thread->body = $inputThread['body'];
        $thread->title = $inputThread['title'];
        $thread->category_id = $inputThread['category'];
        $thread->owner_id = \Auth::id();

        $thread->slug = $this->slugify($thread->title);
        $thread->save();

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
     * @return ForumThread
     * @internal param $inputThread
     */
    public function updateThread(ForumThread $thread, $inputThread)
    {
        $thread->update([
            'title' => $inputThread['title'],
            'body'  => $inputThread['body'],
            'category_id' => $inputThread['category']
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