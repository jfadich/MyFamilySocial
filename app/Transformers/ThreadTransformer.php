<?php namespace MyFamily\Transformers;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use League\Fractal\ParamBag;
use MyFamily\ForumThread;
use MyFamily\Repositories\CommentRepository;
use MyFamily\Repositories\TagRepository;

class ThreadTransformer extends Transformer {

    protected $availableIncludes = [
        'owner',
        'replies',
        'tags',
        'category'
    ];

    protected $permissions = [
        'edit'   => 'EditForumThread',
        'delete' => 'DeleteForumThread',
        'reply'  => 'CreateThreadReply'
    ];


    /**
     * @param UserTransformer $userTransformer
     * @param CommentTransformer $commentTransformer
     * @param TagTransformer $tagTransformer
     * @param CommentRepository $commentRepository
     * @param TagRepository $tagRepository
     */
    function __construct(
        UserTransformer $userTransformer,
        CommentTransformer $commentTransformer,
        TagTransformer $tagTransformer,
        CommentRepository $commentRepository,
        TagRepository $tagRepository
    )
    {
        $this->userTransformer          = $userTransformer;
        $this->commentTransformer       = $commentTransformer;
        $this->tagTransformer           = $tagTransformer;
        $this->commentRepository        = $commentRepository;
        $this->tags = $tagRepository;
    }

    /**
     * @param ForumThread $thread
     * @return array
     */
    public function transform(ForumThread $thread)
    {
        return [
            'id'             => $thread->id,
            'title'          => $thread->title,
            'body'           => $thread->body,
            'slug'           => $thread->slug,
            //'reply_count'    => $thread->replies()->count(),
            'created'        => $thread->created_at->timestamp,
            'freshness'      => $thread->last_reply !== null ? $thread->last_reply->timestamp : $thread->created_at->timestamp,
            'updated'        => $thread->updated_at->timestamp,
            'permissions'    => $this->getPermissions($thread)
        ];
    }

    /**
     * @param ForumThread $thread
     * @return \League\Fractal\Resource\Item
     */
    public function includeOwner(ForumThread $thread)
    {
        $owner = $thread->owner;

        return $this->item($owner, $this->userTransformer);
    }

    /**
     * @param ForumThread $thread
     * @param ParamBag $params
     * @return \League\Fractal\Resource\Collection
     * @throws \Exception
     * @throws \MyFamily\Exceptions\PresenterException
     */
    public function includeReplies(ForumThread $thread, ParamBag $params = null)
    {
        $params = $this->parseParams( $params );

        $replies = $this->commentRepository->getBy( $thread, $params[ 'limit' ], $params[ 'order' ] );

        $collection = $this->collection($replies, $this->commentTransformer);

        if($replies instanceof LengthAwarePaginator)
        {
            $replies->setPath($thread->present()->url);
            $replies->appends(\Input::except('page'));
            $collection->setPaginator(new IlluminatePaginatorAdapter($replies));
        }

        return $collection;
    }

    /**
     * @param ForumThread $thread
     * @param ParamBag $params
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTags( ForumThread $thread, ParamBag $params = null )
    {
        $this->parseParams( $params );

        $tags = $this->tags->getBy( $thread, $params[ 'limit' ], $params[ 'order' ] );

        return $this->collection($tags, $this->tagTransformer);
    }

    /**
     * @param ForumThread $thread
     * @return \League\Fractal\Resource\Item
     */
    public function includeCategory(ForumThread $thread)
    {
        $category = $thread->category;

        // This can't be injected because it is dependant on ThreadTransformer
        $categoryTransformer = app()->make('\MyFamily\Transformers\CategoryTransformer');

        return $this->item($category, $categoryTransformer);
    }
}