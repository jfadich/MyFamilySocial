<?php namespace MyFamily\Http\Controllers;

use MyFamily\Http\Requests\CommentRequest;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use MyFamily\Transformers\CommentTransformer;

class CommentsController extends ApiController {

    private $commentTransformer;

    public function __construct(CommentTransformer $commentTransformer, Manager $fractal, Request $request)
    {
        parent::__construct($fractal, $request);

        $this->commentTransformer = $commentTransformer;
    }

	public function destroy($comment, CommentRequest $request)
    {
        $comment = \MyFamily\Comment::destroy($comment);

        if(!$comment)
            return $this->respondNotFound();

        return $this->respondWithArray(['message' => 'Deleted successfully']);
    }

    public function update($comment, CommentRequest $request)
    {
        $comment = \MyFamily\Comment::findOrFail($comment);

        $comment->update($request->all());

        return $this->respondWithArray(['message' => 'Updated successfully']);
    }

    public function show($comment)
    {
        $comment = \MyFamily\Comment::findOrFail($comment);

        return $this->respondWithItem($comment, $this->commentTransformer);
    }
}
