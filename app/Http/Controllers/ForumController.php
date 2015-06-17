<?php namespace MyFamily\Http\Controllers;

use MyFamily\Http\Requests\Forum\CreateThreadReplyRequest;
use MyFamily\Http\Requests\Forum\CreateThreadRequest;
use MyFamily\Http\Requests\Forum\EditThreadRequest;
use MyFamily\Transformers\CommentTransformer;
use MyFamily\Transformers\ThreadTransformer;
use MyFamily\Repositories\TagRepository;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use Forum;

class ForumController extends ApiController {

	private $tagRepo;

    protected $threadTransformer;

    protected $availableIncludes = [ 'owner','replies','category','tags' ];

    protected $eagerLoad = [ 'owner', 'category', 'replies.owner' ];

    /**
     * @param TagRepository $tagRepo
     * @param ThreadTransformer $threadTransformer
     * @param Manager $fractal
     * @param Request $request
     * @throws \MyFamily\Exceptions\InvalidRelationshipException
     */
    public function __construct(
        TagRepository $tagRepo,
        ThreadTransformer $threadTransformer,
        Manager $fractal,
        Request $request
    )
	{
        parent::__construct($fractal, $request);

        $this->threadTransformer = $threadTransformer;
		$this->tagRepo = $tagRepo;
	}

	/**
	 * Return a listing of all threads.
	 *
	 */
	public function index()
	{
        return $this->respondWithCollection(Forum::threads($this->eagerLoad)->getAllThreads(), $this->threadTransformer);
	}

    /**
     * Return the requested thread.
     *
     * @param  string $slug
     * @return Response
     */
	public function showThread($slug)
	{
        $thread = Forum::threads($this->eagerLoad)->getThread( $slug );

        return $this->respondWithItem($thread, $this->threadTransformer);
	}

    /**
     * Store a newly created thread in storage.
     * CreateThreadRequest validates input and authorization
     *
     * @param CreateThreadRequest $request
     * @return Response
     */
	public function store(CreateThreadRequest $request)
	{
        $thread = Forum::threads()->createThread($request->all());

        return $this->respondCreated($thread, $this->threadTransformer);
	}

	/**
	 * Update the specified thread in storage.
	 *
	 * @param  string $thread
	 * @param EditThreadRequest $request
	 * @return Response
	 */
	public function update($thread, EditThreadRequest $request)
	{
        $thread = Forum::threads()->getThread( $thread );

		$thread = Forum::threads()->updateThread($thread, $request->all());

        $meta['status'] = 'success';

        return $this->respondWithItem($thread, $this->threadTransformer,$meta);
	}

    /**
     * Create a comment and save it to the specified thread
     *
     * @param $thread
     * @param CreateThreadReplyRequest $request
     * @param CommentTransformer $transformer
     * @return \MyFamily\Comment
     * @internal param $ Request|CreateThreadReplyRequest
     */
	public function addReply($thread, CreateThreadReplyRequest $request, CommentTransformer $transformer)
	{
        $thread = Forum::threads()->getThread($thread);

        $reply = Forum::threads()->createThreadReply( $thread, $request->all() );

        return $this->respondCreated($reply, $transformer);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
