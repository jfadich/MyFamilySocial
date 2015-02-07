<?php namespace MyFamily\Http\Controllers;

use Illuminate\Support\Facades\Input;
use MyFamily\ForumCategory;
use MyFamily\ForumThread;
use MyFamily\Http\Requests;
use MyFamily\Http\Controllers\Controller;
use MyFamily\Http\Requests\Forum\CreateForumThreadRequest;

class ForumController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');

		$categories = ForumCategory::all();

		view()->share(['categories' => $categories]);
	}

	/**
	 * Display a listing of all threads.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		$threads =  ForumThread::with('category', 'owner')->paginate(10);

		return view('forum.listThreads',['threads' => $threads]);
	}

	/**
	 * @param $category
	 * @return \Illuminate\View\View
	 */
	public function category($category)
	{
		$cat = ForumCategory::where('slug', '=', $category)->first();
		$threads = ForumThread::with('owner')->where('category_id', '=', $cat->id)->paginate(10);
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
		$thread = ForumThread::where('slug', '=', $thread)->with('replies')->first();

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
		return Input::get();
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
