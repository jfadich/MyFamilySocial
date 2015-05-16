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
        return ForumCategory::with( $this->eagerLoad )->all();
    }

    /**
     * Attempt to get category by Id, if not found search by slug
     *
     * @param $category
     * @return mixed
     */
    public function getCategory($category)
    {
        if(is_numeric($category))
        {
            $catById = ForumCategory::with( $this->eagerLoad )->find($category)->first();

            if( !$catById !== null)
                return $catById->first();
        }

        return $cat = ForumCategory::where('slug', '=', $category)->first();
    }

    public function listThreads($category)
    {
        $category = $this->getCategory($category);

        return $category->threads()->with( $this->eagerLoad )->paginate(10);
    }

}