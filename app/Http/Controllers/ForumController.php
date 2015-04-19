<?php namespace MyFamily\Http\Controllers;

use Illuminate\Http\Response;
use MyFamily\Http\Requests\Forum\EditThreadRequest;
use League\Fractal\Manager;
use Forum;
use MyFamily\Repositories\TagRepository;
use MyFamily\Transformers\CommentTransformer;
use MyFamily\Transformers\ThreadTransformer;
use Illuminate\Http\Request;

class ForumController extends ApiController {

	private $tagRepo;

    protected $threadTransformer;

    protected $availableIncludes = [
        'owner' => 'owner',
        'replies' => 'replies',
        'tags' => 'tags'
    ];

    protected $eagerLoad = ['owner'];

	public function __construct(TagRepository $tagRepo, ThreadTransformer $threadTransformer, Manager $fractal, Request $request)
	{
        parent::__construct($fractal, $request);

        $this->threadTransformer = $threadTransformer;
		$this->tagRepo = $tagRepo;
	//	$this->middleware('jwt');
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
        $thread = Forum::threads()->getThread( $slug );

        if( ! $thread )
            return $this->respondNotFound('Thread not found');

        return $this->respondWithItem($thread, $this->threadTransformer);
	}

	/**
	 * Store a newly created thread in storage.
	 * CreateThreadRequest validates input and authorization
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$thread = Forum::threads()->createThread($request->all());

        $meta['status'] = 'success';

        return $this->setStatusCode( Response::HTTP_CREATED )->respondWithItem($thread, $this->threadTransformer,$meta);
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
		$thread = Forum::threads()->updateThread($thread, $request->all());

        $meta['status'] = 'success';

        return $this->respondWithItem($thread, $this->threadTransformer,$meta);
	}

    /**
     * Create a comment and save it to the specified thread
     *
     * @param $thread
     * @param Request $request
     * @param CommentTransformer $transformer
     * @return \MyFamily\Comment
     */
	public function addReply($thread, Request $request, CommentTransformer $transformer)
	{
        $thread = Forum::threads()->getThread($thread);

        if( ! $thread )
            $this->respondNotFound('Thread does not exist');

        $reply = Forum::threads()->createThreadReply( $thread, $request->all() );

        $meta['status'] = 'success';

        return $this->respondWithItem($reply, $transformer,$meta);
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
