<?php namespace MyFamily\Http\Controllers;

use MyFamily\Repositories\ThreadRepository;
use MyFamily\Transformers\TagTransformer;
use MyFamily\Repositories\TagRepository;
use Illuminate\Http\Request;
use MyFamily\Http\Requests;
use League\Fractal\Manager;
use MyFamily\Tag;

class TagsController extends ApiController {

    /*
     * \MyFamily\Repositories\TagRepository
     */
    private $tags;

    /**
     * @param TagRepository $tagRepo
     * @param TagTransformer $tagTransformer
     * @param Manager $fractal
     * @param Request $request
     * @throws \MyFamily\Exceptions\InvalidRelationshipException
     */
    public function __construct(TagRepository $tagRepo, TagTransformer $tagTransformer, Manager $fractal, Request $request)
    {
        parent::__construct($fractal, $request);

        $this->tagTransformer = $tagTransformer;
        $this->tags = $tagRepo;
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

		return $this->respondWithCollection($tags, $this->tagTransformer);
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
        $tag = $this->tags->find( $tag, ['photos', 'albums', 'forumThreads'] );

        return view( 'tags.listTaggables', ['taggables' => $this->tags->getTaggables( $tag ), 'tag' => $tag] );
        dd( Tag::with( ['photos', 'albums', 'forumThreads'] )->take( 20 )->get() );

        $taggables = $tag->albums()->take( 5 )->get();

        $taggables = $taggables->merge( $tag->forumThreads()->take( 5 )->get() );

        return view( 'tags.listTaggables', ['taggables' => $taggables, 'tag' => $tag] );
	}


	public function listThread($tag, ThreadRepository $threads)
	{
		$threads = $threads->getThreadsByTag($tag);

		return $this->respondWithCollection($threads, $this->threadTransformer);
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
