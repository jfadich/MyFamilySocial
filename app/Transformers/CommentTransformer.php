<?php namespace MyFamily\Transformers;

use League\Fractal\TransformerAbstract;
use MyFamily\Comment;

class CommentTransformer extends TransformerAbstract {

    protected $availableIncludes = [ 'owner' ];

    function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer      = $userTransformer;
    }

    public function transform(Comment $comment)
    {
        return [
            'body'  => $comment['body'],
            'created' => $comment['created_at']->timestamp,
            'modified' => $comment['updated_at']->timestamp
        ];
    }

    public function includeOwner(Comment $comment)
    {
        $owner = $comment->owner;

        return $this->item($owner, $this->userTransformer);
    }
}