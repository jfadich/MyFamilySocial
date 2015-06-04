<?php namespace MyFamily\Transformers;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use League\Fractal\ParamBag;
use MyFamily\ForumThread;
use MyFamily\Repositories\CommentRepository;

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


    function __construct(UserTransformer $userTransformer, CommentTransformer $commentTransformer, TagTransformer $tagTransformer, CommentRepository $commentRepository)
    {
        $this->userTransformer          = $userTransformer;
        $this->commentTransformer       = $commentTransformer;
        $this->tagTransformer           = $tagTransformer;
        $this->commentRepository        = $commentRepository;
    }

    public function transform(ForumThread $thread)
    {
        return [
            'id'             => $thread->id,
            'title'          => $thread->title,
            'body'           => $thread->body,
            'slug'           => $thread->slug,
            //'reply_count'    => $thread->replyCount,
            'created'        => $thread->created_at->timestamp,
            'freshness'      => $thread->last_reply !== null ? $thread->last_reply->timestamp : $thread->created_at->timestamp,
            'updated'        => $thread->updated_at->timestamp,
            'permissions'    => $this->getPermissions($thread)
        ];
    }

    public function includeOwner(ForumThread $thread)
    {
        $owner = $thread->owner;

        return $this->item($owner, $this->userTransformer);
    }

    public function includeReplies(ForumThread $thread, ParamBag $params = null)
    {
        $replies = $this->commentRepository->getBy($thread, $params['limit'][0]); //$thread->replies()->paginate(5);

        $collection = $this->collection($replies, $this->commentTransformer);

        if($replies instanceof LengthAwarePaginator)
        {
            $replies->setPath($thread->present()->url);
            $replies->appends(\Input::except('page'));
            $collection->setPaginator(new IlluminatePaginatorAdapter($replies));
        }

        return $collection;
    }

    public function includeTags(ForumThread $thread)
    {
        $tags = $thread->tags()->get();

        return $this->collection($tags, $this->tagTransformer);
    }

    public function includeCategory(ForumThread $thread)
    {
        $category = $thread->category()->first();

        // This can't be injected because it is dependant on ThreadTransformer
        $categoryTransformer = app()->make('\MyFamily\Transformers\CategoryTransformer');

        return $this->item($category, $categoryTransformer);
    }
}