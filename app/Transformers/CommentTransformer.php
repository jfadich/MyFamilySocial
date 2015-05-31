<?php namespace MyFamily\Transformers;

use League\Fractal\TransformerAbstract;
use MyFamily\Comment;

class CommentTransformer extends Transformer {

    protected $availableIncludes = [ 'owner' ];

    protected $permissions = [
        'edit'   => 'EditComment',
        'delete' => 'DeleteComment'
    ];

    function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer      = $userTransformer;
    }

    public function transform(Comment $comment)
    {
        return [
            'id'  => $comment['id'],
            'body'  => $comment['body'],
            'created' => $comment['created_at']->timestamp,
            'updated' => $comment['updated_at']->timestamp,
            'permissions' => $this->getPermissions($comment)
        ];
    }

    public function includeOwner(Comment $comment)
    {
        $owner = $comment->owner;

        return $this->item($owner, $this->userTransformer);
    }
}