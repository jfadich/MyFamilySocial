<?php namespace MyFamily\Http\Controllers;

use MyFamily\Transformers\CommentTransformer;
use MyFamily\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use League\Fractal\Manager;

class CommentsController extends ApiController {

    private $commentTransformer;

    protected $availableIncludes = [ 'owner' ];

    protected $eagerLoad = [ 'owner' ];

    /**
     * @param CommentTransformer $commentTransformer
     * @param Manager $fractal
     * @param Request $request
     * @throws \MyFamily\Exceptions\InvalidRelationshipException
     */
    public function __construct(CommentTransformer $commentTransformer, Manager $fractal, Request $request)
    {
        parent::__construct($fractal, $request);

        $this->commentTransformer = $commentTransformer;
    }

    /**
     * @param $comment
     * @param CommentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroy( $comment, CommentRequest $request )
    {
        $comment = \MyFamily\Comment::destroy($comment);

        if(!$comment)
            return $this->respondNotFound();

        return $this->respondWithArray(['message' => 'Deleted successfully']);
    }

    /**
     * @param $comment
     * @param CommentRequest $request
     * @return mixed
     */
    public function update($comment, CommentRequest $request)
    {
        $comment = \MyFamily\Comment::findOrFail($comment);

        $comment->update($request->all());

        return $this->respondWithArray(['message' => 'Updated successfully']);
    }

    /**
     * @param $comment
     * @return mixed
     */
    public function show($comment)
    {
        $comment = \MyFamily\Comment::findOrFail($comment);

        return $this->respondWithItem($comment, $this->commentTransformer);
    }
}
