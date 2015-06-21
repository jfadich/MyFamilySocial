<?php namespace MyFamily\Transformers;

use MyFamily\Repositories\PhotoRepository;
use League\Fractal\ParamBag;
use MyFamily\Album;

class AlbumTransformer extends Transformer
{
    protected $userTransformer;

    protected $photoTransformer;

    protected $photos;

    protected $availableIncludes = [
        'owner',
        'photos',
    ];

    protected $permissions = [
        'edit'      => 'EditPhotoAlbum',
        'delete'    => 'DeletePhotoAlbum',
        'add_photo' => 'UploadPhotoToAlbum'
    ];

    /**
     * @param UserTransformer $userTransformer
     * @param PhotoTransformer $photoTransformer
     * @param PhotoRepository $photos
     */
    function __construct(
        UserTransformer $userTransformer,
        PhotoTransformer $photoTransformer,
        PhotoRepository $photos
    )
    {
        $this->userTransformer          = $userTransformer;
        $this->photoTransformer         = $photoTransformer;
        $this->photos = $photos;
    }

    /**
     * @param Album $album
     * @return array
     */
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

    /**
     * @param Album $album
     * @return \League\Fractal\Resource\Item
     */
    public function includeOwner(Album $album)
    {
        return $this->item( $album->owner, $this->userTransformer );
    }

    /**
     * @param Album $album
     * @param ParamBag $params
     * @return \League\Fractal\Resource\Collection
     */
    public function includePhotos(Album $album, ParamBag $params = null)
    {
        $params = $this->parseParams( $params );

        $photos = $this->photos->getBy( $album, $params[ 'limit' ], $params[ 'order' ] );

        return $this->collection($photos, $this->photoTransformer);
    }
}