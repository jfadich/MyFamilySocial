<?php namespace MyFamily\Transformers;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\TransformerAbstract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use MyFamily\ForumThread;

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


    function __construct(UserTransformer $userTransformer, CommentTransformer $commentTransformer, TagTransformer $tagTransformer)
    {
        $this->userTransformer          = $userTransformer;
        $this->commentTransformer       = $commentTransformer;
        $this->tagTransformer           = $tagTransformer;
    }

    public function transform(ForumThread $thread)
    {
        return [
            'title'          => $thread->title,
            'body'           => $thread->body,
            'slug'           => $thread->slug,
            'reply_count'    => $thread->replyCount,
            'created'        => $thread->created_at->timestamp,
            'modified'       => $thread->updated_at->timestamp,
            'permissions'    => $this->getPermissions($thread)
        ];
    }

    public function includeOwner(ForumThread $thread)
    {
        $owner = $thread->owner;

        return $this->item($owner, $this->userTransformer);
    }

    public function includeReplies(ForumThread $thread)
    {
        $replies = $thread->replies()->paginate(5);

        $collection = $this->collection($replies, $this->commentTransformer);

        if($replies instanceof LengthAwarePaginator)
        {
            $replies->setPath($thread->present()->url);
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