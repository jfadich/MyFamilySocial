<?php namespace MyFamily\Repositories;

abstract class Repository
{
    protected $perPageDefault = 10;

    protected $requestLimit = 1000;

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
        if ( $itemCount === null || !is_int( $itemCount))
            return $this->perPageDefault;

        return min($itemCount, $this->requestLimit);
    }
}