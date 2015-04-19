<?php namespace MyFamily\Transformers;

use League\Fractal\TransformerAbstract;
use MyFamily\Tag;

class TagTransformer extends TransformerAbstract {

    public function transform(Tag $tag)
    {
        return [
            'name'  => $tag->name,
            'url'   => $tag->present()->url
        ];
    }
}