<?php namespace MyFamily\Transformers;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use League\Fractal\TransformerAbstract;
use MyFamily\ForumCategory;

class CategoryTransformer extends TransformerAbstract {

    protected $threadTransformer;

    protected $availableIncludes = [ 'threads' ];

    function __construct(ThreadTransformer $threadTransformer)
    {
        $this->threadTransformer      = $threadTransformer;
    }

    public function transform(ForumCategory $category)
    {
        return [
            'id'  => $category->id,
            'name'  => $category->name,
            'description' => $category->description,
            'url'   => $category->present()->url('show'),
            'slug'   => $category->slug,
            'icon' => $category->icon,
            'created'   => $category->created_at->timestamp,
            'modified'  => $category->updated_at->timestamp
        ];
    }

    public function includeThreads(ForumCategory $category)
    {
        $threads = $category->threads()->orderBy('last_reply', 'desc')->paginate(5);

        $collection = $this->collection($threads, $this->threadTransformer);

        if($threads instanceof LengthAwarePaginator)
        {
            $threads->setPath($category->present()->url);
            $threads->appends(\Input::except('page'));
            $collection->setPaginator(new IlluminatePaginatorAdapter($threads));
        }

        return $collection;
    }
}