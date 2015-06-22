<?php namespace MyFamily\Repositories;

use MyFamily\Model;

abstract class Repository
{
    protected $perPageDefault = 10;

    protected $defaultOrder = [ 'created_at', 'desc' ];

    protected $requestLimit = 1000;

    protected $polymorphic = false;

    protected $eagerLoad = [ ];

    /**
     * Parse the tag string then search for each tag creating a new one if not found
     *
     * @param $tags
     * @param $model
     * @return bool
     */
    protected function saveTags($tags, &$model)
    {
        if (is_string( $tags )) {
            $tags = explode( ',', $tags );
        }

        if (!is_array( $tags ) || !isset( $this->tagRepo )) {
            return false;
        }

        $tagList = [ ];
        foreach ($tags as $tag) {
            $tag = $this->tagRepo->findOrCreate( $tag );
            if ( $tag ) {
                $tagList[ ] = $tag->id;
            }
        }

        $model->tags()->sync( $tagList );
    }

    /**
     * Set the relationships to eagerload when fetching resources.
     * @param array $eagerLoad
     */
    public function setEagerLoad($eagerLoad)
    {
        $this->eagerLoad = $eagerLoad;
    }

    /**
     * Return the requested item count or default
     * @param $itemCount
     * @return int
     */
    public function perPage($itemCount)
    {
        if ( $itemCount === null || !is_numeric( $itemCount ) )
            return $this->perPageDefault;

        return min($itemCount, $this->requestLimit);
    }

    /**
     * Get models based on a polymorphic parent
     *
     * @param Model $parent
     * @param null $count
     * @param null $order
     * @return mixed
     * @throws \Exception
     */
    public function getBy( Model $parent, $count = null, $order = null )
    {
        if ( !$this->polymorphic || !method_exists( $this, 'loadModel' ) ) {
            throw new \Exception( "Cannot get children for non-polymorphic parent" );
        }

        if ( $order === null ) {
            list( $orderCol, $orderBy ) = $this->defaultOrder;
        } else {
            list( $orderCol, $orderBy ) = $order;
        }

        return $this->loadModel()
            ->where( "{$this->polymorphic}_type", get_class( $parent ) )
            ->where( "{$this->polymorphic}_id", $parent->id )
            ->orderBy( $orderCol, $orderBy )
            ->paginate( $this->perPage( $count ) );
    }

    public function findByTable( $table, $term, $field = 'id' )
    {
        return \DB::table( $table )->where( $field, $term )->get();
    }
}