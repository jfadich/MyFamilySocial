<?php namespace MyFamily\Repositories;

use MyFamily\Activity;
use MyFamily\Comment;
use MyFamily\Exceptions\InvalidEntityException;

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

    public function destroy( $comment )
    {
        if ( is_numeric( $comment ) ) {
            $comment = Comment::findOrFail( $comment );
        } else {
            if ( !$comment instanceof Comment ) {
                throw new InvalidEntityException;
            }
        }

        Activity::where( 'target_type', Comment::class )->where( 'target_id', $comment->id )->delete();
        Activity::where( 'subject_type', Comment::class )->where( 'subject_id', $comment->id )->delete();

        return Comment::destroy( $comment->id );
    }
}