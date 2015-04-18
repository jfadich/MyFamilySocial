<?php namespace MyFamily\Transformers;

use League\Fractal\TransformerAbstract;
use MyFamily\ForumThread;

class ThreadTransformer extends TransformerAbstract {

    protected $availableIncludes = [
        'owner',
        'replies'
    ];

    function __construct(UserTransformer $userTransformer, CommentTransformer $commentTransformer)
    {
        $this->userTransformer = $userTransformer;
        $this->commentTransformer = $commentTransformer;
    }

    public function transform(ForumThread $thread)
    {
        return [
            'title'     => $thread->title,
            'body'      => $thread->body,
            'url'       => $thread->present()->url(),
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
}