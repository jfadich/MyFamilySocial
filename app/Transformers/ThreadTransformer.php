<?php namespace MyFamily\Transformers;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\TransformerAbstract;
use MyFamily\ForumThread;

class ThreadTransformer extends TransformerAbstract {

    protected $availableIncludes = [
        'owner',
        'replies',
        'tags'
    ];

    function __construct(UserTransformer $userTransformer, CommentTransformer $commentTransformer, TagTransformer $tagTransformer)
    {
        $this->userTransformer = $userTransformer;
        $this->commentTransformer = $commentTransformer;
        $this->tagTransformer = $tagTransformer;
    }

    public function transform(ForumThread $thread)
    {
        return [
            'title'     => $thread->title,
            'body'      => $thread->body,
            'url'       => $thread->present()->url(),
            'reply_count' => $thread->replyCount,
            'created'   => $thread->created_at->timestamp,
            'modified'  => $thread->updated_at->timestamp
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

        return $this->collection($replies, $this->commentTransformer);
    }

    public function includeTags(ForumThread $thread)
    {
        $replies = $thread->tags()->get();

        return $this->collection($replies, $this->tagTransformer);
    }
}