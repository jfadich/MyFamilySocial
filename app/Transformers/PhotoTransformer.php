<?php namespace MyFamily\Transformers;

use League\Fractal\ParamBag;
use MyFamily\Photo;
use MyFamily\Repositories\TagRepository;

class PhotoTransformer extends Transformer
{
    protected $tags;

    protected $availableIncludes = [
        'owner',
        'tags'
    ];

    /**
     * @param UserTransformer $userTransformer
     * @param TagTransformer $tagTransformer
     * @param TagRepository $tags
     */
    function __construct( UserTransformer $userTransformer, TagTransformer $tagTransformer, TagRepository $tags )
    {
        $this->userTransformer          = $userTransformer;
        $this->tagTransformer           = $tagTransformer;
        $this->tags = $tags;
    }

    /**
     * @param Photo $photo
     * @return array
     * @throws \MyFamily\Exceptions\PresenterException
     */
    public function transform(Photo $photo)
    {
        return [
            'name'      => $photo->name,
            'image' => $photo->present()->image,
            'created'   => $photo->created_at->timestamp,
        ];
    }

    /**
     * @param Photo $photo
     * @return \League\Fractal\Resource\Item
     */
    public function includeOwner(Photo $photo)
    {
        return $this->item( $photo->owner, $this->userTransformer );
    }

    /**
     * @param Photo $photo
     * @param ParamBag $params
     * @return \League\Fractal\Resource\Collection
     * @throws \Exception
     */
    public function includeTags( Photo $photo, ParamBag $params = null )
    {
        $this->parseParams( $params );

        $tags = $this->tags->getBy( $photo, $params[ 'limit' ], $params[ 'order' ] );

        return $this->collection($tags, $this->tagTransformer);
    }
}