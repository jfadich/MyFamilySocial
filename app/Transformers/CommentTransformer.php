<?php namespace MyFamily\Transformers;

use MyFamily\Comment;

class CommentTransformer extends Transformer {

    protected $availableIncludes = [ 'owner' ];

    protected $defaultIncludes = [ 'owner' ];

    protected $permissions = [
        'edit'   => 'EditComment',
        'delete' => 'DeleteComment'
    ];

    /**
     * @param UserTransformer $userTransformer
     */
    function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer      = $userTransformer;
    }

    /**
     * @param Comment $comment
     * @return array
     */
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

    /**
     * @param Comment $comment
     * @return \League\Fractal\Resource\Item
     */
    public function includeOwner(Comment $comment)
    {
        return $this->item( $comment->owner, $this->userTransformer );
    }
}