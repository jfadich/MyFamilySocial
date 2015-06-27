<?php namespace MyFamily\Repositories;

use MyFamily\Comment;

class CommentRepository extends Repository {

    protected $polymorphic = 'commentable';

}