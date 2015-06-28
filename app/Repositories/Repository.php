<?php namespace MyFamily\Repositories;

use MyFamily\Exceptions\InvalidRelationshipException;
use MyFamily\ForumThread;
use MyFamily\Comment;
use MyFamily\Photo;
use MyFamily\Album;
use MyFamily\Model;
use MyFamily\Tag;

abstract class Repository
{
    protected $perPageDefault = 10;

    protected $defaultOrder = [ 'created_at', 'desc' ];

    protected $requestLimit = 1000;

    protected $polymorphic = false;

    protected $eagerLoad = [ ];

    /**
     * Parse the tag string then search for each tag creating a new one if not found
     *
     * @param $tags
     * @param $model
     * @return bool
     */
    protected function saveTags($tags, &$model)
    {
        if (is_string( $tags )) {
            $tags = explode( ',', $tags );
        }

        if (!is_array( $tags ) || !isset( $this->tagRepo )) {
            return false;
        }

        $tagList = [ ];
        foreach ($tags as $tag) {
            $tag = $this->tagRepo->findOrCreate( $tag );
            if ( $tag ) {
                $tagList[ ] = $tag->id;
            }
        }

        $model->tags()->sync( $tagList );
    }

    /**
     * Set the relationships to eagerload when fetching resources.
     * @param array $eagerLoad
     */
    public function setEagerLoad($eagerLoad)
    {
        $this->eagerLoad = $eagerLoad;
    }

    /**
     * Return the requested item count or default
     * @param $itemCount
     * @return int
     */
    public function perPage($itemCount)
    {
        if ( $itemCount === null || !is_numeric( $itemCount ) )
            return $this->perPageDefault;

        return min($itemCount, $this->requestLimit);
    }

    /**
     * Get models based on a polymorphic parent
     *
     * @param Model $parent
     * @param null $count
     * @param null $order
     * @return mixed
     * @throws \Exception
     */
    public function getBy( Model $parent, $count = null, $order = null )
    {
        if ( !$this->polymorphic || !method_exists( $this, 'loadModel' ) ) {
            throw new \Exception( "Cannot get children for non-polymorphic parent: " . get_class( $parent ) );
        }

        if ( $order === null ) {
            list( $orderCol, $orderBy ) = $this->defaultOrder;
        } else {
            list( $orderCol, $orderBy ) = $order;
        }

        return $this->loadModel()
            ->where( "{$this->polymorphic}_type", get_class( $parent ) )
            ->where( "{$this->polymorphic}_id", $parent->id )
            ->orderBy( $orderCol, $orderBy )
            ->paginate( $this->perPage( $count ) );
    }

    public function findByType( $type, $term, $field = 'id' )
    {
        return $this->loadModel( $type )->where( $field, $term )->get();
    }

    private function loadModel( $type = null )
    {
        if ( $type === null ) {
            $type = $this->polymorphic;
        }

        switch ( $type ) {
            case 'comment':
            case 'commentable':
                return Comment::with( $this->eagerLoad );
                break;
            case 'photo':
            case 'imageable':
                return Photo::with( $this->eagerLoad );
                break;
            case 'tag':
                return Tag::with( $this->eagerLoad );
                break;
            case 'thread':
                return ForumThread::with( $this->eagerLoad );
                break;
            case 'album':
                return Album::with( $this->eagerLoad );
                break;
            default:
                throw new InvalidRelationshipException( 'Invalid parent type' );
                break;
        }

        return $return;
    }
}