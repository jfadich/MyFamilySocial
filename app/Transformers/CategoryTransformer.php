<?php namespace MyFamily\Transformers;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use MyFamily\Repositories\ThreadRepository;
use League\Fractal\ParamBag;
use MyFamily\ForumCategory;

class CategoryTransformer extends Transformer
{

    protected $threadTransformer;

    protected $threadRepository;

    protected $availableIncludes = [ 'threads' ];

    protected $orderColumns = [
        'created'   => 'created_at',
        'updated'   => 'updated_at',
        'freshness' => 'last_reply'
    ];

    /**
     * @param ThreadTransformer $threadTransformer
     * @param ThreadRepository $threadRepository
     */
    function __construct( ThreadTransformer $threadTransformer, ThreadRepository $threadRepository )
    {
        $this->threadRepository  = $threadRepository;
        $this->threadTransformer = $threadTransformer;
    }

    /**
     * @param ForumCategory $category
     * @return array
     * @throws \MyFamily\Exceptions\PresenterException
     */
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

    /**
     * @param ForumCategory $category
     * @param ParamBag $params
     * @return \League\Fractal\Resource\Collection
     * @throws \MyFamily\Exceptions\PresenterException
     */
    public function includeThreads( ForumCategory $category, ParamBag $params = null )
    {
        $params = $this->parseParams( $params );

        $threads = $this->threadRepository->getThreadByCategory( $category, $params[ 'limit' ], $params[ 'order' ] );

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