<?php namespace MyFamily\Repositories;

use MyFamily\Traits\Slugify;

abstract class Repository
{

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
}