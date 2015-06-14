<?php namespace MyFamily\Repositories;

use MyFamily\Comment;
use MyFamily\Model;

class CommentRepository extends Repository {

    /**
     * @param Model $parent
     * @param null $count
     * @return mixed
     */
    public function getBy( Model $parent, $count = null )
    {
        return Comment::where( 'commentable_type', get_class( $parent ) )->where( 'commentable_id',
            $parent->id )->paginate( $this->perPage( $count ) );
    }
}