<?php
namespace MyFamily\Transformers;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use League\Fractal\ParamBag;
use League\Fractal\TransformerAbstract;
use MyFamily\Model;

abstract class Transformer extends TransformerAbstract
{

    protected $orderColumns = [
        'created' => 'created_at',
        'updated' => 'updated_at'
    ];

    /**
     * Max number of resources that can be requested
     *
     * @var int
     */
    protected $requestLimit = 1000;

    /**
     * Get an array of the permissions the current user has on the requested resource
     *
     * @param null $subject
     * @return array|null
     */
    protected function getPermissions($subject = null)
    {
        if(!isset($this->permissions))
            return null;

        $permissions = [];

        foreach($this->permissions as $api => $permission)
        {
            $permissions[$api] = \UAC::canCurrentUser($permission, $subject);
        }

        return $permissions;
    }

    /**
     * Parse the limit and order parameters
     *
     * @param ParamBag $params
     * @return array
     */
    protected function parseParams( ParamBag $params = null )
    {
        $result = [ 'limit' => null, 'order' => null ];

        if ( $params === null ) {
            return $result;
        }

        $order = $params->get( 'order' );
        $limit = $params->get( 'limit' );

        if ( is_numeric( $limit[ 0 ] ) ) {
            $result[ 'limit' ] = min( $limit[ 0 ], $this->requestLimit );
        }

        if ( is_array( $order ) && count( $order ) === 2 ) {
            if ( in_array( $order[ 0 ], array_keys( $this->orderColumns ) ) && in_array( $order[ 1 ],
                    [ 'desc', 'asc' ] )
            ) {
                $order[ 0 ]        = $this->orderColumns[ $order[ 0 ] ];
                $result[ 'order' ] = $order;
            }
        }

        return $result;
    }

    /**
     * @param Model $parent
     * @param ParamBag $params
     * @return \League\Fractal\Resource\Collection
     * @internal param Photo $photo
     */
    public function includeComments( Model $parent, ParamBag $params = null )
    {
        if ( !in_array( 'comments', $this->availableIncludes ) ) {
            return false;
        }

        $this->parseParams( $params );

        $comments = $this->comments->getBy( $parent, $params[ 'limit' ], $params[ 'order' ] );

        $collection = $this->collection( $comments, $this->commentTransformer );

        if ( $comments instanceof LengthAwarePaginator ) {
            $comments->setPath( $parent->present()->url );
            $comments->appends( \Input::except( 'page' ) );
            $collection->setPaginator( new IlluminatePaginatorAdapter( $comments ) );
        }

        return $collection;
    }
}