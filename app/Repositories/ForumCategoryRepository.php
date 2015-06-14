<?php namespace MyFamily\Repositories;

use MyFamily\ForumCategory;

class ForumCategoryRepository extends Repository {

    /**
     *  Get all categories
     *
     * @param null $count
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCategories( $count = null )
    {
        return ForumCategory::with( $this->eagerLoad )->paginate( $this->perPage( $count ) );
    }

    /**
     * Attempt to get category by Id, if not found search by slug
     *
     * @param $category
     * @return mixed
     */
    public function getCategory($category)
    {
        if ( is_int( $category ) ) {
            return ForumCategory::with( $this->eagerLoad )->find( $category )->firstOrFail();
        }

        return $cat = ForumCategory::where( 'slug', '=', $category )->firstOrFail();
    }

    public function listThreads( $category, $count = null)
    {
        $category = $this->getCategory($category);

        return $category->threads()->with( $this->eagerLoad )->paginate( $this->perPage( $count ));
    }

}