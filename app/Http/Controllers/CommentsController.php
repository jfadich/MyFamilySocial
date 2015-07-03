<?php namespace MyFamily\Http\Controllers;

use MyFamily\Comment;
use MyFamily\Repositories\CommentRepository;
use MyFamily\Transformers\CommentTransformer;
use MyFamily\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use League\Fractal\Manager;

class CommentsController extends ApiController {

    private $commentTransformer;

    private $comments;

    protected $availableIncludes = [ 'owner' ];

    protected $eagerLoad = [ 'owner' ];

    /**
     * @param CommentTransformer $commentTransformer
     * @param Manager $fractal
     * @param Request $request
     * @param CommentRepository $comments
     */
    public function __construct(
        CommentTransformer $commentTransformer,
        Manager $fractal,
        Request $request,
        CommentRepository $comments
    )
    {
        parent::__construct($fractal, $request);

        $this->comments = $comments;
        $this->commentTransformer = $commentTransformer;
    }

    public function store( CommentRequest $request )
    {
        $parent = $this->getModelClass( $request->get( 'parent_type' ) );
        $parent = new $parent;
        $parent = $parent->findOrFail( $request->get( 'parent_id' ) );

        $comment = $this->comments->saveTo( $parent, $request->only( 'body' ) );

        return $this->respondCreated( $comment, $this->commentTransformer );
    }

    /**
     * @param $comment
     * @param CommentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroy( $comment, CommentRequest $request )
    {
        $comment = Comment::destroy( $comment );

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
        $comment = Comment::findOrFail( $comment );

        $this->comments->update( $comment, $request->all() );

        return $this->respondWithItem( $comment, $this->commentTransformer, [ 'status' => 'success' ] );
    }

    /**
     * @param $comment
     * @return mixed
     */
    public function show($comment)
    {
        $comment = Comment::findOrFail( $comment );

        return $this->respondWithItem($comment, $this->commentTransformer);
    }

    public function showBy( $type, $id )
    {
        $parent   = $this->comments->findByType( $type, $id );
        $comments = $this->comments->getBy( $parent->first(), \Input::get( 'limit' ), \Input::get( 'order' ) );

        return $this->respondWithCollection( $comments, $this->commentTransformer );
    }
}
