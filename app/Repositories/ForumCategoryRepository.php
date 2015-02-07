<?php namespace MyFamily\Repositories;

use MyFamily\ForumCategory;

class ForumCategoryRepository extends Repository {

    /**
     *  Get all categories
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCategories()
    {
        return ForumCategory::all();
    }

    /**
     * Get a single category by id or slug
     *
     * @param $category
     * @return mixed
     */
    public function getCategory($category)
    {
        if(is_numeric($category))
            return ForumCategory::findOrFail($category)->first();

        return $cat = ForumCategory::where('slug', '=', $category)->first();
    }

}