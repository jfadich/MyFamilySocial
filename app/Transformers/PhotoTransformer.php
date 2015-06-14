<?php namespace MyFamily\Transformers;

use MyFamily\Photo;

class PhotoTransformer extends Transformer
{
    protected $availableIncludes = [
        'owner',
        'tags'
    ];

    function __construct(UserTransformer $userTransformer, TagTransformer $tagTransformer)
    {
        $this->userTransformer          = $userTransformer;
        $this->tagTransformer           = $tagTransformer;
    }

    public function transform(Photo $photo)
    {
        return [
            'name'      => $photo->name,
            'image'     => $this->getImageArray($photo),
            'created'   => $photo->created_at->timestamp,
        ];
    }

    public function includeOwner(Photo $photo)
    {
        $owner = $photo->owner;

        return $this->item($owner, $this->userTransformer);
    }

    public function includeTags(Photo $photo)
    {
        $tags = $photo->tags()->get();

        return $this->collection($tags, $this->tagTransformer);
    }
}