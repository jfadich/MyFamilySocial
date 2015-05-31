<?php namespace MyFamily\Transformers;

use MyFamily\Album;

class AlbumTransformer extends Transformer
{
    protected $userTransformer;

    protected $photoTransformer;

    protected $availableIncludes = [
        'owner',
        'photos',
    ];

    protected $permissions = [
        'edit'   => 'EditPhotoAlbum',
        'delete' => 'DeletePhotoAlbum'
    ];

    function __construct(UserTransformer $userTransformer, PhotoTransformer $photoTransformer)
    {
        $this->userTransformer          = $userTransformer;
        $this->photoTransformer         = $photoTransformer;
    }

    public function transform(Album $album)
    {
        return [
            'id'            => $album->id,
            'name'          => $album->name,
            'description'   => $album->description,
            'slug'          => $album->slug,
            'shared'        => $album->shared,
            'created'       => $album->created_at->timestamp,
            'updated'       => $album->updated_at->timestamp,
            'permissions'    => $this->getPermissions($album)
        ];
    }

    public function includeOwner(Album $album)
    {
        $owner = $album->owner;

        return $this->item($owner, $this->userTransformer);
    }

    public function includePhotos(Album $album)
    {
        $photos = $album->photos()->paginate(12);

        return $this->collection($photos, $this->photoTransformer);
    }
}