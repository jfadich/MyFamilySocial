<?php namespace MyFamily\Http\Controllers;

use MyFamily\Transformers\CategoryTransformer;
use MyFamily\Http\Requests;
use Forum;

class CategoriesController extends ApiController {

    protected $availableIncludes = [ 'threads' ];

    /**
     * Return a single category
     *
     * @param CategoryTransformer $categoryTransformer
     * @return mixed
     */
    public function index( CategoryTransformer $categoryTransformer )
    {
        return $this->respondWithCollection(Forum::categories($this->eagerLoad)->getCategories(),$categoryTransformer);
    }

    /**
     * Return a listing of all threads in the given category
     *
     * @param $category
     * @param CategoryTransformer $transformer
     * @return mixed
     */
    public function show($category, CategoryTransformer $transformer)
    {
        $category = Forum::categories($this->eagerLoad)->getCategory($category);

        return $this->respondWithItem($category, $transformer);
    }

}
