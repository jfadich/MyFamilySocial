<?php namespace MyFamily\Http\Controllers;

use MyFamily\Http\Controllers\Controller;
use MyFamily\Repositories\TagRepository;
use Illuminate\Http\Request;
use MyFamily\Http\Requests;
use MyFamily\Tag;

class TagsController extends Controller {

    private $tags;

    function __construct(TagRepository $tags)
    {
        $this->tags = $tags;
        $this->middleware('auth');
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

    /**
     * Search for a tag by name
     *
     * @param Request $request
     * @return mixed
     */
	public function search(Request $request)
	{
		$term = $request->get('term');
		$tags = Tag::where('name', 'like', '%'. $term .'%')->get();

		if(count($tags) == 0)
		{
            $returnTags[] = ['id' => $term, 'text' => $term];
		}

		foreach($tags as $tag)
		{
			$returnTags[] = ['id' => $tag->name, 'text' => $tag->name];
		}

		return json_encode($returnTags);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

    /**
     * Display the specified resource.
     *
     * @param $tag
     * @return Response
     */
    public function show($tag)
	{
        $tag = $this->tags->findBySlug( $tag );

        $taggables = $tag->albums()->take( 5 )->get();

        $taggables = $taggables->merge( $tag->forumThreads()->take( 5 )->get() );

        return view( 'tags.listTaggables', ['taggables' => $taggables] );
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
