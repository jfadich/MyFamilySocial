<?php namespace MyFamily\Repositories;

use MyFamily\ForumCategory;

class ForumCategoryRepository extends Repository {

    /**
     *  Get all categories
     *
     * @param null $count
     * @param null $order
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCategories( $count = null, $order = null )
    {
        if ( $order === null ) {
            list( $orderCol, $orderBy ) = $this->defaultOrder;
        } else {
            list( $orderCol, $orderBy ) = $order;
        }

        return ForumCategory::with( $this->eagerLoad )
            ->orderBy( $orderCol, $orderBy )
            ->paginate( $this->perPage( $count ) );
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

        return ForumCategory::where( 'slug', '=', $category )->firstOrFail();
    }

    /**
     * @param $category
     * @param null $count
     * @param null $order
     * @return mixed
     */
    public function listThreads( $category, $count = null, $order = null)
    {
        if ( $order === null )
            list( $orderCol, $orderBy ) = $this->defaultOrder;
        else
            list( $orderCol, $orderBy ) = $order;

        $category = $this->getCategory($category );

        return $category->threads()
            ->with( $this->eagerLoad )
            ->orderBy( $orderCol, $orderBy )
            ->paginate( $this->perPage( $count ));
    }
}