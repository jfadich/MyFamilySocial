<?php namespace MyFamily\Http\Controllers;

use MyFamily\Http\Requests;
use MyFamily\Http\Controllers\Controller;
use Forum;
use Illuminate\Http\Request;
use MyFamily\Transformers\CategoryTransformer;
use MyFamily\Transformers\ThreadTransformer;

class CategoriesController extends ApiController {

	public function index(CategoryTransformer $categoryTransformer)
    {
        return $this->respondWithCollection(Forum::categories()->getCategories(),$categoryTransformer);
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
        $threads = Forum::categories()->listThreads($category);

        return $this->respondWithCollection($threads, $transformer);
    }


}
