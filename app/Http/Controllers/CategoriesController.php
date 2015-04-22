<?php namespace MyFamily\Http\Controllers;

use MyFamily\Http\Requests;
use MyFamily\Http\Controllers\Controller;
use Forum;
use Illuminate\Http\Request;
use MyFamily\Transformers\CategoryTransformer;
use MyFamily\Transformers\ThreadTransformer;

class CategoriesController extends ApiController {

    protected $availableIncludes = [
        'threads' => 'threads',
    ];

	public function index(CategoryTransformer $categoryTransformer)
    {
        return $this->respondWithCollection(Forum::categories()->getCategories(),$categoryTransformer);
    }

    /**
     * Return a listing of all threads in the given category
     *
     * @param $category
     * @param CategoryTransformer $transformer
     */
    public function show($category, CategoryTransformer $transformer)
    {
        $category = Forum::categories()->getCategory($category);

        return $this->respondWithItem($category, $transformer);
    }

}
