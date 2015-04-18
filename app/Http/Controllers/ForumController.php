<?php namespace MyFamily\Http\Controllers;

use Illuminate\Http\Response;
use MyFamily\Http\Requests;
use MyFamily\Http\Requests\Forum\EditThreadRequest;
use MyFamily\Http\Requests\Forum\CreateThreadRequest;
use MyFamily\Http\Requests\Forum\CreateThreadReplyRequest;
use League\Fractal\Manager;
use Forum;
use Flash;
use MyFamily\Repositories\TagRepository;
use MyFamily\Transformers\ThreadTransformer;
use Symfony\Component\HttpFoundation\Request;

class ForumController extends ApiController {

	private $tagRepo;

    protected $threadTransformer;

	public function __construct(TagRepository $tagRepo, ThreadTransformer $threadTransformer, Manager $fractal)
	{
        parent::__construct($fractal);

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
        return $this->respondWithCollection(Forum::threads()->getAllThreads(), $this->threadTransformer);
	}

	/**
	 * Return a listing of all threads in the given category
	 *
	 * @param $category
	 */
	public function threadsInCategory($category)
	{
		$threads = Forum::threads()->getThreadByCategory($category->id);

        return $this->respondWithCollection($threads, $this->threadTransformer);
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
	 * @param CreateThreadReplyRequest $request
	 * @return \MyFamily\Comment
	 */
	public function addReply($thread, CreateThreadReplyRequest $request)
	{
        $reply = Forum::threads()->createThreadReply( $thread, $request->all() );

        Flash::success('Reply added successfully');

        $replies = $thread->replies()->paginate( 10 );
        $url = $thread->present()->url . '?page=' . $replies->lastPage() . '#comment-' . $reply->id;

        return redirect( $url );
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
