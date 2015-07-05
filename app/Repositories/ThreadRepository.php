<?php namespace MyFamily\Repositories;

use MyFamily\ForumThread;
use MyFamily\Comment;
use Carbon\Carbon;
use JWTAuth;

class ThreadRepository extends Repository
{
    protected $defaultOrder = [ 'last_reply', 'desc' ];

    /*
     * TagRepository
     */
    protected $tagRepo;

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
        return ForumThread::with( $this->eagerLoad )->orderBy( \DB::raw( '(sticky = 1)' ),
            'DESC' )->paginate( $this->perPage( $count ) );
    }

    /**
     * Get threads in a category. Paginate by default
     *
     * @param $category
     * @param null $count
     * @param null $order
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getThreadByCategory( $category, $count = null, $order = null )
    {
        if ( $order === null ) {
            list( $orderCol, $orderBy ) = $this->defaultOrder;
        } else {
            list( $orderCol, $orderBy ) = $order;
        }

        return $category->threads()
            ->with( $this->eagerLoad )
            ->orderBy( \DB::raw( '(sticky = 1)' ), 'DESC' )
            ->orderBy( $orderCol, $orderBy )
            ->paginate( $this->perPage( $count ) );
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
        $inputComment = $this->stripHtml( $inputComment, [ 'comment' ] );

        $reply = new Comment();
        $reply->owner()->associate( JWTAuth::toUser() );
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
        $inputThread = $this->stripHtml( $inputThread, [ 'body', 'title' ] );

        $thread  = ForumThread::create([
            'body'          =>  $inputThread['body'],
            'title'         => $inputThread['title'],
            'category_id'   => $inputThread['category'],
            'owner_id'      => JWTAuth::toUser()->id,
            'last_reply' => Carbon::now()
        ]);

        if ( array_key_exists( 'sticky', $inputThread ) && \UAC::canCurrentUser( 'GlueForumThread' ) ) {
            $thread->sticky = (bool)$inputThread[ 'sticky' ];
        }

        if(array_key_exists('tags', $inputThread) && is_string($inputThread['tags']) )
            $this->saveTags( $inputThread[ 'tags' ], $thread);

        $thread->save();

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
        $inputThread = $this->stripHtml( $inputThread, [ 'body', 'title' ] );

        if ( isset( $inputThread[ 'category' ] ) ) {
            $inputThread[ 'category_id' ] = $inputThread[ 'category' ];
            unset( $inputThread[ 'category' ] );
        }

        if ( isset( $inputThread[ 'tags' ] ) && is_string( $inputThread[ 'tags' ] ) ) {
            $this->saveTags( $inputThread[ 'tags' ], $thread );
            unset( $inputThread[ 'tags' ]);
        }

        if ( array_key_exists( 'sticky', $inputThread ) && \UAC::canCurrentUser( 'GlueForumThread' ) )
            $thread->sticky = (bool)$inputThread[ 'sticky'];

        $thread->update( $inputThread);

        return $thread;
    }

}