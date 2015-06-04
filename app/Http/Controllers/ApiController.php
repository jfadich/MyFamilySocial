<?php namespace MyFamily\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use JWTAuth;
use MyFamily\Errors;
use MyFamily\Exceptions\InvalidRelationshipException;
use MyFamily\Traits\RespondsWithJson;

abstract class ApiController extends BaseController {

    use RespondsWithJson;

    private $fractal;

    protected $availableIncludes = [];

    protected $eagerLoad = [];

    function __construct(Manager $fractal, Request $request)
    {
        $this->middleware('auth');

        $this->fractal = $fractal;

        if(!empty($this->availableIncludes) && $request->has('with'))
        {
            $this->fractal->parseIncludes( $request->get('with') );
            $includes = $this->validateIncludes($this->fractal->getRequestedIncludes());
            if(is_string($includes))
                throw new InvalidRelationshipException('Requested include: '.$includes.' is invalid');
        }
    }

    private function validateIncludes($includes)
    {
        $eagerLoad = [];

        foreach ($includes as $item)
        {
            $relation = explode('.', $item)[0];
            if(!in_array($relation, $this->availableIncludes))
                return $item;// return $this->setErrorCode( Errors::INVALID_RELATIONSHIP)->RespondBadRequest('Requested include: '.$item.' is invalid');

            $eagerLoad[] = $item;
        }

        return $eagerLoad;
    }

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

    protected function respondWithCollection($collection, $callback)
    {
        $resource = new Collection($collection->all(), $callback);

        if($collection instanceof LengthAwarePaginator)
            $resource->setPaginator(new IlluminatePaginatorAdapter($collection));

        $data = $this->fractal->createData($resource);

        return $this->respondWithArray($data->toArray());
    }

}
