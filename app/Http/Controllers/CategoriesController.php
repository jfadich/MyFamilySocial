<?php namespace MyFamily\Http\Controllers;

use MyFamily\Http\Requests;
use MyFamily\Http\Controllers\Controller;

use Illuminate\Http\Request;
use MyFamily\Transformers\ThreadTransformer;

class CategoriesController extends ApiController {

	public function index()
    {

    }

    /**
     * Return a listing of all threads in the given category
     *
     * @param $category
     * @param ThreadTransformer $transformer
     * @return
     */
    public function listThreads($category, ThreadTransformer $transformer)
    {
        $threads = Forum::threads()->getThreadByCategory($category->id);

        return $this->respondWithCollection($threads, $transformer);
    }


}
