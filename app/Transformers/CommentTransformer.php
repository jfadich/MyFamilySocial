<?php namespace MyFamily\Transformers;

use League\Fractal\TransformerAbstract;
use MyFamily\Comment;

class CommentTransformer extends TransformerAbstract {

    public function transform(Comment $comment)
    {
        return [
            'body'  => $comment['body'],
            'created' => $comment['created_at']->timestamp,
            'modified' => $comment['updated_at']->timestamp
        ];
    }
}