<?php namespace MyFamily\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use MyFamily\Exceptions\InvalidRelationshipException;
use Illuminate\Routing\Controller as BaseController;
use League\Fractal\Resource\Collection;
use MyFamily\Traits\RespondsWithJson;
use League\Fractal\Resource\Item;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use JWTAuth;

abstract class ApiController extends BaseController {

    use RespondsWithJson;

    /*
     * League\Fractal\Manager Fractal instance for transformations
     */
    private $fractal;

    /*
     * @array Relationships that are allowed to be nested
     */
    protected $availableIncludes = [];

    /*
     * @array Relationships to be queried
     */
    protected $eagerLoad = [];

    protected $defaultIncludes = null;

    /**
     * @param Manager $fractal
     * @param Request $request
     */
    function __construct(Manager $fractal, Request $request)
    {
        $this->middleware('auth');

        $this->fractal = $fractal;

        if(!empty($this->availableIncludes) && $request->has('with'))
        {
            // Let fractal process the include string then compare it with the permitted relations
            $this->fractal->parseIncludes( $request->get('with') );
            $includes = $this->validateIncludes($this->fractal->getRequestedIncludes());
            $this->eagerLoad = array_intersect( $this->eagerLoad, $includes );
        } else {
            $this->eagerLoad = [ ];
        }
    }

    /**
     * Compare requested includes against the allowed relations
     *
     * @param $includes
     * @return array
     * @throws InvalidRelationshipException
     */
    private function validateIncludes($includes)
    {
        $eagerLoad = [];

        foreach ($includes as $item) {
            // Validate the first child, grandchildren allowed up to the fractal depth limit
            $relation = explode('.', $item)[0];
            if(!in_array($relation, $this->availableIncludes) )
                throw new InvalidRelationshipException( 'Requested include: ' . $item . ' is invalid');

            $eagerLoad[] = $item;
        }

        return $eagerLoad;
    }

    /**
     * @param $item
     * @param $callback
     * @param array $meta
     * @return mixed
     */
    protected function respondWithItem($item, $callback, $meta = [])
    {
        $resource = new Item($item, $callback);

        if(!empty($meta))
        {
            foreach($meta as $k => $v)
            {
                $resource->setMetaValue($k, $v);
            }
        }

        $data = $this->fractal->createData($resource);

        return $this->respondWithArray($data->toArray());
    }

    /**
     * @param $collection
     * @param $callback
     * @param array $meta
     * @return mixed
     */
    protected function respondWithCollection( $collection, $callback, $meta = [ ] )
    {
        $resource = new Collection($collection->all(), $callback);

        if ( !empty( $meta ) ) {
            foreach ( $meta as $k => $v ) {
                $resource->setMetaValue( $k, $v );
            }
        }

        if ( $collection instanceof LengthAwarePaginator ) {
            $resource->setPaginator(new IlluminatePaginatorAdapter($collection));
            $collection->appends( \Input::except( 'page' ) );
        }

        $data = $this->fractal->createData($resource);

        return $this->respondWithArray($data->toArray());
    }


    public function getModelClass( $request_name )
    {
        $object_types = [
            'photo'  => \MyFamily\Photo::class,
            'thread' => \MyFamily\ForumThread::class,
        ];

        if ( array_key_exists( $request_name, $object_types ) ) {
            ;
        }

        return $object_types[ $request_name ];

        return false;
    }

}
