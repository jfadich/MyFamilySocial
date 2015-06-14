<?php namespace MyFamily\Repositories;

use MyFamily\ForumThread;
use MyFamily\Comment;
use Carbon\Carbon;
use JWTAuth;

class ThreadRepository extends Repository{

    /*
     * TagRepository
     */
    private $tagRepo;

    /*
     * Default includes
     */
    protected $eagerLoad =  ['owner', 'replies.owner'];

    /**
     * @param TagRepository $tags
     */
    public function __construct(TagRepository $tags)
    {
        $this->tagRepo = $tags;
    }

    /**
     * Return all threads
     *
     * @param int $count
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllThreads( $count = null )
    {
        return ForumThread::with( $this->eagerLoad )->paginate( $this->perPage( $count ) );
    }

    /**
     * Get threads in a category. Paginate by default
     *
     * @param $categoryId
     * @param null $count
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getThreadByCategory( $categoryId, $count = null )
    {
        return ForumThread::with( $this->eagerLoad )->where( 'category_id', '=',
            $categoryId )->paginate( $this->perPage( $count ) );
    }

    /**
     * Get a thread by id or slug
     *
     * @param $thread
     * @return mixed|null
     */
    public function getThread($thread)
    {
        if ( is_int( $thread ) ) {
            return ForumThread::with( $this->eagerLoad )->findOrFail( $thread );
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
        $reply->owner_id = JWTAuth::toUser()->id;
        $reply->body = $inputComment['comment'];

        $thread->replies()->save($reply);

        $thread->update( [ 'last_reply' => Carbon::now() ]);

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
            'owner_id'      => JWTAuth::toUser()->id,
        ]);

        if(array_key_exists('tags', $inputThread) && is_string($inputThread['tags']) )
            $this->saveTags( $inputThread[ 'tags' ], $thread);

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
        if ( isset( $inputThread[ 'category' ] ) ) {
            $inputThread[ 'category_id' ] = $inputThread[ 'category' ];
            unset( $inputThread[ 'category' ] );
        }

        if ( isset( $inputThread[ 'tags' ] ) && is_string( $inputThread[ 'tags' ] ) ) {
            $this->saveTags( $inputThread[ 'tags' ], $thread );
            unset( $inputThread[ 'tags' ]);
        }

        $thread->update( $inputThread);

        return $thread;
    }

}