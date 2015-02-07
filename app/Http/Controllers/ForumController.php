<?php namespace MyFamily\Http\Controllers;

use MyFamily\Http\Requests;
use MyFamily\Http\Controllers\Controller;
use MyFamily\Http\Requests\Forum\CreateForumThreadRequest;
use MyFamily\Http\Requests\Forum\CreateThreadReplyRequest;
use MyFamily\Repositories\ForumCategoryRepository;
use MyFamily\Repositories\ForumRepository;

class ForumController extends Controller {

	private $forum;

	private $categoryRepo;

	public function __construct(ForumRepository $forum, ForumCategoryRepository $category)
	{
		$this->middleware('auth');
		$this->forum = $forum;
		$this->categoryRepo = $category;
		$categories = $category->getCategories();

		view()->share(['categories' => $categories]);
	}

	/**
	 * Display a listing of all threads.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		$threads = $this->forum->getAllThreads();

		return view('forum.listThreads',['threads' => $threads]);
	}

	/**
	 * @param $category
	 * @return \Illuminate\View\View
	 */
	public function category($category)
	{
		$cat = $this->categoryRepo->getCategory($category);
		$threads = $this->forum->getThreadByCategory($cat->id);

		return view('forum.listThreads',['threads' => $threads, 'category' => $cat]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  string  $category
	 * @param  string  $thread
	 * @return \Illuminate\View\View
	 */
	public function thread($category, $thread)
	{
		$thread = $this->forum->getThread($thread);

		if($category != $thread->category->slug)
		{
			\App::abort(404);
		}

		return view('forum.thread', ['thread' =>$thread]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return view('forum.createThread');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CreateForumThreadRequest $request
	 * @return Response
	 */
	public function store(CreateForumThreadRequest $request)
	{
		$thread = $this->forum->createThread($request->all());

		return redirect($thread->url);
	}

	/**
	 * @param $category
	 * @param $thread
	 * @param CreateThreadReplyRequest $request
	 * @return \MyFamily\Comment
	 */
	public function addReply($category, $thread, CreateThreadReplyRequest $request)
	{
		$thread = $this->forum->getThread($thread);

		if($category != $thread->category->slug)
		{
			\App::abort(404);
		}

		$this->forum->createThreadReply($thread, $request->all());

		return redirect($thread->url);
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
