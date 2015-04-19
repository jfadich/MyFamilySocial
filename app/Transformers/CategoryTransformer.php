<?php namespace MyFamily\Transformers;

use League\Fractal\TransformerAbstract;
use MyFamily\ForumCategory;

class CategoryTransformer extends TransformerAbstract {

    public function transform(ForumCategory $category)
    {
        return [
            'name'  => $category->name,
            'description' => $category->description,
            'url'   => $category->present()->url('listThreads'),
            'created'   => $category->created_at->timestamp,
            'modified'  => $category->updated_at->timestamp
        ];
    }
}