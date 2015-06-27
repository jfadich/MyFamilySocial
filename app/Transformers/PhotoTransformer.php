<?php namespace MyFamily\Transformers;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use League\Fractal\ParamBag;
use MyFamily\Album;
use MyFamily\Photo;
use MyFamily\Repositories\CommentRepository;
use MyFamily\Repositories\TagRepository;
use MyFamily\User;

class PhotoTransformer extends Transformer
{
    protected $tags;

    protected $availableIncludes = [
        'comments',
        'parent',
        'owner',
        'tags'
    ];

    protected $defaultIncludes = [
        'owner'
    ];

    protected $permissions = [
        'edit'    => 'EditPhoto',
        'comment' => 'CreateComment'
    ];

    /**
     * @param UserTransformer $userTransformer
     * @param TagTransformer $tagTransformer
     * @param TagRepository $tags
     * @param CommentRepository $comments
     * @param CommentTransformer $commentTransformer
     */
    function __construct(
        UserTransformer $userTransformer,
        TagTransformer $tagTransformer,
        TagRepository $tags,
        CommentRepository $comments,
        CommentTransformer $commentTransformer
    ) {
        $this->userTransformer    = $userTransformer;
        $this->tagTransformer     = $tagTransformer;
        $this->commentTransformer = $commentTransformer;
        $this->comments           = $comments;
        $this->tags               = $tags;
    }

    /**
     * @param Photo $photo
     * @return array
     * @throws \MyFamily\Exceptions\PresenterException
     */
    public function transform( Photo $photo )
    {
        return [
            'id'          => $photo->id,
            'name'        => $photo->name,
            'description' => $photo->description,
            'permissions' => $this->getPermissions( $photo ),
            'image'       => $photo->present()->image,
            'created'     => $photo->created_at->timestamp,
            'type' => 'photo'
        ];
    }

    /**
     * @param Photo $photo
     * @return \League\Fractal\Resource\Item
     */
    public function includeOwner( Photo $photo )
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

        return $this->collection( $tags, $this->tagTransformer );
    }

    /**
     * @param Photo $photo
     * @param ParamBag $params
     * @return \League\Fractal\Resource\Collection
     * @throws \Exception
     */
    public function includeComments( Photo $photo, ParamBag $params = null )
    {
        $this->parseParams( $params );

        $comments = $this->comments->getBy( $photo, $params[ 'limit' ], $params[ 'order' ] );

        $collection = $this->collection( $comments, $this->commentTransformer );

        if ( $comments instanceof LengthAwarePaginator ) {
            $comments->setPath( $photo->present()->url );
            $comments->appends( \Input::except( 'page' ) );
            $collection->setPaginator( new IlluminatePaginatorAdapter( $comments ) );
        }

        return $collection;
    }

    public function includeParent( Photo $photo )
    {
        $parent      = $photo->imageable;
        $transformer = null;

        switch ( get_class( $parent ) ) {
            case User::class:
                $transformer = $this->userTransformer;
                break;
            case Album::class:
                $transformer = app()->make( AlbumTransformer::class );
                break;
            default:
                throw new \Exception( 'Invalid parent' );
        }

        return $this->item( $parent, $transformer );
    }
}