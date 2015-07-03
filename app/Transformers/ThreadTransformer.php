<?php namespace MyFamily\Transformers;

use League\Fractal\ParamBag;
use MyFamily\ForumThread;
use MyFamily\Repositories\CommentRepository;
use MyFamily\Repositories\TagRepository;

class ThreadTransformer extends Transformer {

    protected $availableIncludes = [
        'owner',
        'comments',
        'tags',
        'category'
    ];

    protected $permissions = [
        'edit'    => 'EditForumThread',
        'delete'  => 'DeleteForumThread',
        'comment' => 'CreateThreadReply'
    ];

    /**
     * @param UserTransformer $userTransformer
     * @param CommentTransformer $commentTransformer
     * @param TagTransformer $tagTransformer
     * @param CommentRepository $comments
     * @param TagRepository $tagRepository
     */
    function __construct(
        UserTransformer $userTransformer,
        CommentTransformer $commentTransformer,
        TagTransformer $tagTransformer,
        CommentRepository $comments,
        TagRepository $tagRepository
    )
    {
        $this->userTransformer          = $userTransformer;
        $this->commentTransformer       = $commentTransformer;
        $this->tagTransformer           = $tagTransformer;
        $this->comments = $comments;
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
            'reply_count' => $thread->replies()->count(),
            'created'        => $thread->created_at->timestamp,
            'freshness'      => $thread->last_reply !== null ? $thread->last_reply->timestamp : $thread->created_at->timestamp,
            'updated'        => $thread->updated_at->timestamp,
            'permissions' => $this->getPermissions( $thread ),
            'sticky' => (bool)$thread->sticky,
            'type'        => 'thread'
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
        $categoryTransformer = app()->make( CategoryTransformer::class );

        return $this->item($category, $categoryTransformer);
    }
}