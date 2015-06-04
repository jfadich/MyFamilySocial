<?php namespace MyFamily\Repositories;

use MyFamily\Comment;

class CommentRepository extends Repository {

    public function getBy($parent, $itemCount = null)
    {
        return Comment::where('commentable_type', get_class($parent))->where('commentable_id', $parent->id)->paginate($this->perPage($itemCount));
    }
}