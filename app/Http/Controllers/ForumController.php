<?php namespace MyFamily\Http\Controllers;

use MyFamily\Http\Requests;
use MyFamily\Http\Controllers\Controller;
use MyFamily\Http\Requests\Forum\EditThreadRequest;
use MyFamily\Http\Requests\Forum\CreateThreadRequest;
use MyFamily\Http\Requests\Forum\CreateThreadReplyRequest;
use Forum;
use Flash;
use MyFamily\Repositories\TagRepository;

class ForumController extends Controller {

	private $tagRepo;

	public function __construct(TagRepository $tagRepo)
	{
		$this->tagRepo = $tagRepo;
		$this->middleware('auth');
	}

	/**
	 * Display a listing of all threads.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return view('forum.listThreads',['threads' => Forum::threads()->getAllThreads()]);
	}

	/**
	 * Display a listing of all threads in the given category
	 *
	 * @param $category
	 * @return \Illuminate\View\View
	 */
	public function threadsInCategory($category)
	{
		$threads = Forum::threads()->getThreadByCategory($category->id);

		return view('forum.listThreads',['threads' => $threads, 'category' => $category]);
	}

    public function threadsByTag($tag)
    {
        $threads = Forum::threads()->getThreadsByTag($tag);

        return view('forum.listThreads', ['threads' => $threads]);
    }

	/**
	 * Display the given thread.
	 *
	 * @param  string  $thread
	 * @return \Illuminate\View\View
	 */
	public function showThread($thread)
	{
		return view('forum.thread', ['thread' => $thread]);
	}

	/**
	 * Show the form for creating a new thread.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return view('forum.createThread');
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

        Flash::success('Topic "' . $thread->title . '" created successfully,');

		return redirect($thread->url);
	}

	/**
	 * Show the form for editing the specified thread.
	 * EditThreadRequest validates input and authorization
	 *
	 * @param $thread
	 * @param EditForumThreadRequest|EditThreadRequest $request
	 * @return Response
	 * @internal param string $id
	 */
	public function edit($thread, EditThreadRequest $request)
	{
		return view('forum.threadEdit', ['thread' => $thread]);
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

        Flash::success('Topic "' . $thread->title . '" updated successfully,');

		return redirect($thread->url);
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
		Forum::threads()->createThreadReply($thread, $request->all());

        Flash::success('Reply added successfully');

        return redirect( $thread->url . '?page=' . $thread->replies()->paginate( 10 )->lastPage() );
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
