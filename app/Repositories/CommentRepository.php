<?php namespace MyFamily\Repositories;

use MyFamily\Comment;

class CommentRepository extends Repository {

    protected $polymorphic = 'commentable';

    public function saveTo( $parent, $inputComment )
    {
        $inputComment = $this->stripHtml( $inputComment, [ 'body' ] );
        $comment      = new Comment;

        $comment->owner_id = \Auth::id();
        $comment->commentable()->associate( $parent );
        $comment->body = $inputComment[ 'body' ];

        $comment->save();

        return $comment;
    }

    /**
     * @param $comment
     * @param $updatedComment
     * @return mixed
     */
    public function update( $comment, $updatedComment )
    {
        return $comment->update( $this->stripHtml( $updatedComment, [ 'body' ] ) );
    }
}