<?php namespace MyFamily\Repositories;

use MyFamily\Traits\Slugify;

abstract class Repository
{
    protected $perPageDefault = 10;

    protected $requestLimit = 1000;

    protected function saveTags($tags, &$model)
    {
        if (is_string( $tags )) {
            $tags = explode( ',', $tags );
        }

        if (!is_array( $tags ) || !isset( $this->tagRepo )) {
            return false;
        }

        foreach ($tags as $tag) {
            $tag = $this->tagRepo->findOrCreate( $tag );
            if ($tag) {
                $model->tags()->save( $tag );
            }
        }

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
        if($itemCount === null || !is_numeric($itemCount))
            return $this->perPageDefault;

        return min($itemCount, $this->requestLimit);
    }
}